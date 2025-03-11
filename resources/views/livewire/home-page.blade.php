@extends('components.layouts.app')

@section('title', 'Home Page')

@section('content')
    <section class="custom-hero-slider-section">
        <div class="container">
            <div class="fogeffect">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="custom-hero-slider-parent">
                            <span class="position-absolute z-2 bannerFrame"></span>
                            <div>
                                <div class="swiper main-banner-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-8.webp">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-9.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-10.webp">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-11.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-12.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-14.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-15.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-16.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-17.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-18.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-19.jpg">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="innerFrame">
                                                <img alt="Banner image" width="450px" height="500px"
                                                    src="assets/images/banner/samp-20.jpg">
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
    </section>

    <section class="main-banner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="main-title">
                            <span class="heading-2">Turn your
                                photos into a masterpiece</span>
                            <span class="heading-1">let your walls tell your story</span>
                        </h1>
                        <button type="button" class="btn custom-btn filled" onclick="window.location.href='{{ route('design') }}';">
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
                <div class="col-lg-12">
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
                <div class="col-lg-12">
                    <div class="swiper swiper-horizontal">
                        <div class="swiper-wrapper">

                            @foreach($products as $product)
                                @php
                                    $discountAmount = ($product->price * $product->discount) / 100;
                                    $finalPrice = $product->price - $discountAmount;
                                    $url = url('collection') . '/' . $product->slug;
                                @endphp
                                <div class="swiper-slide">
                                    <div class="ClusterCard" onclick="redirectTo('{{ $url }}')">
                                        <div class="ImgFrame">
                                            <img alt="{{ $product->name }}" class="img-fluid" src="{{ asset($product->image) }}">
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
                        <button type="button" onclick="window.location.href='{{ route('collections') }}';" class="btn custom-btn filled">
                            View All Collections
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="about-section py">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="parentRightAbout">
                        <div class="RightSliderChild whyChooseUs">
                            <h2 class="heading-3">LED Photo Frames</h2>
                            <p style=" font-size: 29px; line-height: 52px; ">
                                Illuminate your memories with MixPhotoTiles
                                elegant LED photo frames, where sophistication meets sentiment.
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn custom-btn filled mt-5"
                        onclick="window.location.href='{{ route('design') }}';">
                        <svg width="20" height="20" viewBox="0 0 20 20"
                            class="w-em h-em me-1 ttl-20 mb-0" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" transform="translate(-2 -2)"
                                d="M10,16.5,16,12,10,7.5ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20Z">
                            </path>
                        </svg>
                        Design your frame
                    </button>
                </div>
                <div class="col-lg-6">
                    <!-- Swiper Slider Start -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <figure>
                                    <img src="assets/images/led_frame_5.jpeg" class="img-fluid" alt="">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure>
                                    <img src="assets/images/led_frame_6.jpeg" class="img-fluid" alt="">
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
    </section>

    <section class="custom-tabs-section py">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="custom-tabs-content">
                        <h2 class="heading-3">
                            Two options for <span>hanging</span>
                        </h2>
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="active" id="v-pills-tap-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-tap" type="button" role="tab"
                                    aria-controls="v-pills-tap" aria-selected="true">
                                    Free re-stickable tape roll
                                </button>
                                <button class="" id="v-pills-hooks-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-hooks" type="button" role="tab"
                                    aria-controls="v-pills-hooks" aria-selected="true">
                                    Free hanging hooks
                                </button>
                                <button class="" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true">
                                    Just peel and stick & Leave no marks Or
                                </button>
                                <button class="" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false">
                                    Just screw the hooks & Hang
                                </button>
                                {{-- <button class="" id="v-pills-messages-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-messages" type="button" role="tab"
                                    aria-controls="v-pills-messages" aria-selected="false">
                                    Leaves no marks
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="tab-content customTabsContent" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-tap" role="tabpanel"
                            aria-labelledby="v-pills-tap-tab" tabindex="0">
                            <figure class="Tabframed">
                                <img src="assets/images/frame11.jpg" class="img-fluid" alt="">
                            </figure>
                        </div>
                        <div class="tab-pane fade" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab" tabindex="0">
                            <figure class="Tabframed">
                                <img src="assets/images/frame1.webp" class="img-fluid" alt="">
                            </figure>
                        </div>
                        <div class="tab-pane fade" id="v-pills-hooks" role="tabpanel"
                            aria-labelledby="v-pills-hooks-tab" tabindex="0">
                            <figure class="Tabframed">
                                <img src="assets/images/frame22.jpg" class="img-fluid" alt="">
                            </figure>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab" tabindex="0">
                            <figure class="Tabframed">
                                <img src="assets/images/frame2.jpg" class="img-fluid" alt="">
                            </figure>
                        </div>
                        {{-- <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab" tabindex="0">
                            <figure class="Tabframed">
                                <img src="assets/images/frame3.jpg" class="img-fluid" alt="">
                            </figure>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section py">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="parentRightAbout">
                        <div class="RightSliderChild">
                            <h2 class="heading-3"><span class="sec-2-span">MixPhotoTiles</span> have Got You Covered</h2>
                        </div>
                        <div class="RightSliderChild">
                            <div class="swiper AboutSlider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="AboutSliderParent">
                                            <h5><b>Fast Door Delivery</b></h5>
                                            <p>No minimum order
                                                required</p>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="AboutSliderParent">
                                            <h5><b>Luxury walls for everyone</b></h5>
                                            <p>Thoughtfully priced for every class, every home</p>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="AboutSliderParent">
                                            <h5><b>Sleek & Sturdy</b></h5>
                                            <p>Gracefully crafted. Strong. Durable, with reliable wooden back support</p>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="AboutSliderParent">
                                            <h5><b>Happiness Guaranteed</b></h5>
                                            <p>We measure our success by the joy we bring to your heart</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn custom-btn filled mt-5"
                                onclick="window.location.href='{{ route('design') }}';">
                                <svg width="20" height="20" viewBox="0 0 20 20"
                                    class="w-em h-em me-1 ttl-20 mb-0" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor" transform="translate(-2 -2)"
                                        d="M10,16.5,16,12,10,7.5ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.011,8.011,0,0,1,12,20Z">
                                    </path>
                                </svg>
                                Design your frame
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <figure>
                        <img src="assets/images/home-company-img.png" class="img-fluid" alt="">
                    </figure>
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
                    @for($i = 1; $i <= 3; $i++)
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Wedding image" class="img-fluid" src="assets/images/Animal_1.webp">
                                    </div>
                                    <p>Animal</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-xl card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="nature image" class="img-fluid" src="assets/images/Birds.avif">
                                    </div>
                                    <p>Birds</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-lg card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Childhood image" class="img-fluid" src="assets/images/Child.jpeg">
                                    </div>
                                    <p>Childhood</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-md card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="sea image" class="img-fluid" src="assets/images/Dog_1.jpg">
                                    </div>
                                    <p>Dog</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Memory image" class="img-fluid" src="assets/images/Food.webp">
                                    </div>
                                    <p>Food</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-xl card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Art image" class="img-fluid" src="assets/images/Memories_1.jpg">
                                    </div>
                                    <p>Memories</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-lg card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Travel image" class="img-fluid" src="assets/images/Nature.jpeg">
                                    </div>
                                    <p>Nature</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-md card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Passion image" class="img-fluid" src="assets/images/Passion.webp">
                                    </div>
                                    <p>Passion</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Art image" class="img-fluid" src="assets/images/wedding_1.jpeg">
                                    </div>
                                    <p>Wedding</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-xl card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Art image" class="img-fluid" src="assets/images/wedding_2.jpeg">
                                    </div>
                                    <p>Wedding</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-md card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Passion image" class="img-fluid" src="assets/images/Passion.webp">
                                    </div>
                                    <p>Passion</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="HomeFrameSlider_frameCard fr-sm card">
                                <div class="card-body">
                                    <div class="HomeFrameSlider_frameImg ratio">
                                        <img alt="Memory image" class="img-fluid" src="assets/images/Food.webp">
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
                <div class="col-lg-6">
                    <div class="parentRightAbout">
                        <div class="RightSliderChild whyChooseUs">
                            <h2 class="heading-3">Why choose us?</h2>
                            <p>
                                Because every order you place is more than just a purchase, it’s a lifeline.
                                A part of our profits goes toward helping those in need, the homeless and the hungry with children.
                            </p>
                            <p>
                                We willingly cut a significant share of our earnings because we believe no one should go without a meal.
                                With every purchase, you’re not just bringing beauty into your home; you're putting food on someone’s plate,
                                offering hope, and restoring dignity. This is not just our mission, it's something we do hand in hand with you.
                                And with every meal served, their heartfelt prayers and gratitude extend beyond us, they reach you too.
                            </p>
                            <p>
                                Together, we’re not just creating art for walls; we’re creating a ripple of kindness and compassion.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <figure>
                        <img src="assets/images/why-choose-use-1.jpg" class="img-fluid" alt="" style=" margin-left: 41px; ">
                    </figure>
                </div>
            </div>

        </div>
    </section>

    <section class="faqSection py">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="mx-auto text-center HomeTestimonials_htContent__sML46">
                        <h2 class="heading-3">Frequently Asked Questions</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    What does Mixphototiles have to offer?
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    MixPhotoTiles offers you to create your own masterpiece with our customizable photo frames.
                                    Simply upload your images. We’ll print, frame, and deliver them right to your doorstep.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Is it simple to rearrange the tiles?
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">It’s incredibly easy! Each frame comes with strong, re-stickable adhesive stickers attached to the sides,
                                    allowing you to reposition them effortlessly. Plus, MixPhotoTiles includes a free roll of re-stickable tape, so you can move your
                                    tiles around as often as you like—without leaving any marks or damage to your walls.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    What comes with my order?
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    MixPhotoTiles frames are crafted with a solid foundation, our frames exude durability and elegance,
                                    a difference you can feel from the rest. We understand your desire for flexibility,
                                    which is why we go beyond the limited number of repositioning stickers.
                                    Instead, MixPhotoTiles provide a generous roll of re-stickable tape,
                                    allowing you to rearrange your frames effortlessly, as many times you like.
                                    Our premium adhesive ensures no residue or marks, preserving the pristine beauty of your walls.

                                    Additionally, along with a roll of re-stickable tape, we also provide a set of elegant hooks,
                                    giving you the choice to hang your frames with nails if you prefer. We care deeply about your
                                    space, your budget, and your freedom to create luxury walls that truly reflect your happiness.
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
                                    We offer premium-quality photo tiles at prices designed for everyone. Our mission is simple — to make beautiful,
                                    personalized wall décor accessible to all, regardless of class or background. We operate on a minimal profit margin,
                                    ensuring that affordability never compromises quality. More importantly, a part of every purchase goes towards
                                    providing meals for the homeless and those in need. With every frame you order, you're not just creating a wall of memories;
                                    you're sharing in a circle of hope and kindness.
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
                                <div class="accordion-body">You can explore sizes from 8" x 8" to 28" x 36", with the flexibility to customize according to your needs.
                                    Available in a range of colours, styles, and elegant options like frameless and canvas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-0 HomeEnquire_homeEnquireWrp scroll-fade">
        <div class="container">
            <div class="text-center text-lg-start HomeEnquire_homeEnquireContent">
                <h3 class="heading-4">Looking for Custom <span class="d-block">Sizing or Bulk Ordering?</span></h3>

                <button type="button" class="btn custom-btn filled">
                    Contact Us
                </button>

            </div>
        </div>
    </section>
@endsection
