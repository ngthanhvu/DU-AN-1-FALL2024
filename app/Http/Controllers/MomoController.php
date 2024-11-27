<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Log;

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
    // Khai báo khóa bí mật
    $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';

    // Lấy tất cả các tham số từ request
    $data = $request->all();

    // Log dữ liệu callback từ MoMo
    Log::info('MoMo Callback Data: ', $data);

    // Kiểm tra và lấy giá trị từ callback
    $amount = (string) $data['amount'] ?? null; // Đảm bảo amount là chuỗi
    $extraData = $data['extraData'] ?? '';  // Giữ chuỗi rỗng nếu extraData là null
    $orderId = $data['orderId'] ?? null;
    $orderInfo = $data['orderInfo'] ?? null;
    $orderType = $data['orderType'] ?? null;
    $partnerCode = $data['partnerCode'] ?? null;
    $payType = $data['payType'] ?? null;
    $requestId = $data['requestId'] ?? null;
    $responseTime = (string) $data['responseTime'] ?? null;  // Đảm bảo responseTime là chuỗi
    $resultCode = (string) $data['resultCode'] ?? null;  // Đảm bảo resultCode là chuỗi
    $transId = $data['transId'] ?? null;
    $signature = $data['signature'] ?? null;

    // Log các giá trị đã nhận
    Log::info('Received Data: ', compact(
        'amount', 'extraData', 'orderId', 'orderInfo',
        'orderType', 'partnerCode', 'payType', 'requestId',
        'responseTime', 'resultCode', 'transId', 'signature'
    ));

    // Tạo raw data để kiểm tra chữ ký (URL encode các tham số)
    $rawSignature = "amount=" . urlencode($amount) .
                    "&extraData=" . urlencode($extraData) .
                    "&orderId=" . urlencode($orderId) .
                    "&orderInfo=" . urlencode($orderInfo) .
                    "&orderType=" . urlencode($orderType) .
                    "&partnerCode=" . urlencode($partnerCode) .
                    "&payType=" . urlencode($payType) .
                    "&requestId=" . urlencode($requestId) .
                    "&responseTime=" . urlencode($responseTime) .
                    "&resultCode=" . urlencode($resultCode) .
                    "&transId=" . urlencode($transId);

    // Log rawSignature
    Log::info('Raw Signature: ', [$rawSignature]);

    // Tạo chữ ký để kiểm tra
    $calculatedSignature = hash_hmac('sha256', $rawSignature, $secretKey);

    // Log chữ ký đã tính toán
    Log::info('Calculated Signature: ', [$calculatedSignature]);

    // Kiểm tra chữ ký
    if ($calculatedSignature === $signature) {
        // Chữ ký hợp lệ, xử lý logic khi thanh toán thành công
        if ($resultCode == 0) {
            // Thanh toán thành công
            Log::info('Payment success', ['orderId' => $orderId, 'transId' => $transId]);

            // Trả về phản hồi thành công
            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful'
            ]);
        } else {
            // Thanh toán thất bại
            Log::error('Payment failed', ['orderId' => $orderId, 'transId' => $transId, 'resultCode' => $resultCode]);

            // Trả về phản hồi thất bại
            return response()->json([
                'status' => 'fail',
                'message' => 'Payment failed'
            ]);
        }
    } else {
        // Chữ ký không hợp lệ
        Log::error('Invalid signature', [
            'calculated' => $calculatedSignature,
            'received' => $signature
        ]);

        // Trả về phản hồi lỗi
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid signature'
        ]);
    }
}

}
