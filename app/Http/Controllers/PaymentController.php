<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        // Định nghĩa thông tin VNPay
        $vnp_TmnCode = config('services.vnpay.tmn_code'); // TMN Code của bạn
        $vnp_HashSecret = config('services.vnpay.hash_secret'); // Hash Secret của bạn
        $vnp_Url = config('services.vnpay.url'); // URL VNPay
        $vnp_ReturnUrl = url('/api/payment/callback'); // URL trả về

        // Khởi tạo các tham số yêu cầu
        $vnp_TxnRef = $request->order_id; // Số tham chiếu giao dịch
        $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $vnp_TxnRef; // Thông tin đơn hàng
        $vnp_OrderType = 'billpayment'; // Loại đơn hàng
        $vnp_Amount = $request->amount * 100; // Chuyển đổi số tiền sang VND
        $vnp_Locale = 'vn'; // Ngôn ngữ
        $vnp_IpAddr = $request->ip(); // Địa chỉ IP của người dùng
        $vnp_CreateDate = now()->format('YmdHis'); // Thời gian hiện tại

        // Tạo mảng dữ liệu yêu cầu
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

        // Sắp xếp mảng theo thứ tự từ điển và tạo URL thanh toán
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
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'fail']);
        }
    }
}
