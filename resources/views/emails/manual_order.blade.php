<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 70%;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        p {
            font-size: 16px;
            margin: 10px 0;
            color: #555;
        }
        .product-images, .payment-images {
            margin: 20px 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
        .image-container {
            margin: 15px 0;
            text-align: center;
        }
        img {
            max-width: 90%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }
        .order-info {
            text-align: left;
            padding-left: 30px;
        }
        .order-info p {
            font-size: 16px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Manual Order Details</h2>
        </div>
        <div class="order-info">
            <p><strong>Name:</strong> {{ $orderDetails['name'] }}</p>
            <p><strong>Mobile:</strong> {{ $orderDetails['mobile'] }}</p>
            <p><strong>Alternate Mobile:</strong> {{ $orderDetails['alternate_mobile'] ?? 'N/A' }}</p>
            <p><strong>Street Address:</strong> {{ $orderDetails['street_address'] }}</p>
            <p><strong>Colony:</strong> {{ $orderDetails['colony'] }}</p>
            <p><strong>Pincode:</strong> {{ $orderDetails['pincode'] }}</p>
            <p><strong>City:</strong> {{ $orderDetails['city'] }}</p>
            <p><strong>State:</strong> {{ $orderDetails['state'] }}</p>
        </div>

        <div class="product-images">
            <h3>Product Screenshots:</h3>
            @if(!empty($orderDetails['product_screenshot']))
                @foreach(json_decode($orderDetails['product_screenshot'], true) as $image)
                    <div class="image-container">
                        <img src="{{ url($image) }}" alt="Product Screenshot">
                        <p><a href="{{ url($image) }}" target="_blank">View Product Screenshot</a></p>
                    </div>
                @endforeach
            @else
                <p>No Product Screenshots</p>
            @endif
        </div>

        <div class="payment-images">
            <h3>Payment Screenshots:</h3>
            @if(!empty($orderDetails['payment_screenshot']))
                @foreach(json_decode($orderDetails['payment_screenshot'], true) as $image)
                    <div class="image-container">
                        <img src="{{ url($image) }}" alt="Payment Screenshot">
                        <p><a href="{{ url($image) }}" target="_blank">View Payment Screenshot</a></p>
                    </div>
                @endforeach
            @else
                <p>No Payment Screenshots</p>
            @endif
        </div>

        <div class="footer">
            <p><strong>Date:</strong> {{ $orderDetails['date'] }}</p>
        </div>
    </div>
</body>
</html>
