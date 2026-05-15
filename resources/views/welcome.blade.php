@extends('components.layouts.app')

@section('title', 'Magnetic Photo Frames for Walls | No Nails, No Damage, No Wall Marks')

@section('description', 'Magnetic photo frames for walls with no nails, no drilling, and no wall damage. Reposition
    anytime. Design custom photo frames online. Made in India.')

@section('keywords', 'magnetic photo frames, photo frames without nails, no drill photo frames, wall frames no damage,
    light weight photo frames, stylish photo frames, modern photo frames, no marks on walls photo frames')

@section('canonical', url('/'))


@push('css')
    <style>
        .hero-clarity-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.20);
            z-index: 2;
            text-align: center;
        }

        .hero-clarity-overlay h1 {
            font-size: 4.2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 2rem;
            margin-top: 5vh;
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
            color: #EB2371;
            font-weight: 700;
        }


        /* Responsive sizing for mobile */
        @media (max-width: 768px) {
            .hero-clarity-overlay h1 {
                font-size: 1.6rem;
            }

        }


        /* =========================
       FIRST SECTION UNDER THE BANNER VIDEO (under hero video)
    ========================= */
        .benefit-strip {
            background: #ffffff;
            padding: 100px 0;
        }

        .benefit-item {
            text-align: center;
            padding: 10px 18px;
        }

        .benefit-icon {
            width: 85px;
            height: 85px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .benefit-icon-img {
            width: 85px;
            height: 85px;
            object-fit: contain;
        }

        .benefit-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #0b1b3a;
        }

        .benefit-subtitle {
            font-size: 1.1rem;
            color: #2f3a4a;
            margin: 0;
        }

        /* Keep spacing balanced on mobile */
        @media (max-width: 768px) {
            .benefit-strip {
                padding: 40px 0;
            }

            .benefit-item {
                margin-bottom: 26px;
            }

            .benefit-title {
                font-size: 1.35rem;
            }

            .benefit-subtitle {
                font-size: 1rem;
            }
        }

        26px
        /* =========================
           SECOND SECTION UNDER BANNER VIDEO
        ========================= */

        .photo-moments-section {
            background: #f6f6f3;
            /* light warm gray like the sample */
            padding: 122px 0;
        }

        .photo-moments-content h2 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.15;
            color: #0b1b3a;
            /* deep navy like sample */
            margin-bottom: 18px;
        }

        .photo-moments-content p {
            font-size: 1.15rem;
            line-height: 1.7;
            color: #2f3a4a;
            max-width: 520px;
            margin-bottom: 28px;
        }

        .photo-moments-btn {
            background: #EB2371;
            /* your brand pink */
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .photo-moments-btn:hover {
            background: #d81d66;
            color: #fff;
        }

        /* Right side image */
        .photo-moments-image {
            text-align: right;
        }

        .photo-moments-image img {
            width: 100%;
            max-width: 720px;
            height: auto;
            border-radius: 18px;
            box-shadow: 0 14px 45px rgba(0, 0, 0, 0.10);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .photo-moments-section {
                padding: 48px 0;
            }

            .photo-moments-content h2 {
                font-size: 2.1rem;
            }

            .photo-moments-image {
                margin-top: 28px;
                text-align: center;
            }
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
        
        
    /* =========================
    ICON CARD TRUST SECTION (IMAGE BASED)
    ========================= */
    
    .trust-card-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-top: 50px;
    }
    
    .trust-card {
        background: rgb(251, 246, 246);
        border-radius: 18px;
        padding: 32px 26px;
        text-align: center;
    }
    
    .trust-icon {
        width: 105px;
        height: 105px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: rgba(235, 35, 113, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .trust-icon img {
        width: 65px;
        height: 65px;
        object-fit: contain;
    }
    
    .trust-card h4 {
        font-size: 1.05rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .trust-card p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #444;
        margin: 0;
    }
    
    .trust-cta {
        margin-top: 40px;
    }
    
    /* Tablet */
    @media (max-width: 991px) {
        .trust-card-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }
    }
    
    /* Mobile */
    @media (max-width: 576px) {
        .trust-card-grid {
            grid-template-columns: 1fr;
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
                                No Nails, No Stickers, No Wall Marks
                            </h1>

                            <div>
                                <a href="{{ route('design') }}" class="btn custom-btn">
                                    Design Your Frame
                                </a>

                                <a href="{{ route('collections') }}" class="btn custom-btn ms-3">
                                    Your Collections
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- =========================
    FIRST SECTION UNDER BANNER VIDEO (UNDER HERO VIDEO)
    ========================= -->

    <section class="benefit-strip">
        <div class="container">
            <div class="row justify-content-center g-4">

                <!-- 1) Free shipping -->
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <img src="{{ asset('assets/icons/shipping.jpg') }}" alt="Free shipping"
                                class="benefit-icon-img">
                        </div>
                        <div class="benefit-title">Free shipping</div>
                        <p class="benefit-subtitle">Free shipping on all orders</p>
                    </div>
                </div>

                <!-- 2) Wall friendly -->
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <img src="{{ asset('assets/icons/no-nail.png') }}" alt="Wall friendly" class="benefit-icon-img">
                        </div>
                        <div class="benefit-title">Wall friendly</div>
                        <p class="benefit-subtitle">Leaves no marks</p>
                    </div>
                </div>
                
                <!-- 3) Made in US -->
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <img src="{{ asset('assets/icons/made-in-us.jpg') }}" alt="Made in US"
                                class="benefit-icon-img">
                        </div>
                        <div class="benefit-title">Materials from US</div>
                        <p class="benefit-subtitle">US &amp; Euro standard finishing</p>
                    </div>
                </div>

                <!-- 3) Made in India -->
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <img src="{{ asset('assets/icons/made-in-india.png') }}" alt="Made in India"
                                class="benefit-icon-img">
                        </div>
                        <div class="benefit-title">Made in India</div>
                        <p class="benefit-subtitle">Designed &amp; assembled in India</p>
                    </div>
                </div>

            </div>
        </div>
    </section>




    <!-- =========================
    SECOND SECTION UNDER BANNER VIDEO (UNDER HERO VIDEO)
    ========================= -->
    <section class="photo-moments-section">
        <div class="container">
            <div class="row align-items-center">

                <!-- LEFT: Text -->
                <div class="col-lg-5">
                    <div class="photo-moments-content">
                        <h2>Decorate your wall with life’s special moments.</h2>

                        <p>
                            Upload your favorite photos and choose a frame style you love.
                            We’ll print, frame, and deliver. Ready to hang without nails or wall damage.
                        </p>

                        <a href="{{ route('design') }}" class="btn photo-moments-btn">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- RIGHT: Image -->
                <div class="col-lg-7">
                    <div class="photo-moments-image">
                        <img src="{{ asset('assets/images/my-collage-banner-1.png') }}"
                            alt="Decorate your wall with moments" loading="lazy">
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
                            Your Phone Photos to Magnetick<span> Hanging</span>
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
                            <video class="img-fluid" autoplay muted loop playsinline preload="metadata"
                                style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_1_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                        <div class="tab-pane fade" id="v-pills-hooks" role="tabpanel"
                            aria-labelledby="v-pills-hooks-tab" tabindex="0">
                            <video class="img-fluid" autoplay muted loop playsinline preload="metadata"
                                style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_2_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                        <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"
                            tabindex="0">
                            <video class="img-fluid" autoplay muted loop playsinline preload="metadata"
                                style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_3_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                        <div class="tab-pane fade" id="v-pills-again" role="tabpanel"
                            aria-labelledby="v-pills-again-tab" tabindex="0">
                            <video class="img-fluid" autoplay muted loop playsinline preload="metadata"
                                style="pointer-events: none;">
                                <source src="{{ asset('assets/video/Video_4_Photo.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="custom-tabs-section py mobile_view_tabs">
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
                                <h4>Adjust to position</h4>
                                <video class="img-fluid" autoplay muted loop playsinline>
                                    <source src="{{ asset('assets/video/Video_2_Photo.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                            <div class="peel_stick">
                                <h4>Leaves no marks</h4>
                                <video class="img-fluid" autoplay muted loop playsinline>
                                    <source src="{{ asset('assets/video/Video_3_Photo.mp4') }}" type="video/mp4">
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

 
    

    <section class="clusters-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="text-center">
                        <h2 class="heading-2">Collections For Your Memorable Walls</h2>
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
                                                        ₹ {{ number_format($finalPrice, 0) }}
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
                            class="btn design-btn filled">
                            View All Collections
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>
    
    
       <!-- =========================
    CENTERED TRUST SECTION
    ========================= -->

    <section class="premium-trust-section">
        <div class="container">
    
            <div class="text-center">
                <h2 class="trust-title">We’ve Got You Covered</h2>
            </div>
    
            <!-- ICON CARDS -->
            <div class="trust-card-grid">
    
                <div class="trust-card">
                    <div class="trust-icon">
                        <img src="{{ asset('assets/icons/magnet.png') }}"
                             alt="Magnetic mounting system">
                    </div>
                    <h4>Magnetic Mounting System</h4>
                    <p>
                        A refined, calibrated magnetic system 
                        provides lifetime stability.
                    </p>
                </div>
                
    
                <div class="trust-card">
                    <div class="trust-icon">
                        <img src="{{ asset('assets/icons/rental-safe.png') }}"
                             alt="Rental home safe">
                    </div>
                    <h4>Rental‑Home Safe</h4>
                    <p>
                        Designed to hold frames securely while keeping your walls untouched.
                    </p>
                </div>
    
                <div class="trust-card">
                    <div class="trust-icon">
                        <img src="{{ asset('assets/icons/indian-wall.png') }}"
                             alt="Built for Indian walls">
                    </div>
                    <h4>Built for Indian Walls</h4>
                    <p>
                        Inspired by premium American and European mounting standards,
                        adapted for Indian painted walls.
                    </p>
                </div>
    
            </div>
    
            <!-- CTA -->
            <div class="text-center trust-cta">
                <a href="{{ route('design') }}" class="btn design-btn filled">
                    Design Your Frame
                </a>
            </div>
    
        </div>
    </section>
    
    <!-- ✅ MOBILE-ONLY MAIN BANNER (correct mobile position) -->
    <section class="main-banner-section d-block d-md-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="main-title">
                            <span class="heading-2">
                                Turn your photos into a masterpiece
                            </span>
                            <span class="heading-1">
                                let your walls tell your story
                            </span>
                        </h1>

                        <button type="button" class="btn design-btn filled"
                            onclick="window.location.href='{{ route('design') }}';">
                            Design your frame
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="main-banner-section d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="text-center">
                        <h1 class="main-title">
                            <span class="heading-2">Turn your
                                photos into a masterpiece</span>
                            <span class="heading-1">let your walls tell your story</span>
                        </h1>
                        <button type="button" class="btn design-btn filled"
                            onclick="window.location.href='{{ route('design') }}';">
                            <!-- <svg width="26.122" height="26.849" class="w-em h-em me-2 ttl-26 mb-0"
                                    viewBox="0 0 26.122 26.849" xmlns="http://www.w3.org/2000/svg">
                                    <g transform="translate(-858.42 -842.908)">
                                        <path fill="currentColor" transform="translate(866.746 842.818)"
                                            d="M16.622.112c-.067,0-.089.045-.134.067L8.121,6.114a1.558,1.558,0,0,0-.29.357l-.29.558a5.119,5.119,0,0,1,3.347,3.347l.558-.29A1.457,1.457,0,0,0,11.8,9.8l5.935-8.367c.067-.112.089-.2,0-.29L16.756.157A.193.193,0,0,0,16.622.09ZM5.957,8.97a2.947,2.947,0,0,0-2.923,2.99,5.983,5.983,0,0,1-2.99,5.154,6.135,6.135,0,0,0,2.99.759,5.918,5.918,0,0,0,5.935-5.935,3,3,0,0,0-2.99-2.99Z">
                                        </path>
                                        <path fill="currentColor" transform="translate(859.67 845.317)"
                                            d="M23.511,24.441H-1.25V-1.25H14.126V1.2H1.2v20.8H21.064V8.171h2.447Z"></path>
                                    </g>
                                </svg> -->
                            Design your frame
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
                       <!--  <svg width="20" height="20" viewBox="0 0 20 20" class="w-em h-em me-1 ttl-20 mb-0"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" transform="translate(-2 -2)"
                                d="M10,16.5,16,12,10,7.5ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20Z">
                            </path>
                        </svg> -->
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
                        <button type="button" class="btn design-btn filled"
                            onclick="window.location.href='{{ route('design') }}';">
                            <!-- <svg width="20" height="20" viewBox="0 0 20 20" class="w-em h-em me-1 ttl-20 mb-0"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor" transform="translate(-2 -2)"
                                        d="M10,16.5,16,12,10,7.5ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20Z">
                                    </path>
                                </svg> -->
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
                    Elevate the moments hidden in your phone or computer into bold, beautiful wall art, where every
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
                        <img src="{{ asset('assets/images/Needy-poor3.webp') }}" loading="lazy" class="img-fluid"
                            alt="" style=" margin-left: 41px; height: 500px;">
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
            <img src="{{ asset('assets/images/home-enquire-bg-v2mob.jpg') }}" loading="lazy" class="img-fluid"
                alt="" style="display: none">
        </div>
        <div class="container">
            <div class="text-center text-lg-start HomeEnquire_homeEnquireContent">
                <div class="newframeimg">
                    <h3 class="heading-4">For Business Inquiries, <span class="d-block">Retails or Bulk Ordering,</span>
                    </h3>
                    <button type="button" class="btn design-btn filled"
                        onclick="window.location.href='{{ route('contact') }}'">
                        Contact Us
                    </button>
                </div>
                <div class="newframe-sideimg">
                    <img src="{{ asset('assets/images/bulkOrder-5.webp') }}" loading="lazy" class="img-fluid"
                        alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

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
                button.addEventListener("shown.bs.tab", function(e) {
                    const targetSelector = e.target.getAttribute("data-bs-target");
                    resetAllTabVideos(); // <-- NEW: stop others
                    playVideoInPane(targetSelector); // <-- keep your behavior
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
