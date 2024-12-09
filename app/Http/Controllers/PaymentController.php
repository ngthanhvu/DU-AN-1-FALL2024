<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $vnp_TmnCode = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url = config('services.vnpay.url');
        $vnp_ReturnUrl = url('/api/payment/callback');

        $vnp_TxnRef = $request->order_id;
        $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $vnp_TxnRef;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        $vnp_CreateDate = now()->format('YmdHis');

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);

        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . rtrim($query, '&');

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        return response()->json(['url' => $vnp_Url]);
    }


    // VnpayController callback function
    // public function callback(Request $request)
    // {
    //     $vnp_HashSecret = config('services.vnpay.hash_secret');
    //     $inputData = $request->all();
    //     $vnp_SecureHash = $inputData['vnp_SecureHash'];

    //     unset($inputData['vnp_SecureHashType']);
    //     unset($inputData['vnp_SecureHash']);

    //     ksort($inputData);

    //     $hashData = '';
    //     foreach ($inputData as $key => $value) {
    //         $hashData .= ($hashData ? '&' : '') . urlencode($key) . "=" . urlencode($value);
    //     }

    //     $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    //     if ($secureHash === $vnp_SecureHash) {
    //         $order = Order::where('id', $inputData['vnp_TxnRef'])->first();

    //         if ($order) {
    //             $order->status = 'paid';
    //             $order->save();

    //             // Lấy các order details dựa trên order_id
    //             $orderDetails = $order->orderDetails; // Giả sử bạn có quan hệ 'orderDetails' trong model Order

    //             // Kiểm tra và giảm số lượng sản phẩm trong kho
    //             foreach ($orderDetails as $orderDetail) {
    //                 $product = $orderDetail->product; // Lấy thông tin sản phẩm
    //                 if ($product) {
    //                     // Giảm số lượng của sản phẩm trong kho
    //                     $product->quantity -= $orderDetail->quantity; // Giảm số lượng theo số lượng đã mua
    //                     $product->save(); // Lưu thay đổi vào cơ sở dữ liệu
    //                 }
    //             }

    //             $user = $order->user;

    //             if ($user && !empty($user->email)) {
    //                 $order->email = $user->email;
    //                 Mail::to($order->email)->send(new PaymentConfirmation($order));
    //             }
    //             $frontendUrl = "http://localhost:5173/thanh-cong?status={$inputData['vnp_ResponseCode']}&order_id={$inputData['vnp_TxnRef']}";
    //             return redirect()->to($frontendUrl);
    //         } else {
    //             $frontendUrl = "http://localhost:5173/thanh-cong?status=01&order_id={$inputData['vnp_TxnRef']}";
    //             return redirect()->to($frontendUrl);
    //         }
    //     } else {
    //         $frontendUrl = "http://localhost:5173/thanh-cong?status=01&order_id={$inputData['vnp_TxnRef']}";
    //         return redirect()->to($frontendUrl);
    //     }
    // }

    public function callback(Request $request)
    {
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);

        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= ($hashData ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            $order = Order::where('id', $inputData['vnp_TxnRef'])->first();

            if ($order) {
                $responseCode = $inputData['vnp_ResponseCode'];

                if ($responseCode === "00") {
                    $order->status = 'paid';
                    $order->save();

                    // Cập nhật kho hàng
                    $orderDetails = $order->orderDetails;
                    foreach ($orderDetails as $orderDetail) {
                        $product = $orderDetail->product;
                        if ($product) {
                            $product->quantity -= $orderDetail->quantity;
                            $product->save();
                        }
                    }

                    // Gửi email xác nhận
                    $user = $order->user;
                    if ($user && !empty($user->email)) {
                        $order->email = $user->email;
                        Mail::to($order->email)->send(new PaymentConfirmation($order));
                    }

                    $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=00&order_id={$inputData['vnp_TxnRef']}";
                    return redirect()->to($frontendUrl);
                } else {
                    $order->status = ($responseCode === "24") ? 'canceled' : 'fail';
                    $order->save();

                    $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status={$responseCode}&order_id={$inputData['vnp_TxnRef']}";
                    return redirect()->to($frontendUrl);
                }
            } else {
                $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=01&order_id={$inputData['vnp_TxnRef']}";
                return redirect()->to($frontendUrl);
            }
        } else {
            $frontendUrl = "http://localhost:5173/thanh-cong?status=01&order_id={$inputData['vnp_TxnRef']}";
            return redirect()->to($frontendUrl);
        }
    }
}
