<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MomoController extends Controller
{
    public function create(Request $request)
    {
        $partnerCode = 'MOMO';
        $accessKey = 'F8BBA842ECF85';
        $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';

        // Tạo requestId và orderId
        $requestId = $partnerCode . time();
        $orderId = $requestId;
        $orderInfo = 'pay with MoMo';
        $redirectUrl = url('api/momo/callback'); // URL chuyển hướng sau khi thanh toán
        $ipnUrl = url('api/momo/callback'); // URL nhận thông báo IPN
        $requestType = 'captureWallet';
        $extraData = ''; // Có thể để trống

        // Tạo rawSignature
        $amount = $request->amount;
        $rawSignature = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";

        // Tạo chữ ký
        $signature = hash_hmac('sha256', $rawSignature, $secretKey);

        // Tạo đối tượng JSON gửi đến MoMo
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

        // Cấu hình cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://test-payment.momo.vn/v2/gateway/api/create");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($requestBody)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
        curl_close($ch);

        return response()->json(json_decode($response, true));
    }

    public function callback(Request $request)
    {
        $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
        $data = $request->all();

        // Tạo raw data để kiểm tra chữ ký
        $rawSignature = "accessKey={$data['accessKey']}&"
            . "amount={$data['amount']}&"
            . "extraData={$data['extraData']}&"
            . "orderId={$data['orderId']}&"
            . "orderInfo={$data['orderInfo']}&"
            . "orderType={$data['orderType']}&"
            . "partnerCode={$data['partnerCode']}&"
            . "payType={$data['payType']}&"
            . "requestId={$data['requestId']}&"
            . "responseTime={$data['responseTime']}&"
            . "resultCode={$data['resultCode']}&"
            . "transId={$data['transId']}";

        // Tạo chữ ký để kiểm tra
        $signature = hash_hmac('sha256', $rawSignature, $secretKey);

        // Kiểm tra chữ ký
        if ($signature === $data['signature']) {
            // Chữ ký hợp lệ, xử lý logic khi thanh toán thành công
            if ($data['resultCode'] == 0) {
                // Xử lý thanh toán thành công
                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment successful'
                ]);
            } else {
                // Xử lý thanh toán thất bại
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Payment failed'
                ]);
            }
        } else {
            // Chữ ký không hợp lệ
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature'
            ]);
        }
    }
}
