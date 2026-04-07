<!DOCTYPE html>
<html>

<head>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="600" cellspacing="0" cellpadding="0" border="0" align="center"
        style="background-color: #ffffff; margin: 20px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding: 10px;">
                <!-- Logo goes here; ensure the URL is absolute and publicly accessible -->
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-width: 333px; height: 58px;">
            </td>
        </tr>
        <tr>
            <td align="center" style="text-align: center;">
                <h1 style="margin-top: 20px;">Order Details</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 20px;">
                <h2>New Order Received</h2>

                <h3>Order Details:</h3>
                <ul>
                    <li>Order ID: {{ $order->id }}</li>
                    <li>User ID: {{ $order->user_id }}</li>
                    <li>Total: Rs. {{ number_format($order->total_amount, 2) }}</li>
                    <li>Payment Method: {{ strtoupper($order->payment_method) }}</li>
                    <li>Shipping: Rs. {{ number_format($order->shipping, 2) }}</li>
                    <li>Discount: Rs. {{ number_format($order->discount ?? 0, 2) }}</li>
                </ul>

                <h3>Customer Info:</h3>
                <p>
                    Name: {{ $order->address->full_name }}<br>
                    Email: {{ $order->address->email }}<br>
                    Phone: {{ $order->address->phone_number }}<br>
                    Address: {{ $order->address->address_line1 }}, {{ $order->address->address_line2 }}<br>
                    City: {{ $order->address->city }}<br>
                    Pincode: {{ $order->address->pincode }}
                </p>

                <h3>Products Ordered:</h3>
                <table border="1" cellpadding="8" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $index => $item)
                            @php
                                $price = $item->price;
                                $quantity = $item->quantity;
                            @endphp
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rs. {{ number_format($item->price, 2) }}</td>
                                <td>Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p>Placed at: {{ $order->created_at->format('d M Y H:i') }}</p>


            </td>
        </tr>
        <tr>
            <td align="center" style="font-size: 0.9em; text-align: center; margin-top: 20px;">
                Best regards,<br>{{ get_setting('site_name') }} Team
            </td>
        </tr>
    </table>
</body>

</html>
