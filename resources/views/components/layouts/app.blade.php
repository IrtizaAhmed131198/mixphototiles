<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ get_setting('site_name') ?? env('APP_NAME') }} - @yield('title')</title>
    <meta name="description" content="@yield('description', 'Default description')">
    <meta name="keywords" content="@yield('keywords', 'default, keywords')">

    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}"> --}}
    {{-- <link rel="icon" type="image/png" sizes="512x512"
        href="{{ asset('assets/favicon/android-chrome-512x512.png') }}"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
    <!-- crop js  -->
    <link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
    {{-- <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <!-- ckedor js -->
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <!-- daterangepicker css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- CSS Files with Cache Busting -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}?v={{ time() }}">
    @stack('css')
    @livewireStyles
    <style>
        @keyframes circle {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);

            }
        }
    </style>
</head>

<body>
    <div class="loadermain">
        <div class="loader-container">
            <div class="loaderMain">
                <img src="{{ asset('assets/images/loader.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
    <div>
        @include('partials.header')

        @yield('content')

        @include('partials.footer')
    </div>
    <!-- JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Magnific Popup core JS file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <!-- crop js cdns  -->
    <script src="https://foliotek.github.io/Croppie/croppie.js"></script>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Dropify JS -->
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script src="
                    https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js
                    "></script>
    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="{{ asset('assets/js/dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @livewireScripts
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @include('ajax')

    @stack('scripts')

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.loadermain').fadeOut();
            }, 3000);
        })
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__slow'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__slow'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            });
        </script>
    @endif

    <script>
        // console.clear();
    </script>

</body>

</html>
