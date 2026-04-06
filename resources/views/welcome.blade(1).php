@extends('components.layouts.app')

@section('title', 'Home Page')


@push('css')
    <style>
        /* @keyframes circle {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);

                    }
                } */

    

/* ===== HERO CLARITY OVERLAY ===== */
    .hero-clarity-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background: rgba(0, 0, 0, 0.35);
        z-index: 2;
        text-align: center;
    }

    .hero-clarity-overlay h1 {
        font-size: 2.2rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1rem;
        margin-top: 4vh;
    }

    .hero-clarity-overlay p {
        max-width: 820px;
        margin: 0 auto 1rem auto;
    }

    /* Make buttons clickable even if you later decide to disable pointer events */
    .hero-clarity-overlay .btn {
        pointer-events: auto;
    }

    
    .hero-checks span {
        position: relative;
        padding-left: 22px;
        margin-right: 16px;
        display: inline-block;
        font-weight: 500;
    }

    .hero-checks span::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 0;
        color: #ff0168;
        font-weight: 700;
    }


    /* Responsive sizing for mobile */
    @media (max-width: 768px) {
        .hero-clarity-overlay h1 {
            font-size: 1.6rem;
        }
        .hero-clarity-overlay p {
            font-size: 0.95rem;
        }
    }

    /* ===== HOW IT WORKS SECTION ===== */
   /* HOW IT WORKS – ENHANCED PREMIUM STYLE */

    .how-it-works-clarity {
        background: #fafafa;
        margin-top:3rem;
    }

    .how-card {
        position: relative;
        background: #ffffff;
        padding: 48px 32px 25px;
        border-radius: 20px;
        height: 100%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .how-step-bg {
        position: absolute;
        top: 18px;
        right: 24px;
        font-size: 3.2rem;
        font-weight: 700;
        color: rgba(255, 1, 104, 0.12); /* brand pink, very soft */
        line-height: 1;
    }

    .how-card h4 {
        font-weight: 600;
        margin-bottom: 12px;
        margin-top: 25px;
        position: relative;
        z-index: 1;
    }

    .how-card p {
        font-size: 1rem;
        line-height: 1.7;
        color: #444;
        position: relative;
        z-index: 1;
    }

    
    /* ===============================
    HERO TRUST BAR – DESKTOP
    ================================ */
    .hero-trust-bar {
        display: inline-flex;
        align-items: center;
        gap: 20px;
        padding: 12px 22px;
        margin: 18px auto 26px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }

    .trust-item {
        position: relative;
        padding-left: 20px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #ffffff;
        white-space: nowrap;
    }

    .trust-item::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 0;
        color: #ff0168;
        font-weight: 700;
    }

    
    /* ===============================
    HERO TRUST BAR – MOBILE
    ================================ */
    
    /* =================================================
   FIX HERO TRUST BAR HORIZONTAL OVERFLOW (MOBILE)
================================================= */
    @media (max-width: 768px) {

        .hero-trust-bar {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center;

            width: 100% !important;
            max-width: 100% !important;

            margin: 0px auto 0px;
            padding: 0;

            background: transparent;
            backdrop-filter: none;
        }

        .trust-item {
            white-space: normal !important;   /* ✅ allow wrapping */
            max-width: 100%;

            font-size: 0.85rem;
            line-height: 1.3;

            background: rgba(255, 1, 104, 0.18);
            padding: 8px 14px 8px 28px;
            border-radius: 999px;

            margin: 4px 6px;
        }

        .trust-item::before {
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    }



    /* Assurance chips */
    .how-assurance {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 14px;
    }

    .assurance-chip {
        padding: 10px 18px;
        border-radius: 999px;
        background: rgba(255, 1, 104, 0.08);
        color: #222;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .assurance-chip::before {
        content: "✓";
        color: #ff0168;
        font-weight: 700;
        margin-right: 8px;
    }

    /* Mobile tuning */
    @media (max-width: 768px) {
        .how-step-bg {
            font-size: 2.6rem;
        }
        .how-card {
            padding: 40px 26px 32px;
        }
    }
    
    </style>
@endpush

@section('content')

    {{-- <section class="custom-hero-slider-section">
        <div class="container">
            <div class="fogeffect">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="custom-hero-slider-parent">
                            <span class="position-absolute z-2 bannerFrame"></span>
                            <div>
                                <div class="swiper main-banner-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="{{ asset('assets/images/banner/samp-8.webp') }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section> --}}



    {{-- HERO (VIDEO) + CLARITY OVERLAY --}}
    <section class="custom-hero-slider-section">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 p-0">
                    <div class="banner-video position-relative">

                        <video width="100%" height="100%" autoplay muted loop playsinline>
                            <source src="{{ asset('assets/banner-video/Banner-video.mp4') }}" type="video/mp4">
                        </video>

                        <!-- ✅ HERO CLARITY OVERLAY -->
                        <div class="hero-clarity-overlay text-white">
                            <h1>
                                Hang Photo Frames on Any Wall - Without Nails, Stickers, Glue, or  Damage
                            </h1>

                            <p>
                                Magnetick frames use a <strong>thin iron sheet + strong magnets</strong>
                                to hold frames securely on normal walls. so you can move, rearrange,
                                or remove them anytime without leaving marks.
                            </p>

                            
                            
                            <div class="hero-trust-bar">
                                <span class="trust-item">No Nails</span>
                                <span class="trust-item">No Stickers</span>
                                <span class="trust-item">No Wall Marks</span>
                                <span class="trust-item">Rental home‑safe</span>
                            </div>



                            <div>
                                <a href="{{ route('design') }}" class="btn custom-btn filled">
                                    Design Your Frame
                                </a>

                                <a href="#how-it-works" class="btn custom-btn ms-3">
                                    See How It Works
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works-clarity py-5">
    <div class="container">

        <!-- Section title -->
        <div class="text-center mb-5">
            <h2 class="heading-3">How Magnetick Frames Actually Work</h2>
        </div>

        <!-- Steps -->
        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <div class="how-card">
                    <div class="how-step-bg">01</div>
                    <h4>Place the ultra‑thin iron sheet</h4>
                    <p>
                        A lightweight iron sheet sits flush on your wall.
                        No nails, No drilling, No stickers, No peeling paints.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="how-card">
                    <div class="how-step-bg">02</div>
                    <h4>The frame snaps on magnetically</h4>
                    <p>
                        Strong magnets inside the frame hold it firmly in place.
                        Stable, Secure, and Safe.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="how-card">
                    <div class="how-step-bg">03</div>
                    <h4>Move or remove anytime</h4>
                    <p>
                        Rearrange layouts or remove frames easily.
                        Your wall stays clean and undamaged.
                    </p>
                </div>
            </div>

        </div>

        <!-- Assurance chips -->
        <div class="how-assurance mt-5 text-center">
            <span class="assurance-chip">Not a sticker</span>
            <span class="assurance-chip">Not glue‑based</span>
            <span class="assurance-chip">Designed for Indian painted walls & rented homes/apartments</span>
        </div>

    </div>
</section>



    <section class="premium-material">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="usa-pic usa-logo">
                        <img src="{{ asset('assets/images/USA.webp') }}" loading="lazy" class="img-fluid" alt="">
                        <h6>Made in India with Premium U.S Materials</h6>
                    </div>
                </div>
                <div class="col-lg-6  col-md-6 col-12">
                    <div class="usa-pic indian-logo">
                        <img src="{{ asset('assets/images/Indian-Made.webp') }}" loading="lazy" class="img-fluid" alt="">
                        <h6>The First-Ever Low-Cost Premium Frames</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="custom-tabs-section py">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="custom-tabs-content">
                        <h2 class="heading-3">
                            No Nail - Magentick <span>Hanging</span>
                        </h2>
                        <div class="d-flex align-items-start nails-tabs">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="active" id="v-pills-tap-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-tap" type="button" role="tab" aria-controls="v-pills-tap"
                                    aria-selected="true" data-start="0">Peel and
                                    stick</button>

                                <button class="" id="v-pills-hooks-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-hooks" type="button" role="tab"
                                    aria-controls="v-pills-hooks" aria-selected="true" data-start="20">Adjust to
                                    position</button>

                                <button class="" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true" data-start="40">Leaves no
                                    marks</button>

                                <button class="" id="v-pills-again-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-again" type="button" role="tab"
                                    aria-controls="v-pills-again" aria-selected="true" data-start="40">Move, Again and
                                    Again</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-12">
                    <div class="tab-content customTabsContent" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-tap" role="tabpanel"
                            aria-labelledby="v-pills-tap-tab" tabindex="0">
                            <video class="img-fluid"  autoplay  muted loop playsinline preload="metadata" style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_1_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                        <div class="tab-pane fade" id="v-pills-hooks" role="tabpanel" aria-labelledby="v-pills-hooks-tab"
                            tabindex="0">
                            <video class="img-fluid"  autoplay  muted loop playsinline preload="metadata" style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_2_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                        <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"
                            tabindex="0">
                            <video class="img-fluid"  autoplay  muted loop playsinline preload="metadata" style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_3_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                        <div class="tab-pane fade" id="v-pills-again" role="tabpanel"
                            aria-labelledby="v-pills-again-tab" tabindex="0">
                            <video class="img-fluid"  autoplay  muted loop playsinline preload="metadata" style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_4_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="main-banner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="text-center">
                        <h1 class="main-title">
                            <span class="heading-2">Turn your
                                photos into a masterpiece</span>
                            <span class="heading-1">let your walls tell your story</span>
                        </h1>
                        <button type="button" class="btn custom-btn filled"
                            onclick="window.location.href='{{ route('design') }}';">
                            <svg width="26.122" height="26.849" class="w-em h-em me-2 ttl-26 mb-0"
                                viewBox="0 0 26.122 26.849" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(-858.42 -842.908)">
                                    <path fill="currentColor" transform="translate(866.746 842.818)"
                                        d="M16.622.112c-.067,0-.089.045-.134.067L8.121,6.114a1.558,1.558,0,0,0-.29.357l-.29.558a5.119,5.119,0,0,1,3.347,3.347l.558-.29A1.457,1.457,0,0,0,11.8,9.8l5.935-8.367c.067-.112.089-.2,0-.29L16.756.157A.193.193,0,0,0,16.622.09ZM5.957,8.97a2.947,2.947,0,0,0-2.923,2.99,5.983,5.983,0,0,1-2.99,5.154,6.135,6.135,0,0,0,2.99.759,5.918,5.918,0,0,0,5.935-5.935,3,3,0,0,0-2.99-2.99Z">
                                    </path>
                                    <path fill="currentColor" transform="translate(859.67 845.317)"
                                        d="M23.511,24.441H-1.25V-1.25H14.126V1.2H1.2v20.8H21.064V8.171h2.447Z"></path>
                                </g>
                            </svg>
                            Design your frame
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="clusters-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="text-center">
                        <h2 class="heading-2">Collections for your memorable walls</h2>
                        <p class="para">
                            Looking for ideas or effortless elegance?
                            <span class="d-block">
                                Explore our handpicked photo frame collections.
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="swiper swiper-horizontal">
                        <div class="swiper-wrapper">
                            @foreach ($products as $product)
                                @php
                                    $discountAmount = ($product->price * $product->discount) / 100;
                                    $finalPrice = $product->price - $discountAmount;
                                    $url = url('collection') . '/' . $product->slug;
                                @endphp
                                <div class="swiper-slide">
                                    <div class="ClusterCard" onclick="redirectTo('{{ $url }}')">
                                        <div class="ImgFrame">
                                            <img alt="{{ $product->name }}" loading="lazy" class="img-fluid"
                                                src="{{ asset($product->image) }}">
                                        </div>
                                        <div class="custom-card-body">
                                            <h3 class="card-title">{{ $product->name }}</h3>
                                            <div class="card-prize">
                                                <h4 class="product-prize">
                                                    <span class="realPize">
                                                        ₹ {{ number_format($finalPrice, 2) }}
                                                    </span>
                                                    @if ($product->discount > 0)
                                                        <span class="cutPrize">
                                                            <del>₹ {{ number_format($product->price, 2) }}</del>
                                                        </span>
                                                    @endif
                                                </h4>
                                                @if ($product->discount > 0)
                                                    <span class="discountPercent">
                                                        {{ round($product->discount) }}% OFF
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <script>
                                function redirectTo(url) {
                                    window.location.href = url;
                                }
                            </script>
                        </div>

                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                    </div>

                    <div class="ctaBtnParent text-center" onclick="window.location.href='{{ route('collections') }}';">
                        <button type="button" onclick="window.location.href='{{ route('collections') }}';"
                            class="btn custom-btn filled">
                            View All Collections
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- <section class="about-section py">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="parentRightAbout">
                        <div class="RightSliderChild whyChooseUs">
                            <h2 class="heading-3">LED Photo Frames</h2>
                            <p style=" font-size: 29px; line-height: 52px; ">
                                Illuminate your memories with {{ get_setting('site_name') }}
                                elegant LED photo frames, where sophistication meets sentiment.
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn custom-btn filled mt-5"
                        onclick="window.location.href='{{ route('design') }}';">
                        <svg width="20" height="20" viewBox="0 0 20 20" class="w-em h-em me-1 ttl-20 mb-0"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" transform="translate(-2 -2)"
                                d="M10,16.5,16,12,10,7.5ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20Z">
                            </path>
                        </svg>
                        Design your frame
                    </button>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <!-- Swiper Slider Start -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <figure>
                                    <img src="{{ asset('assets/images/led_frame_5.jpeg') }}" class="img-fluid"
                                        alt="">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure>
                                    <img src="{{ asset('assets/images/led_frame_6.jpeg') }}" loading="lazy" class="img-fluid"
                                        alt="">
                                </figure>
                            </div>
                        </div>
                        <!-- Optional Navigation -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <!-- Swiper Slider End -->
                </div>
            </div>
        </div>
    </section> --}}

    <section class="custom-tabs-section py mobile_view_tabs" style="display: none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 col-12 main-video">
                    <div class="mobile-tabs-video">
                        <h2 class="heading-3" style=" font-size: 41px; ">
                            No Nail - Magentick <span>Hanging</span>
                        </h2>
                        <div class="custom-tabs-content">
                            <div class="peel_stick">
                                <h4>Peel and stick</h4>
                                <video class="img-fluid" autoplay muted loop playsinline>
                                    <source src="{{ asset('assets/video/Video_1_Photo.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <div class="peel_stick">
                                <h4>Leaves no marks</h4>
                                <video class="img-fluid" autoplay muted loop playsinline>
                                    <source src="{{ asset('assets/video/Video_3_Photo.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <div class="peel_stick">
                                <h4>Adjust to position</h4>
                                <video class="img-fluid" autoplay muted loop playsinline>
                                    <source src="{{ asset('assets/video/Video_2_Photo.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <div class="peel_stick">
                                <h4>Move, Again and Again</h4>
                                <video class="img-fluid" autoplay muted loop playsinline>
                                    <source src="{{ asset('assets/video/Video_4_Photo.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section py sofa-covered">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="parentRightAbout text-center mb-5">
                        <h2 class="heading-3">
                            <span class="sec-2-span d-block">{{ get_setting('site_name') }}</span>
                            Have Got You Covered
                        </h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="AboutSliderParent p-3 h-100">
                        <h5><b>No Nails, No marks, Clean walls</b></h5>
                        <p>Change your mind? Move it, love it, leave no mark</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="AboutSliderParent p-3 h-100">
                        <h5><b>Luxury walls for everyone</b></h5>
                        <p>Thoughtfully priced for every class, every home</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="AboutSliderParent p-3 h-100">
                        <h5><b>Super light weight & Premium</b></h5>
                        <p>Even kids can carry it. No damage, when dropped</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="AboutSliderParent p-3 h-100">
                        <h5><b>Happiness Guaranteed</b></h5>
                        <p>We measure our success by the joy we bring to your heart</p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="text-center mt-5">
                        <button type="button" class="btn custom-btn filled"
                            onclick="window.location.href='{{ route('design') }}';">
                            <svg width="20" height="20" viewBox="0 0 20 20" class="w-em h-em me-1 ttl-20 mb-0"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" transform="translate(-2 -2)"
                                    d="M10,16.5,16,12,10,7.5ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20Z">
                                </path>
                            </svg>
                            Design your frame
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="text-center text-white HomeFrameSlider_framesSliderWrp position-relative  scroll-fade py">
        <div class="HomeFrameSlider_framesContent">
            <div class="container">
                <h2 class="heading-3">What can you frame?</h2>
                <p class="para">Anything you love. Breathe life into your memories.
                    Elevate the moments hidden in your phone or computer into bold, beautiful wall art — where every
                    glance ignites a feeling.</p>
            </div>
        </div>
        <div class="HomeFrameSlider_sliderWrp position-relative">
            <div class="swiper mySwiper-grid px-0 mx-0 HomeFrameSlider_sliderFrames">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Wedding image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Animal_1.webp') }}">
                                    </div>
                                    <p>Animal</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-xl card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="nature image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Birds.webp') }}">
                                    </div>
                                    <p>Birds</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-lg card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Childhood image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Child.webp') }}">
                                    </div>
                                    <p>Childhood</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-md card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="sea image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Dog_1.webp') }}">
                                    </div>
                                    <p>Dog</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Memory image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Food.webp') }}">
                                    </div>
                                    <p>Food</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-xl card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Art image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Memories_1.webp') }}">
                                    </div>
                                    <p>Memories</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-lg card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Travel image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Nature.webp') }}">
                                    </div>
                                    <p>Nature</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-md card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Passion image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Passion.webp') }}">
                                    </div>
                                    <p>Passion</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Art image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/wedding_1.webp') }}">
                                    </div>
                                    <p>Wedding</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-xl card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Art image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/wedding_2.webp') }}">
                                    </div>
                                    <p>Wedding</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-md card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Passion image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Passion.webp') }}">
                                    </div>
                                    <p>Passion</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Memory image" loading="lazy" class="img-fluid"
                                            src="{{ asset('assets/images/Food.webp') }}">
                                    </div>
                                    <p>Food</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <section class="about-section py">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="parentRightAbout whychoose">
                        <div class="RightSliderChild whyChooseUs">
                            <h2 class="heading-3">Why choose us?</h2>
                            <p>
                                Because every order you place is more than just a purchase, it’s a lifeline.
                                A part of our profits goes toward helping those in need, the homeless and the hungry with
                                children.
                            </p>
                            <p>
                                We willingly cut a significant share of our earnings because we believe no one should go
                                without a meal.
                                With every purchase, you’re not just bringing beauty into your home; you're putting food on
                                someone’s plate,
                                offering hope, and restoring dignity. This is not just our mission, it's something we do
                                hand in hand with you.
                                And with every meal served, their heartfelt prayers and gratitude extend beyond us, they
                                reach you too.
                            </p>
                            <p>
                                Together, we’re not just creating art for walls; we’re creating a ripple of kindness and
                                compassion.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <figure>
                        <img src="{{ asset('assets/images/Needy-poor3.webp') }}" loading="lazy" class="img-fluid" alt=""
                            style=" margin-left: 41px; height: 500px;">
                    </figure>
                </div>
            </div>

        </div>
    </section>

    <section class="faqSection py">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="mx-auto text-center HomeTestimonials_htContent__sML46">
                        <h2 class="heading-3">Frequently Asked Questions</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    What does Magentick Photo Frames have to offer?
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Magentick Photo Frames offers you to create your own masterpiece with our customizable
                                    photo frames.
                                    Simply upload your images. We’ll print, frame, and deliver them right to your doorstep.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Can I move the frame tiles easily?
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Super easy! Designed to be repositioned again and again.Even
                                    kids can
                                    arrange them. No wall marks, no damage, no stress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    They won't hurt my walls?
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Nope. No marks, no residues. Your walls remains
                                    the same as it was before.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFour" aria-expanded="false"
                                    aria-controls="flush-collapseFour">
                                    Do your photo tiles cost a lot?
                                </button>
                            </h2>
                            <div id="flush-collapseFour" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Magentick Photo Frames is the first ever shop to offer low-cost premium branded photo
                                    frames,
                                    so every class of people could afford. Our mission is simple to make beautiful,
                                    personalized
                                    wall décor accessible to all, regardless of class or background. We operate on a minimal
                                    profit
                                    margin, ensuring that affordability never compromises quality. More importantly, a part
                                    of every
                                    purchase goes towards providing meals for the homeless and those in need. With every
                                    frame you
                                    order, you're not just creating a wall of memories; you're sharing in a circle of hope
                                    and kindness
                                    and earn strong prayers.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFive" aria-expanded="false"
                                    aria-controls="flush-collapseFive">
                                    What size options do the photo tiles offer?
                                </button>
                            </h2>
                            <div id="flush-collapseFive" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">We offer sizes ranges from 8"X 8" to 12" X 12", plus customized
                                    options until 27X36 based on pre-orders.
                                    Available in various frame colours, including frameless option.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-0 HomeEnquire_homeEnquireWrp scroll-fade ">
        <div class="mobile-back-img">
            <img src="{{ asset('assets/images/home-enquire-bg-v2mob.jpg') }}" loading="lazy" class="img-fluid" alt=""
                style="display: none">
        </div>
        <div class="container">
            <div class="text-center text-lg-start HomeEnquire_homeEnquireContent">
                <div class="newframeimg">
                    <h3 class="heading-4">For Business Inquiries, <span class="d-block">Retails or Bulk Ordering,</span>
                    </h3>
                    <button type="button" class="btn custom-btn filled"
                        onclick="window.location.href='{{ route('contact') }}'">
                        Contact Us
                    </button>
                </div>
                <div class="newframe-sideimg">
                    <img src="{{ asset('assets/images/bulkOrder-5.webp') }}" loading="lazy" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
document.addEventListener("DOMContentLoaded", function () {

  // 1) Get all pill tab buttons
  const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');

  // 2) Helper: pause + reset all videos inside tab panes
  function resetAllTabVideos() {
    document.querySelectorAll('.tab-pane video').forEach(v => {
      try {
        v.pause();
        v.currentTime = 0;
      } catch (err) {
        // ignore (some browsers may throw if not loaded yet)
      }
    });
  }

  // 3) Helper: play the active tab's video
  function playVideoInPane(targetSelector) {
    const pane = document.querySelector(targetSelector);
    const video = pane ? pane.querySelector("video") : null;

    if (video) {
      // Reset first for consistent playback
      video.currentTime = 0;

      // Play (autoplay policy safe)
      const p = video.play();
      if (p && typeof p.catch === "function") {
        p.catch(() => {
          // Autoplay may be blocked in some cases; muted usually avoids this
        });
      }
    }
  }

  // 4) When a tab becomes active
  tabButtons.forEach(button => {
    button.addEventListener("shown.bs.tab", function (e) {
      const targetSelector = e.target.getAttribute("data-bs-target");
      resetAllTabVideos();               // <-- NEW: stop others
      playVideoInPane(targetSelector);   // <-- keep your behavior
    });
  });

  // 5) On initial page load: ensure only the default active tab video plays
  // Find the active tab button (Bootstrap adds .active)
  const activeBtn = document.querySelector('[data-bs-toggle="pill"].active');
  if (activeBtn) {
    const initialTarget = activeBtn.getAttribute("data-bs-target");
    resetAllTabVideos();
    playVideoInPane(initialTarget);
  }
});
</script>
@endpush
