<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking Details</title>
</head>
<body>
    <h2>Order Tracking Details</h2>
    <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
    <p><strong>Tracking ID:</strong> {{ $trackingId }}</p>
    <p><strong>Tracking Link:</strong> <a href="{{ $trackingLink }}" target="_blank">{{ $trackingLink }}</a></p>

    @if ($trackingSlip)
        <p><strong>Tracking Slip:</strong> <a href="{{ $trackingSlip }}" target="_blank">Download Slip</a></p>
    @endif

    <p>Thank you!</p>
</body>
</html>
