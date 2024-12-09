<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>

<body style="background-color: #f4f7fc; padding: 20px; font-family: Arial, sans-serif; margin: 0;">

    <!-- Wrapper Container -->
    <table role="presentation" style="width: 100%; max-width: 600px; background-color: white; margin: 0 auto; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <!-- Header -->
        <tr>
            <td style="text-align: center; padding-bottom: 20px;">
                <h1 style="color: #007bff;">Xin chào {{ $name }}</h1>
            </td>
        </tr>

        <!-- Body content -->
        <tr>
            <td style="padding-bottom: 20px;">
                <p>Cảm ơn bạn đã thanh toán đơn hàng của chúng tôi. Đây là thông tin thanh toán của bạn:</p>
                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Mã đơn hàng:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">#000{{ $order }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Tổng giá trị:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($total, 0, ',', '.') }} VND</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Trạng thái:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">Đang chờ thanh toán</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="text-align: center; padding-top: 20px; font-size: 0.9em; color: #777;">
                <p>Chúng tôi sẽ tiến hành xử lý đơn hàng của bạn và giao hàng trong thời gian sớm nhất.</p>
                <p>Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>
                <p>Đây là email tự động, vui lòng không trả lời trực tiếp.</p>
            </td>
        </tr>
    </table>

</body>

</html>