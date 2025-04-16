@extends('components.layouts.app')

@section('title', 'Shipping Policy')

@push('css')
    <style>
        .child-shipping {
            margin: auto;
            width: 70%;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .child-shipping h1 {
            color: black;
            text-align: start !important;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 35px;
        }

        .child-shipping p {
            color: black;
            font-weight: 400;
            font-size: 15px;
            line-height: 25px;
        }

        .child-shipping ul li {
            margin-bottom: 10px;
            list-style: number;
        }

        .child-shipping h2 {
            color: black;
            font-weight: 500;
            font-size: 30px;
            margin: 30px 0;
        }

        .child-shipping table {
            margin: 40px 0;
        }

        .child-shipping table tr th {
            color: black;
            font-size: 16px;
            padding-bottom: 20px !important;
        }

        .child-shipping table tr td {
            padding-bottom: 15px;
        }

        .child-shipping ul li strong {
            color: black;
        }

        .child-shipping ul li ul li {
            list-style: none;
            position: relative;
            z-index: 0;
        }

        .child-shipping ul li ul li:before {
            position: absolute;
            z-index: 0;
            content: "";
            left: -20px;
            top: 10px;
            width: 8px;
            height: 8px;
            background: #ff0168;
            border-radius: 0;
        }

        .child-shipping ul li ul {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <section class="shipping-policy">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="child-shipping">
                        <h1 class="text-center">Shipping Policy</h1>

                        <h2>Order Dispatch Guidelines</h2>
                        <p>We aim to dispatch all orders within <strong>2 to 3 business days</strong>, provided all order
                            details such as image quality, contact information, and delivery address are accurate and
                            complete.</p>

                        <p>If a product is temporarily out of stock, requires restocking, or if a technical issue occurs,
                            our team will contact you directly. In such cases, dispatch may be delayed based on how quickly
                            we receive your confirmation.</p>

                        <p>Orders that require clarification or have image-related concerns will go to further level of
                            review and contact you if required. In that case, customers will be notified via SMS or
                            WhatsApp.</p>

                        <h2>Shipping Times</h2>
                        <ul>
                            <li>We aim to deliver the products in <strong>4-10 days</strong></li>
                            <li>You will receive the tracking details once the order is dispatched from our premises</li>
                            <li>Please contact our team if you didn't receive the tracking details</li>
                            <li>The mentioned delivery times may vary depending on the cases</li>
                        </ul>

                        <h2>Shipping Issues</h2>
                        <p><strong>When the shipment is defective:</strong></p>
                        <p>We strongly recommend recording an unboxing video upon receiving your package, ensuring the
                            shipping label is clearly visible. This helps us verify the damage and present necessary
                            evidence to our courier partners for resolution.</p>
                        <p>Once the video is submitted to our team, we will promptly assess the issue and arrange for a
                            replacement to be sent to you without delay.</p>

                        <div>Last Updated: May 2025</div>

                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
@endpush
