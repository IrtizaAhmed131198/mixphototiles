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
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-width: 100px; height: 100px;">
            </td>
        </tr>
        <tr>
            <td align="center" style="text-align: center;">
                <h1 style="margin-top: 20px;">Order Details</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 20px;">
                <h2>Hi {{ $order->user->name }},</h2>
                <p>Thank you for your order. Here are your order details:</p>

                <h3>Order Summary:</h3>
                <ul>
                    <li>Order ID: #{{ $order->id }}</li>
                    <li>Payment Method: {{ strtoupper($order->payment_method) }}</li>
                    <li>Total Amount: Rs.{{ number_format($order->total_amount, 2) }}</li>
                </ul>

                <h3>Shipping Address:</h3>
                <p>
                    {{ $order->address->full_name }}<br>
                    {{ $order->address->address_line1.' '.$order->address->address_line2 }}<br>
                    {{ $order->address->city }}, PIN: {{ $order->address->pincode }}<br>
                    Phone: {{ $order->address->phone_number }}
                </p>

                <h3>Products:</h3>
                <table border="1" cellpadding="8" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
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
                                <td>Rs.{{ number_format($price, 2) }}</td>
                                <td>Rs.{{ number_format($price * $quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p>We’ll notify you once your order is shipped!</p>

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
