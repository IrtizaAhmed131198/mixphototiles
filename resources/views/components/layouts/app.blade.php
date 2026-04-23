<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ get_setting('site_name') ?? env('APP_NAME') }}
        @hasSection('title')
            - @yield('title')
        @endif
    </title>

    <meta name="description" content="@yield('description', 'Magnetic photo frames for walls with no nails, no stickers, no wall marks and no damage. Design custom photo frames online with Magnetick.')">
    <meta name="keywords" content="@yield('keywords', 'magnetic photo frames, wall photo frames, no nail frames, damage free frames')">

    @hasSection('noindex')
        <meta name="robots" content="noindex, nofollow">
    @endif

    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')" />
    @endif

    <!-- ✅ Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.png') }}">

    <!-- ✅ Preconnect (important for fonts speed) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- ✅ Fonts -->
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" as="style"
        onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
            rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    </noscript>

    <!-- ✅ Bootstrap (NON-BLOCKING) -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    </noscript>

    <!-- ✅ Optional libraries (LOAD ONLY WHERE NEEDED) -->
    @stack('plugin-css')

    <!-- ✅ Your CSS (NON-BLOCKING) -->
    <link rel="preload" href="{{ asset('assets/css/custom.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/css/responsive.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('assets/css/dataTables.bootstrap5.css') }}" as="style"
        onload="this.rel='stylesheet'">

    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.css') }}">
    </noscript>

    <!-- ✅ Critical CSS (tiny only) -->
    <style>
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes circle {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    @stack('css')
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
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <!-- Cropper.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="{{ asset('assets/js/dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    {{-- @livewireScripts --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>


    <script>
        window.csrfToken = function() {
            const el = document.querySelector('meta[name="csrf-token"]');
            return el ? el.getAttribute('content') : '';
        };

        window.safeJson = async function(response) {
            const text = await response.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Non-JSON response:', text);
                throw e;
            }
        };
    </script>


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


    <script>
        // Global CSRF header for all jQuery AJAX calls (fetch already sets headers in your code)
        if (window.$ && document.querySelector('meta[name="csrf-token"]')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        }
    </script>

    <a href="https://wa.me/9342874392" target="_blank" class="whatsapp-float">
        <img src="{{ asset('assets/images/whatsapp-bottom.png') }}" alt="WhatsApp">
    </a>

</body>

</html>
