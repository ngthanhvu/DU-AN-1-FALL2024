<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;
use App\Models\Order;

class MomoController extends Controller
{
    public function create(Request $request)
    {
        $partnerCode = 'MOMO';
        $accessKey = 'F8BBA842ECF85';
        $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';

        $requestId = $partnerCode . time();
        $orderId = $request->order_id;
        $orderInfo = 'pay with MoMo';
        $redirectUrl = url('api/momo/callback');
        $ipnUrl = url('api/momo/callback');
        $requestType = 'captureWallet';
        $extraData = '';

        $amount = $request->amount;
        $rawSignature = "accessKey=$accessKey" .
            "&amount=$amount" .
            "&extraData=$extraData" .
            "&ipnUrl=$ipnUrl" .
            "&orderId=$orderId" .
            "&orderInfo=$orderInfo" .
            "&partnerCode=$partnerCode" .
            "&redirectUrl=$redirectUrl" .
            "&requestId=$requestId" .
            "&requestType=$requestType";

        $signature = hash_hmac('sha256', $rawSignature, $secretKey);

        $requestBody = json_encode([
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => 'en'
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://test-payment.momo.vn/v2/gateway/api/create");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($requestBody)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

        $response = curl_exec($ch);
        curl_close($ch);

        return response()->json(json_decode($response, true));
    }

    public function callback(Request $request)
    {
        $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
        $accessKey = 'F8BBA842ECF85';

        $data = $request->all();

        Log::info('MoMo Callback Data: ', $data);

        $extraData = $data['extraData'] ?? '';
        $rawSignature = "accessKey=" . $accessKey .
            "&amount=" . $data['amount'] .
            "&extraData=" . $extraData .
            "&message=" . $data['message'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&orderType=" . $data['orderType'] .
            "&partnerCode=" . $data['partnerCode'] .
            "&payType=" . $data['payType'] .
            "&requestId=" . $data['requestId'] .
            "&responseTime=" . $data['responseTime'] .
            "&resultCode=" . $data['resultCode'] .
            "&transId=" . $data['transId'];

        $calculatedSignature = hash_hmac('sha256', $rawSignature, $secretKey);

        // Danh sách các mã lỗi cần kiểm tra
        $failedCodes = ['-1000', '-1001', '-1002', '-1003', '-1004', '-1005', '-1006', '-1007', '-1008', '-1009'];

        if ($calculatedSignature === $data['signature']) {
            $orderIdParts = explode('_', $data['orderId']);
            $orderIdNumber = $orderIdParts[1];

            $order = Order::where('id', $orderIdNumber)->first();

            if ($order) {
                // Kiểm tra mã lỗi và xử lý thanh toán thất bại
                if (in_array($data['resultCode'], $failedCodes)) {
                    Log::error('Payment failed', ['orderId' => $data['orderId'], 'resultCode' => $data['resultCode']]);
                    $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=payment_fail&order_id={$data['orderId']}";
                    return redirect()->to($frontendUrl);
                }

                if ($data['resultCode'] == 0) {
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

                    // Gửi mail
                    $user = $order->user;
                    if ($user && !empty($user->email)) {
                        $order->email = $user->email;
                        Mail::to($order->email)->send(new PaymentConfirmation($order));
                    }

                    $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status={$data['resultCode']}&order_id={$data['orderId']}";
                    return redirect()->to($frontendUrl);
                } else {
                    Log::error('Payment failed', ['orderId' => $data['orderId'], 'resultCode' => $data['resultCode']]);
                    $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status={$data['resultCode']}&order_id={$data['orderId']}";
                    return redirect()->to($frontendUrl);
                }
            } else {
                Log::error('Order not found', ['orderId' => $data['orderId']]);
                $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=01&order_id={$data['orderId']}";
                return redirect()->to($frontendUrl);
            }
        } else {
            Log::error('Invalid signature', [
                'calculated' => $calculatedSignature,
                'received' => $data['signature'],
                'rawSignature' => $rawSignature
            ]);

            $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=01&order_id={$data['orderId']}";
            return redirect()->to($frontendUrl);
        }
    }
}
