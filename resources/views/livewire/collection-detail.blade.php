@extends('components.layouts.app')

@section('title', 'Collectio Detail')

@section('content')
<section class="productDetailSection">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-decoration-none"><a href="/">Home</a></li>
                        <li class="breadcrumb-item text-decoration-none"><a href="/clusters">Clusters</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Symmetry</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">

                <div class="swiper frame-layout-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">

                            <div class="Parentframe">
                                <figure class="frameBackground">
                                    <img src="{{ asset('assets/images/1700549009188.png') }}" class="imgfluid" alt="">
                                </figure>
                                <div class="framelayoutsParent">
                                    <!-- dynamic frames -->
                                    @for ($i = 1; $i <= 8; $i++)
                                        <!-- frame {{ $i }} -->
                                        <div class="clusterFrameWrp" id="cluster-block-{{ $i }}">
                                            <div class="frame-main-wrap">
                                                <div class="frameborder">
                                                    <div class="frameinner">
                                                        <label for="upload-photo-cluster">
                                                            <button type="button" class="clusterAddBtn__Rreup">
                                                                <div class="ratio ratio-1x1 d-flex align-items-center justify-content-center">
                                                                    <svg width="16" height="16" class="w-em h-em d-block mw-100 mh-100 top-50 start-50 translate-middle" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"></path>
                                                                    </svg>
                                                                </div>
                                                            </button>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- frame {{ $i }} -->
                                    @endfor

                                    <!-- dynamic frames -->
                                </div>

                                <button type="button" id="#zoombtn" class="btn custom-btn filled rounded">Zoom 1.5x</button>

                            </div>
                        </div>

                        <div class="swiper-slide">
                            <figure class="frameBackground">
                                <img src="{{ asset('assets/images/1700549009289.webp') }}" class="imgfluid" alt="">
                            </figure>
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                </div>
            </div>
            <div class="col-lg-5">
                <div class="parentRightAccordiance">
                    <div class="accordingheader">
                        <h3 class="heading-5">
                            Symmetry
                        </h3>
                        <div class="pricedetails">
                            <h5>
                                <span class="currency">₹</span>3674
                            </h5>
                            <p class="discount">
                                20% OFF
                            </p>
                        </div>
                        <p class="noted">
                            All Taxes Included
                        </p>
                    </div>

                    <div class="parentaccording">
                        <h3 class="heading-6">
                            Customise your wall
                        </h3>
                        <div class="accordion accordion-flush" id="customizedoptions">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">

                                        <span class="customTilename">Finish</span>
                                        <span class="text-body-tertiary">(4)</span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5" class="w-em h-em ClusterDetails_infoBtn__5lLNm">
                                                <g transform="translate(-1.021 -1.021)">
                                                    <circle cx="8" cy="8" r="8" transform="translate(1.771 1.771)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
                                                    <path d="M12,15.109V12" transform="translate(-2.229 -2.229)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <path d="M12,8h.008" transform="translate(-2.229 -1.337)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                </g>
                                            </svg>
                                        </span>

                                    </button>
                                </h2>
                                <div id="flush-collapse1" class="accordion-collapse collapse" data-bs-parent="#customizedoptions">
                                    <div class="accordion-body">

                                        <ul class="designToolPropertiesLists CustomizeOption">
                                            <!-- Dropdown menu links -->


                                            <li type="button" class="parentProperties frame-change active">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Normal</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Matte</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Gloss</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Canvas</p>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">

                                        <span class="customTilename">Color</span>
                                        <span class="text-body-tertiary">(4)</span>


                                    </button>
                                </h2>
                                <div id="flush-collapse2" class="accordion-collapse collapse" data-bs-parent="#customizedoptions">
                                    <div class="accordion-body">

                                        <ul class="designToolPropertiesLists CustomizeOption">
                                            <!-- Dropdown menu links -->


                                            <li type="button" class="parentProperties frame-change active">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Black</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Dark</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">White</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Light</p>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">

                                        <span class="customTilename">Frame</span>
                                        <span class="text-body-tertiary">(2)</span>


                                    </button>
                                </h2>
                                <div id="flush-collapse3" class="accordion-collapse collapse" data-bs-parent="#customizedoptions">
                                    <div class="accordion-body">

                                        <ul class="designToolPropertiesLists CustomizeOption">
                                            <!-- Dropdown menu links -->

                                            <li type="button" class="parentProperties frame-change active">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Classic</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Bold</p>
                                                </div>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="addtocardbtn">
                        <button type="button" class="btn custom-btn filled">
                            Add to Cart
                        </button>
                        <button type="button" class="btn custom-btn transparent copied">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.58" height="12.58" viewBox="0 0 12.58 12.58" class="w-em h-em">
                                <g transform="translate(0.5 0.5)">
                                    <path d="M14.8,13.5h5.867a1.3,1.3,0,0,1,1.3,1.3v5.867a1.3,1.3,0,0,1-1.3,1.3H14.8a1.3,1.3,0,0,1-1.3-1.3V14.8A1.3,1.3,0,0,1,14.8,13.5Z" transform="translate(-10.395 -10.395)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"></path>
                                    <path d="M4.956,11.475H4.3a1.3,1.3,0,0,1-1.3-1.3V4.3A1.3,1.3,0,0,1,4.3,3h5.867a1.3,1.3,0,0,1,1.3,1.3v.652" transform="translate(-3 -3)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"></path>
                                </g>
                            </svg>
                        </button>
                    </div>

                    <div class="productdeatailslist">
                        <h5 class="heading-6">Product Details</h5>
                        <ul class="ClusterDetails_detailsList">
                            <li>All sizes are in inches</li>
                            <li>Box will contain frames with your images on the corresponding frames</li>
                            <li>Frames are thin and super light, easy to ship and install</li>
                            <li>Frames do not contain glass</li>
                            <li>Frames with tape option are not re-stickable</li>
                            <li>Frames are made from eco-friendly recycled polystyrene and printed on paper-free</li>
                            <li>Vinyl media with water based inks that are easier on the environment</li>
                        </ul>
                    </div>

                    <div class="noticeproductdetail">
                        <p>
                            Frameley frames are made to order. Once you place an order, we take about 1-2 working days to manufacture your beautiful frames. It is then shipped & timings can vary due to holidays, closures, weather etc. Please anticipate delays when placing your order. For estimated times, please check out our shipping policy.
                        </p>
                    </div>
                    <div class="productpolicylinks">
                        <a class="" href="javascript:;">Shipping Policy</a>
                        <a class="" href="javascript:;">FAQ's</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')

@endpush
