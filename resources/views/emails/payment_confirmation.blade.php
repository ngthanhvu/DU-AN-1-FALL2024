<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận thanh toán</title>
    <!-- Thêm CDN của Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f4f7fc; padding: 20px; font-family: Arial, sans-serif;">

    <!-- Wrapper Container -->
    <div class="container" style="max-width: 600px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-primary">Xin chào {{ $order->full_name }}</h1>
        </div>

        <!-- Body content -->
        <p>Cảm ơn bạn đã thanh toán đơn hàng của chúng tôi. Đây là thông tin thanh toán của bạn:</p>
        <ul>
            <li><strong>Mã đơn hàng:</strong> {{ $order->id }}</li>
            <li><strong>Tổng giá trị:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</li>
            <li><strong>Trạng thái:</strong> Đã thanh toán</li>
        </ul>

        <p>Chúng tôi sẽ tiến hành xử lý đơn hàng của bạn và giao hàng trong thời gian sớm nhất.</p>
        <p>Cảm ơn bạn đã tin tưởng sử dụng dịch vụ của chúng tôi!</p>

        <!-- Footer -->
        <div class="text-center mt-5" style="font-size: 0.9em; color: #777;">
            <p>Đây là email tự động, vui lòng không trả lời trực tiếp.</p>
        </div>
    </div>

</body>
</html>
