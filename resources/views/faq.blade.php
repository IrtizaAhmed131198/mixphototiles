@extends('components.layouts.app')

@section('title', 'FAQs')

@push('css')
    <style>
        .child-faq {
            margin: auto;
            width: 70%;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .child-faq h1 {
            color: black;
            text-align: start !important;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 35px;
        }

        .child-faq p {
            color: black;
            font-weight: 400;
            font-size: 15px;
            line-height: 25px;
        }

        .child-faq ul li {
            margin-bottom: 10px;
            list-style: number;
        }

        .child-faq h2 {
            color: black;
            font-weight: 500;
            font-size: 30px;
            margin: 30px 0;
        }

        .child-faq table {
            margin: 40px 0;
        }

        .child-faq table tr th {
            color: black;
            font-size: 16px;
            padding-bottom: 20px !important;
        }

        .child-faq table tr td {
            padding-bottom: 15px;
        }

        .child-faq ul li strong {
            color: black;
        }

        .child-faq ul li ul li {
            list-style: none;
            position: relative;
            z-index: 0;
        }

        .child-faq ul li ul li:before {
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

        .child-faq ul li ul {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
<section class="faq-policy">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="child-faq">
                    <h1 class="text-center">FAQs</h1>
                </div>
            </div>
        </div>
</section>
@endsection
