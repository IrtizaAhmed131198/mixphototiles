@extends('components.layouts.app')

@section('title', 'Refund Policy')

@push('css')
    <style>
        .child-refund {
            margin: auto;
            width: 70%;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .child-refund h1 {
            color: black;
            text-align: start !important;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 35px;
        }

        .child-refund p {
            color: black;
            font-weight: 400;
            font-size: 15px;
            line-height: 25px;
        }

        .child-refund ul li {
            margin-bottom: 10px;
            list-style: number;
        }

        .child-refund h2 {
            color: black;
            font-weight: 500;
            font-size: 30px;
            margin: 30px 0;
        }

        .child-refund table {
            margin: 40px 0;
        }

        .child-refund table tr th {
            color: black;
            font-size: 16px;
            padding-bottom: 20px !important;
        }

        .child-refund table tr td {
            padding-bottom: 15px;
        }

        .child-refund ul li strong {
            color: black;
        }

        .child-refund ul li ul li {
            list-style: none;
            position: relative;
            z-index: 0;
        }

        .child-refund ul li ul li:before {
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

        .child-refund ul li ul {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <section class="refund-policy">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="child-refund">
                        <h1 class="text-center">Refunds & Returns Policy</h1>

                        <p>Due to the fully customized nature of our products, we are unable to offer standard return or refund procedures typically applicable to non-customized items.</p>

                        <p>As part of a comprehensive clarification regarding our policies on Returns, Refunds, Cancellations, and Exchanges outlined in our Terms of Use, the following practices adopted by <b>Magnetic Photo Frames</b> and accepted by customers upon making a purchase through <a href="http://www.magneticphotoframes.com">www.magneticphotoframes.com</a> are detailed below.</p>

                        <h2>Return Terms</h2>
                        <p>If any defects in the product may be reported to our Customer Service team by email at <a href="mailto:support@magneticphotoframes.com">support@magneticphotoframes.com</a> or by WhatsApp.</p>
                        <p>Customers are requested to provide clear images or videos of the defect to facilitate evaluation. Return of the item is not required unless specifically requested by our Customer Service team for further inspection. A full refund will be processed upon completion of the review and confirmation of the defect.</p>

                        <h2>Refund Process</h2>
                        <p>Refunds are issued only in cases involving:</p>
                        <ul>
                            <li>Production defect</li>
                            <li>Courier damage</li>
                            <li>If the order has not yet been dispatched</li>
                        </ul>
                        <p>Please contact our Customer Service team via email or WhatsApp to initiate a refund request.</p>
                        <p>The amount will be refunded after our evaluation of the case. There is a right for <b>Magnetic Photo Frames</b> to decline a refund request if that case deserves.</p>

                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
@endpush
