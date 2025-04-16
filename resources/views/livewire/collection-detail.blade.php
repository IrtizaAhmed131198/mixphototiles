@extends('components.layouts.app')

@section('title', 'Collection Detail')

@push('css')
<style>
    /* .black-frame {
        border-image : url("{{ asset('assets/images/black-frame.png') }}");
        border-image-slice: 30;
        border-image-width: 3px;
        border-image-outset: 0;
        border-image-repeat: stretch;
    }
    .dark-frame {
        border-image : url("{{ asset('assets/images/brown-frame.png') }}");
        border-image-slice: 30;
        border-image-width: 3px;
        border-image-outset: 0;
        border-image-repeat: stretch;
    }
    .white-frame {
        border-image : url("{{ asset('assets/images/white-frame.png') }}");
        border-image-slice: 30;
        border-image-width: 3px;
        border-image-outset: 0;
        border-image-repeat: stretch;
    }
    .light-frame {
        border-image : url("{{ asset('assets/images/light-frame.png') }}");
        border-image-slice: 30;
        border-image-width: 3px;
        border-image-outset: 0;
        border-image-repeat: stretch;
    } */

    .frameinner {
        padding: 14px;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        height: 100%;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .frameinner-pad {
        padding: 3px !important;
    }
    .frameinner-less {
        padding: 0 !important;
    }

    .bold-image-width {
        border-image-width: 4px !important;
        border-image-slice: 30 fill !important;
        border-image-repeat: round !important;
        /* border: 4px solid !important; */
    }

    .selected {
        border: 3px solid red;
        cursor: pointer;
    }

    .fs-14px.fw-semibold.cursor-pointer.list-group-item {
        padding: 28px;
        cursor: pointer;
    }

    button.btn-close.position-absolute.top-0.end-0.m-3 {
        z-index: 1;
    }
</style>
@endpush

@php
    $clusters = json_decode($product->coordinates);
    // dd($collectionImages[0]['image']);
@endphp

@section('content')
<section class="productDetailSection">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-decoration-none"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item text-decoration-none"><a href="{{ route('collections') }}">Collections</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">

                <div class="swiper frame-layout-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">

                            <div class="Parentframe" id="zoomContainer">
                                <figure class="frameBackground">
                                    <img id="zoomImage" src="{{ asset($product->no_coordinates_image) }}" class="img-fluid" alt="">
                                </figure>
                                <div class="framelayoutsParent">

                                    @if($collectionImages != null)
                                        @php
                                        $colorClass = $config->color->class ?? 'black-frame';
                                        $frameClass = $config->frame->class ?? '';
                                        @endphp
                                        @foreach ($clusters as $key => $cluster)
                                            <div class="clusterFrameWrp {{ $colorClass }} {{ $frameClass }}" id="cluster-block-{{ $cluster->id }}"
                                                style="position: absolute;
                                                    top: {{ $cluster->y }}px;
                                                    left: {{ $cluster->x }}px;
                                                    width: {{ $cluster->width }}px;
                                                    height: {{ $cluster->height }}px;"
                                                data-bs-toggle="modal" data-bs-target="#editphotolayoutmodal" data-cluster-id="{{ $cluster->id }}"
                                                onclick="">

                                                <div class="frame-main-wrap">
                                                    <div class="frameborder">
                                                        <div class="frameinner d-flex align-items-center justify-content-center">
                                                            @php
                                                            $image_path = $collectionImages[$key]['image'];
                                                            @endphp
                                                            <img src="{{ asset($image_path) }}" id="preview-{{ $cluster->id }}" class="image-preview w-100 h-100 object-fit-cover" alt="Preview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- dynamic frames -->
                                    @else
                                        <!-- dynamic frames -->
                                        @foreach ($clusters as $key => $cluster)
                                            <div class="clusterFrameWrp black-frame" id="cluster-block-{{ $cluster->id }}"
                                                style="position: absolute;
                                                    top: {{ $cluster->y }}px;
                                                    left: {{ $cluster->x }}px;
                                                    width: {{ $cluster->width }}px;
                                                    height: {{ $cluster->height }}px;"
                                                data-bs-toggle="modal" data-bs-target="#photolayoutmodal" data-cluster-id="{{ $cluster->id }}"
                                                onclick="">

                                                <div class="frame-main-wrap">
                                                    <div class="frameborder">
                                                        <div class="frameinner d-flex align-items-center justify-content-center">
                                                            <svg width="32" height="32" class="image-placeholder clusterAddBtn__Rreup" fill="currentColor" viewBox="0 0 16 16">
                                                                <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor"
                                                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                                                </path>
                                                            </svg>
                                                            <img src="" id="preview-{{ $cluster->id }}" class="image-preview d-none w-100 h-100 object-fit-cover" alt="Preview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- dynamic frames -->
                                    @endif
                                </div>


                            </div>
                            <button type="button" id="zoombtn" class="btn custom-btn filled rounded">Zoom 1.5x</button>
                        </div>



                        {{-- @foreach ($product->additionalImages as $image) --}}
                        <div class="swiper-slide">
                                <figure class="frameBackground">
                                    <img src="{{ asset($product->coordinates_image) }}" alt="Additional Image" width="100">
                                </figure>
                            </div>
                        {{-- @endforeach --}}
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                </div>
            </div>
            <div class="col-lg-5">
                <div class="parentRightAccordiance">
                    <div class="accordingheader">
                        <h3 class="heading-5">
                            {{ $product->name }}
                        </h3>
                        <div class="pricedetails">
                            <h5>
                                @php
                                    $discountAmount = ($product->price * $product->discount) / 100;
                                    $finalPrice = $product->price - $discountAmount;
                                @endphp
                                @if($total_price != null)
                                    <span class="currency" data-base="{{ $total_price }}" data-val="{{ $total_price }}">₹{{ number_format($total_price, 2) }}</span>
                                @else
                                    <span class="currency" data-base="{{ $finalPrice }}" data-val="{{ $finalPrice }}">₹{{ number_format($finalPrice, 2) }}</span>
                                @endif
                            </h5>
                            <p class="discount">
                                {{ $product->discount }}% OFF
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

                            @if(get_setting('finish') == 1)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">

                                            <span class="customTilename">Finish</span>
                                            <span class="text-body-tertiary">({{ count($finish ?? 0) }})</span>
                                            {{-- <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5" class="w-em h-em ClusterDetails_infoBtn__5lLNm">
                                                    <g transform="translate(-1.021 -1.021)">
                                                        <circle cx="8" cy="8" r="8" transform="translate(1.771 1.771)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
                                                        <path d="M12,15.109V12" transform="translate(-2.229 -2.229)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                        <path d="M12,8h.008" transform="translate(-2.229 -1.337)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                    </g>
                                                </svg>
                                            </span> --}}

                                        </button>
                                    </h2>
                                    <div id="flush-collapse1" class="accordion-collapse collapse" data-bs-parent="#customizedoptions">
                                        <div class="accordion-body">

                                            <ul class="designToolPropertiesLists CustomizeOption select-finish">
                                                <!-- Dropdown menu links -->

                                                @foreach ($finish as $key => $val)

                                                    <li type="button" class="parentProperties frame-change {{ $key == 0 ? 'active' : '' }}" data-name="{{ $val->label }}" data-price="{{ $val->price }}">
                                                        <figure class="PropertiesleftChild">
                                                            <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                        </figure>
                                                        <div class="PropertiesRightChild">
                                                            <p class="propertyName">{{ $val->label }}</p>
                                                        </div>
                                                    </li>

                                                @endforeach


                                                {{-- <li type="button" class="parentProperties frame-change active" data-name="Normal" data-price="0">
                                                    <figure class="PropertiesleftChild">
                                                        <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                    </figure>
                                                    <div class="PropertiesRightChild">
                                                        <p class="propertyName">Normal</p>
                                                    </div>
                                                </li>

                                                <li type="button" class="parentProperties frame-change" data-name="Matte" data-price="453">
                                                    <figure class="PropertiesleftChild">
                                                        <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                    </figure>
                                                    <div class="PropertiesRightChild">
                                                        <p class="propertyName">Matte</p>
                                                    </div>
                                                </li>

                                                <li type="button" class="parentProperties frame-change" data-name="Gloss" data-price="492">
                                                    <figure class="PropertiesleftChild">
                                                        <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                    </figure>
                                                    <div class="PropertiesRightChild">
                                                        <p class="propertyName">Gloss</p>
                                                    </div>
                                                </li>

                                                <li type="button" class="parentProperties frame-change" data-name="Canvas" data-price="537">
                                                    <figure class="PropertiesleftChild">
                                                        <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                    </figure>
                                                    <div class="PropertiesRightChild">
                                                        <p class="propertyName">Canvas</p>
                                                    </div>
                                                </li> --}}
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">

                                        <span class="customTilename">Color</span>
                                        <span class="text-body-tertiary">({{ count($custom_color ?? 0) }})</span>


                                    </button>
                                </h2>
                                <div id="flush-collapse2" class="accordion-collapse collapse" data-bs-parent="#customizedoptions">
                                    <div class="accordion-body">

                                        <ul class="designToolPropertiesLists CustomizeOption select-color">
                                            <!-- Dropdown menu links -->

                                            @foreach ($custom_color as $key => $val)
                                                @php
                                                    $cssClassName = strtolower(str_replace(' ', '-', $val->name));
                                                    $style = '<style>';
                                                    $style .= '
                                                        .' . $cssClassName . '-frame {
                                                            border-image : url(' . asset($val->frame_img) . ');
                                                            border-image-slice: 30;
                                                            border-image-width: 3px;
                                                            border-image-outset: 0;
                                                            border-image-repeat: stretch;
                                                        }
                                                    ';
                                                    $style .= '</style>';
                                                @endphp
                                                {!! $style !!}
                                                <li type="button" class="parentProperties frame-change {{ $key == 0 ? 'active' : '' }}" data-price="{{ $val->price }}"
                                                    data-color="{{ $val->name }}" data-class="{{ $cssClassName }}-frame">
                                                    <figure class="PropertiesleftChild">
                                                        <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset($val->option_img) }}">
                                                    </figure>
                                                    <div class="PropertiesRightChild">
                                                        <p class="propertyName">{{ $val->name }}</p>
                                                    </div>
                                                </li>
                                            @endforeach


                                            {{-- <li type="button" class="parentProperties frame-change active" data-price="0"
                                                data-color="Black" data-class="black-frame">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1703756434121.jpeg') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Black</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-price="0"
                                                data-color="Dark" data-class="dark-frame">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1708685596474.jpeg') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Dark</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-price="0"
                                                data-color="White" data-class="white-frame">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/170868561394.jpeg') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">White</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-price="0"
                                                data-color="Light" data-class="light-frame">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1708685632234.jpeg') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Light</p>
                                                </div>
                                            </li> --}}
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

                                        <ul class="designToolPropertiesLists CustomizeOption select-frame">
                                            <!-- Dropdown menu links -->

                                            <li type="button" class="parentProperties frame-change active" data-name="classic"
                                                data-class="classic-image-width">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Border</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-name="bold"
                                                data-class="bold-image-width">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">No Border</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-name="frameless"
                                                data-class="frameless-image-width">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603681.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Frameless</p>
                                                </div>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>

                            @if(get_setting('led') == 1)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse4" aria-expanded="false" aria-controls="flush-collapse4">

                                            <span class="customTilename">Led</span>
                                            <span class="text-body-tertiary">(2)</span>


                                        </button>
                                    </h2>
                                    <div id="flush-collapse4" class="accordion-collapse collapse" data-bs-parent="#customizedoptions">
                                        <div class="accordion-body">

                                            <ul class="designToolPropertiesLists CustomizeOption select-led">
                                                <!-- Dropdown menu links -->

                                                @foreach ($led as $key => $val)
                                                    @php
                                                        $name = strtolower(str_replace(' ', '-', $val->name));
                                                    @endphp
                                                    <li type="button" class="parentProperties led-change {{ $key == 0 ? 'active' : '' }}" data-price="{{ $val->price }}" data-val="{{ $name }}">
                                                        <figure class="PropertiesleftChild">
                                                            <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset($val->image) }}">
                                                        </figure>
                                                        <div class="PropertiesRightChild">
                                                            <p class="propertyName">{{ $val->name }}</p>
                                                        </div>
                                                    </li>
                                                @endforeach

                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="addtocardbtn">
                        @if($collectionImages != null)
                            <button type="button" id="continue-to-cart-btn" onclick="continueToCart()" class="btn custom-btn filled">
                                Continue to Cart
                            </button>
                        @else
                            <button type="button" id="add-to-cart-btn" onclick="addToCart()" class="btn custom-btn filled">
                                Add to Cart
                            </button>
                        @endif
                        <button type="button" id="copyUrlBtn" class="btn custom-btn transparent copied">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.58" height="12.58" viewBox="0 0 12.58 12.58" class="w-em h-em">
                                <g transform="translate(0.5 0.5)">
                                    <path d="M14.8,13.5h5.867a1.3,1.3,0,0,1,1.3,1.3v5.867a1.3,1.3,0,0,1-1.3,1.3H14.8a1.3,1.3,0,0,1-1.3-1.3V14.8A1.3,1.3,0,0,1,14.8,13.5Z" transform="translate(-10.395 -10.395)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"></path>
                                    <path d="M4.956,11.475H4.3a1.3,1.3,0,0,1-1.3-1.3V4.3A1.3,1.3,0,0,1,4.3,3h5.867a1.3,1.3,0,0,1,1.3,1.3v.652" transform="translate(-3 -3)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"></path>
                                </g>
                            </svg>
                        </button>
                        <p id="copyMessage" style="display: none; font-size: 14px; color: #ff0168; margin-top: 2px; margin-left: 23rem;">Copied!</p>
                    </div>

                    <div class="productdeatailslist">
                        <h5 class="heading-6">Product Details</h5>
                        <ul class="ClusterDetails_detailsList">
                            {!! $product->description !!}
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

<!-- Modal -->
<div class="modal fade" id="editphotolayoutmodal" tabindex="-1" aria-labelledby="editphotolayoutmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="list-group list-group-flush">
                    <div class="fs-14px fw-semibold cursor-pointer list-group-item" id="crop-image">
                       <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" class="w-em h-em me-3">
                          <g transform="translate(1 1)">
                             <path d="M6,2V16a2,2,0,0,0,2,2H22" transform="translate(-2 -2)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                             <path d="M18,22V8a2,2,0,0,0-2-2H2" transform="translate(-2 -2)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                          </g>
                       </svg>
                       Crop
                    </div>
                    <div class="fs-14px fw-semibold cursor-pointer list-group-item" id="swap-image" data-bs-toggle="modal" data-bs-target="#swapphotoslayoutmodal">
                       <svg xmlns="http://www.w3.org/2000/svg" width="14.875" height="17.169" viewBox="0 0 14.875 17.169" class="w-em h-em me-3">
                          <g transform="translate(-3.25 -1.939)">
                             <path d="M16,3l3.344,3.344L16,9.688" transform="translate(-1.968)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                             <path d="M17.375,7H4" transform="translate(0 -0.656)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                             <path d="M7.344,19.688,4,16.344,7.344,13" transform="translate(0 -1.64)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                             <path d="M4,17H17.375" transform="translate(0 -2.296)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                          </g>
                       </svg>
                       Swap
                    </div>
                    <div class="fs-14px fw-semibold cursor-pointer list-group-item" id="remove-image">
                       <svg width="15.9" height="17.5" class="w-em h-em me-3" viewBox="0 0 15.9 17.5" xmlns="http://www.w3.org/2000/svg">
                          <g transform="translate(-2.25 -1.25)">
                             <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                             <path d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6" transform="translate(-0.4 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                             <path d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2" transform="translate(-1)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                             <line y2="5" transform="translate(8.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                             <line y2="5" transform="translate(12.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                          </g>
                       </svg>
                       Remove
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>


<!-- photos modal css  -->
<div class="custom-modal photoslayoutmodalparent">
    <div class="modal fade" id="photolayoutmodal" aria-hidden="true" aria-labelledby="photolayoutmodalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="SwapImageModal_swapTop">
                        <h4 class="heading-3">Add Photos</h4>
                        <p class="para">Click on the image you would like to Add</p>
                    </div>
                    <div id="upload-loader" class="text-center my-3 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Uploading...</span>
                        </div>
                        <p class="mt-2">Uploading images...</p>
                    </div>

                    <div class="row SwapImageModal_swapImages">
                        <div class="col-sm-3 col-4">
                            <div class="PlusBtn_plus">
                                <input class="d-none" accept="image/*" id="upload-photo-modal" multiple type="file"
                                    onchange="previewImage(event)">
                                <label class="PlusBtn_plus_btn" for="upload-photo-modal">
                                    <svg width="16" height="16" class="w-em h-em d-block mw-100 mh-100"
                                        fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                        </path>
                                    </svg>
                                </label>
                            </div>
                        </div>

                        @foreach ($cluster_images as $item)
                            <div class="col-sm-3 col-4 SwapImageModal_progress">
                                <div class="child-layout-photos">
                                    <img alt="Frame" id="modal-preview-{{ $item->id }}" data-id="{{ $item->id }}" class="img-fluid preview-image" src="{{ asset($item->image_path) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal-btns-parent">
                        <button type="button" class="btn custom-btn filled done-button" data-bs-dismiss="modal">Done</button>
                        <button type="button" class="btn custom-btn transparent">
                            <svg width="15.9" height="17.5" class="w-em h-em pe-1 fs-16" viewBox="0 0 15.9 17.5" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(-2.25 -1.25)">
                                    <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                    <path d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6"
                                        transform="translate(-0.4 -0.8)" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                    <path d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2"
                                        transform="translate(-1)" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                    <line y2="5" transform="translate(8.2 9)" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                    <line y2="5" transform="translate(12.2 9)" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                </g>
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="custom-modal swapphotoslayoutmodalparent">
    <div class="modal fade" id="swapphotoslayoutmodal" aria-hidden="true" aria-labelledby="swapphotoslayoutmodalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row SwapImageModal_swapImages_2">

                        @foreach ($cluster_images as $item)
                            <div class="col-sm-3 col-4 SwapImageModal_progress_2">
                                <div class="child-layout-photos">
                                    <img alt="Frame" id="swap-modal-preview-{{ $item->id }}" data-id-swap="{{ $item->id }}" class="img-fluid preview-image" src="{{ asset($item->image_path) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal-btns-parent">
                        <button type="button" class="btn custom-btn filled done-button-2" data-bs-dismiss="modal">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Crop Image Modal -->
<div id="cropImagePop" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content p-3">
        <div id="upload-demo" class="upload-demo"></div>
        <div class="mt-3 text-end">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button id="cropImageBtn" class="btn btn-primary">Crop</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {
    // Listen for any modal close event (globally)
    document.querySelectorAll('.modal').forEach(function (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            // Remove 'selected' class from all clusterFrameWrp
            document.querySelectorAll('.clusterFrameWrp.selected').forEach(function (cluster) {
                cluster.classList.remove('selected');
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    let config = @json($config);

    // Check if config is empty or null before proceeding
    if (!config || Object.keys(config).length === 0) {
        return; // Exit the script if config is empty or null
    }

    function updateActiveClass(selector, attribute, value) {
        let items = document.querySelectorAll(selector);
        items.forEach(item => {
            item.classList.remove("active");
            if (item.getAttribute(attribute) === value) {
                item.classList.add("active");
            }
        });
    }

    // Update selections only if config is valid
    if (config.color) {
        updateActiveClass(".select-color .parentProperties.frame-change", "data-class", config.color.class);
    }

    if (config.frame) {
        updateActiveClass(".select-frame .parentProperties.frame-change", "data-class", config.frame.class);
        if(config.frame.name == "bold") {
            let framinners = document.querySelectorAll('.frameinner'); // Note: It's now framinners (plural)
            framinners.forEach(framinner => { // Loop over the NodeList
                framinner.classList.add('frameinner-pad');
                framinner.classList.remove('frameinner-less');
            });
        } else if(config.frame.name == "classic") {
            let framinners = document.querySelectorAll('.frameinner'); // Note: It's now framinners (plural)
            framinners.forEach(framinner => { // Loop over the NodeList
                framinner.classList.remove('frameinner-pad');
                framinner.classList.add('frameinner-less');
            });
        } else if(config.frame.name == "frameless") {
            let framinners = document.querySelectorAll('.frameinner'); // Note: It's now framinners (plural)
            framinners.forEach(framinner => { // Loop over the NodeList
                framinner.classList.add('frameinner-less');
            });
        }
    }

    if (config.finish) {
        updateActiveClass(".select-finish .parentProperties.frame-change", "data-name", config.finish.name);
    }

    if (config.led) {
        updateActiveClass(".select-led .parentProperties.led-change", "data-val", config.led.val);
        // Disable button if LED value is "yes"
        let accordionButton = document.querySelector('[data-bs-target="#flush-collapse1"]');
        if (accordionButton) {
            if (config.led.val === "yes") {
                accordionButton.setAttribute("disabled", "disabled");
            } else {
                accordionButton.removeAttribute("disabled");
            }
        }
    }
});


let selectedConfig = {};

function updateSelectedConfig() {

    // Get the active finish
    let activeFinish = document.querySelector(".select-finish .parentProperties.active");
    if (activeFinish) {
        selectedConfig.finish = {
            name: activeFinish.getAttribute("data-name"),
            price: activeFinish.getAttribute("data-price"),
        };
    }

    // Get the active color
    let activeColor = document.querySelector(".select-color .parentProperties.active");
    if (activeColor) {
        selectedConfig.color = {
            name: activeColor.getAttribute("data-color"),
            price: activeColor.getAttribute("data-price"),
            class: activeColor.getAttribute("data-class"),
        };
    }

    // Get the active frame
    let activeFrame = document.querySelector(".select-frame .parentProperties.active");
    if (activeFrame) {
        selectedConfig.frame = {
            name: activeFrame.getAttribute("data-name"),
            class: activeFrame.getAttribute("data-class"),
        };
    }

    // Get the active led
    let activeLed = document.querySelector(".select-led .parentProperties.active");
    if (activeLed) {
        selectedConfig.led = {
            price: activeLed.getAttribute("data-price"),
            val: activeLed.getAttribute("data-val"),
        };
    }

    // console.log(selectedConfig);

    return selectedConfig;
}

let selectedClusterId = null;

// Handle image preview and upload to server
function previewImage(event) {
    const input = event.target;
    const files = input.files;

    if (files.length > 0) {
        const formData = new FormData();
        formData.append('cluster_id', selectedClusterId);

        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        // Show loader
        document.getElementById('upload-loader').classList.remove('d-none');

        fetch("{{ route('upload_images') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            const modalPreviewContainer = document.querySelector('.SwapImageModal_swapImages');
            const modalPreviewContainer2 = document.querySelector('.SwapImageModal_swapImages_2');

            data.images.forEach(img => {
                const imageDiv = document.createElement('div');
                imageDiv.className = 'col-sm-3 col-4 SwapImageModal_progress';
                imageDiv.innerHTML = `
                    <div class="child-layout-photos">
                        <img alt="Frame" id="modal-preview-${img.id}" data-id="${img.id}" class="img-fluid preview-image" src="${img.image_path}">
                    </div>
                `;
                modalPreviewContainer.appendChild(imageDiv);
                imageDiv.querySelector('.preview-image').addEventListener('click', selectSingleImage);

                const imageDiv2 = document.createElement('div');
                imageDiv2.className = 'col-sm-3 col-4 SwapImageModal_progress_2';
                imageDiv2.innerHTML = `
                    <div class="child-layout-photos">
                        <img alt="Frame" id="swap-modal-preview-${img.id}" data-id-swap="${img.id}" class="img-fluid preview-image" src="${img.image_path}">
                    </div>
                `;
                modalPreviewContainer2.appendChild(imageDiv2);
                imageDiv2.querySelector('.preview-image').addEventListener('click', selectSingleImage);
            });
        })
        .catch(error => console.error('Error uploading images:', error))
        .finally(() => {
            // Hide loader after upload is done
            document.getElementById('upload-loader').classList.add('d-none');
        });
    }
}

let selectedImageId = null;
let selectedImageSwapId = null;

document.addEventListener('DOMContentLoaded', function () {

    // Attach event listeners to existing images when the modal opens
    document.querySelectorAll('.preview-image').forEach(img => {
        img.addEventListener('click', selectSingleImage);
    });

    // Handle remove button click
    document.querySelector('.modal-btns-parent .transparent').addEventListener('click', deleteSelectedImage);
});

document.addEventListener('DOMContentLoaded', function () {
    // Attach click event to each cluster frame
    document.querySelectorAll('.clusterFrameWrp').forEach(cluster => {
        cluster.addEventListener('click', function () {
            selectedClusterId = this.id.replace("cluster-block-", ""); // Extract cluster ID
        });
    });

    // Handle "Done" button click to update preview image in cluster
    document.querySelector('.modal-btns-parent .done-button').addEventListener('click', updateClusterImage);
});

// Select only one image at a time
function selectSingleImage(event) {
    const img = event.target;

    // Deselect any previously selected image
    document.querySelectorAll('.preview-image').forEach(image => {
        image.classList.remove('selected');
    });

    // Mark the clicked image as selected
    img.classList.add('selected');
    selectedImageId = img.getAttribute('data-id');
    selectedImageSwapId = img.getAttribute('data-id-swap');
}

// Delete the selected image
function deleteSelectedImage() {
    if (!selectedImageId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select an image to delete.',
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }

    // Show loader
    document.getElementById('upload-loader').classList.remove('d-none');

    fetch("{{ route('delete_images') }}", {
        method: 'POST',
        body: JSON.stringify({ image_id: selectedImageId }),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove selected image from both containers
            const imgElement = document.querySelector(`[data-id="${selectedImageId}"]`);
            if (imgElement) {
                imgElement.parentElement.parentElement.remove();
            }

            const imgElement2 = document.querySelector(`[data-id-swap="${selectedImageId}"]`);
            if (imgElement2) {
                imgElement2.parentElement.parentElement.remove();
            }

            selectedImageId = null;
        }
    })
    .catch(error => console.error('Error deleting image:', error))
    .finally(() => {
        // Hide loader
        document.getElementById('upload-loader').classList.add('d-none');
    });
}

function updateClusterImage() {
    if (!selectedClusterId || !selectedImageId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select an image and a frame.',
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }

    const selectedImageSrc = document.querySelector(`[data-id="${selectedImageId}"]`).src;
    const clusterBlock = document.getElementById(`cluster-block-${selectedClusterId}`);
    const previewImg = document.getElementById(`preview-${selectedClusterId}`);

    if (previewImg) {
        previewImg.src = selectedImageSrc;
        previewImg.classList.remove('d-none'); // Show the image
    }

    // Find and remove the SVG inside the selected cluster
    const svgElement = clusterBlock.querySelector('.image-placeholder');
    if (svgElement) {
        svgElement.remove();
    }

    // Change `data-bs-target` to a different modal
    clusterBlock.setAttribute('data-bs-target', '#editphotolayoutmodal'); // Replace with your new modal ID

    // Close the current modal
    document.getElementById('photolayoutmodal').click();
}

document.getElementById("remove-image").addEventListener("click", function () {
    if (!selectedClusterId) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No frame selected.",
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }

    const clusterBlock = document.getElementById(`cluster-block-${selectedClusterId}`);
    const previewImg = document.getElementById(`preview-${selectedClusterId}`);

    if (previewImg) {
        previewImg.src = ""; // Clear image source
        previewImg.classList.add("d-none"); // Hide image
    }

    // Re-add the SVG placeholder if not already present
    const frameInner = clusterBlock.querySelector(".frameinner");
    if (!frameInner.querySelector(".image-placeholder")) {
        const svgPlaceholder = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svgPlaceholder.setAttribute("width", "32");
        svgPlaceholder.setAttribute("height", "32");
        svgPlaceholder.classList.add("image-placeholder", "clusterAddBtn__Rreup");
        svgPlaceholder.setAttribute("fill", "currentColor");
        svgPlaceholder.setAttributeNS(null, "viewBox", "0 0 16 16");

        const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
        path.setAttribute("stroke-width", ".5");
        path.setAttribute("fill-rule", "evenodd");
        path.setAttribute("stroke", "currentColor");
        path.setAttribute("d", "M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z");

        svgPlaceholder.appendChild(path);
        frameInner.appendChild(svgPlaceholder);
    }

    // Change back to original modal
    clusterBlock.setAttribute("data-bs-target", "#photolayoutmodal");

    // Close the current modal properly using Bootstrap's Modal API
    const editPhotoLayoutModal = document.getElementById("editphotolayoutmodal");
    const bootstrapModal = bootstrap.Modal.getInstance(editPhotoLayoutModal);
    if (bootstrapModal) {
        bootstrapModal.hide();
    }
});

let clickedPreviewImage = null;

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("editphotolayoutmodal");
    let triggerElement = null;

    if (modal) {
        // Listen for when the modal is shown
        modal.addEventListener("shown.bs.modal", function (event) {
            console.log("Edit Photo Layout Modal is opened");

            // Find the element that triggered the modal
            triggerElement = event.relatedTarget;
            if (triggerElement) {
                const clusterId = triggerElement.getAttribute("data-cluster-id");

                if (clusterId) {
                    // Find the corresponding image
                    clickedPreviewImage = document.getElementById("preview-" + clusterId);
                    console.log(clickedPreviewImage);

                } else {
                    console.error("No data-cluster-id found on trigger element.");
                }
            } else {
                console.error("Modal was opened but no related trigger element found.");
            }
        });
    } else {
        console.error("Modal with ID 'editphotolayoutmodal' not found.");
    }

    // Swap Image Logic on Button Click
    document.querySelector(".done-button-2").addEventListener("click", function () {
        if (triggerElement && selectedImageSwapId) {
            console.log("Selected image ID:", selectedImageSwapId);

            // Get the new image source from modal
            let newImageSrc = document.getElementById(`swap-modal-preview-${selectedImageSwapId}`).src;

            // Get the image inside the trigger element
            let triggerImage = triggerElement.querySelector("img.image-preview");

            if (triggerImage) {
                // Swap the image source
                triggerImage.src = newImageSrc;
                console.log("Image swapped successfully:", newImageSrc);
            } else {
                console.error("No image found inside the clicked element.");
            }
        } else {
            console.error("Trigger element or selected image ID is missing.");
        }
    });
});

//crop image
let $uploadCrop, rawImg;

document.getElementById("crop-image").addEventListener("click", function () {
    const selectedCluster = document.querySelector(".clusterFrameWrp.selected");
    if (!selectedCluster) {
        alert("Please select an image first.");
        return;
    }

    selectedClusterId = selectedCluster.getAttribute("data-cluster-id");

    const previewImg = document.getElementById(`preview-${selectedClusterId}`);
    if (!previewImg || !previewImg.src) {
        alert("No image to crop.");
        return;
    }

    rawImg = previewImg.src;

    const clusterWidth = selectedCluster.offsetWidth;
    const clusterHeight = selectedCluster.offsetHeight;

    // Destroy existing Croppie instance if any
    if ($uploadCrop) {
        $('#upload-demo').croppie('destroy');
    }

    // Initialize new Croppie instance with better zoom control
    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: clusterWidth,
            height: clusterHeight
        },
        boundary: {
            width: clusterWidth + 100,
            height: clusterHeight + 100
        },
        enforceBoundary: true,
        enableExif: true,
        enableZoom: true,
        mouseWheelZoom: 'ctrl' // Prevent accidental zooming
    });

    // Bind the image when modal opens
    $('#cropImagePop').on('shown.bs.modal', function () {
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
            console.log("Croppie bind complete.");
        });
    });

    // Show the crop modal
    $('#cropImagePop').modal('show');
});

// Handle the crop and set preview image
document.getElementById("cropImageBtn").addEventListener("click", function () {
    if (!$uploadCrop) return;

    const selectedCluster = document.querySelector(".clusterFrameWrp.selected");
    const clusterWidth = selectedCluster.offsetWidth;
    const clusterHeight = selectedCluster.offsetHeight;

    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: { width: clusterWidth, height: clusterHeight }
    }).then(function (resp) {
        document.getElementById(`preview-${selectedClusterId}`).src = resp;
        $('#cropImagePop').modal('hide');
        $('#editphotolayoutmodal').modal('hide');
    });
});




// Select a cluster when clicking
document.querySelectorAll(".clusterFrameWrp").forEach((cluster) => {
    cluster.addEventListener("click", function () {
        document.querySelectorAll(".clusterFrameWrp").forEach((el) => el.classList.remove("selected"));
        this.classList.add("selected");
    });
});

function updatePrice() {
    let basePrice = parseFloat(document.querySelector('.currency').getAttribute('data-base')) || 0;
    let framePrice = parseFloat(document.querySelector('.select-color .parentProperties.frame-change.active')?.getAttribute('data-price')) || 0;
    let finishPrice = parseFloat(document.querySelector('.select-finish .parentProperties.frame-change.active')?.getAttribute('data-price')) || 0;
    let ledPrice = parseFloat(document.querySelector('.select-led .parentProperties.led-change.active')?.getAttribute('data-price')) || 0;
    let finalPrice = 0;
    if(ledPrice != 0){
        finalPrice = basePrice + framePrice + ledPrice;
    }else{
        finalPrice = basePrice + framePrice + finishPrice;
    }

    let currencyElement = document.querySelector('.currency');
    currencyElement.innerHTML = `₹${finalPrice.toFixed(2)}`;
    currencyElement.setAttribute('data-val', finalPrice.toFixed(2));
}


document.querySelectorAll('.select-frame .parentProperties.frame-change').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.select-frame .parentProperties.frame-change').forEach(li => li.classList.remove('active'));
        this.classList.add('active');

        // Get the selected frame color attributes
        let newFrameClass = this.getAttribute('data-class'); // Use 'data-class' instead of 'data-src'
        let name = this.getAttribute('data-name'); // Use 'data-class' instead of 'data-src'
        let framinners = document.querySelectorAll('.frameinner'); // Note: It's now framinners (plural)

        if(name == "bold") {
            framinners.forEach(framinner => { // Loop over the NodeList
                framinner.classList.remove('frameinner-less');
                framinner.classList.add('frameinner-pad');
            });
        } else if(name == "frameless") {
            framinners.forEach(framinner => { // Loop over the NodeList
                framinner.classList.remove('frameinner-pad');
                framinner.classList.add('frameinner-less');
            });
        } else {
            framinners.forEach(framinner => { // Loop over the NodeList
                framinner.classList.remove('frameinner-pad');
                framinner.classList.remove('frameinner-less');
            });
        }


        // Update all clusters with the new frame class
        document.querySelectorAll('.clusterFrameWrp').forEach(cluster => {
            cluster.classList.remove('bold-image-width', 'box-shadow-dark'); // Remove all possible classes
            cluster.classList.add(newFrameClass);
        });

        updateSelectedConfig();
    });
});

document.querySelectorAll('.select-color .parentProperties.frame-change').forEach(item => {
    item.addEventListener('click', function() {
        // Remove active class from all color options
        document.querySelectorAll('.select-color .parentProperties.frame-change').forEach(li => li.classList.remove('active'));
        this.classList.add('active');

        // Get the selected frame color attributes
        let newFrameClass = this.getAttribute('data-class'); // Use 'data-class' instead of 'data-src'
        let newPrice = parseFloat(this.getAttribute('data-price')) || 0;

        // Update all clusters with the new frame class
        document.querySelectorAll('.clusterFrameWrp').forEach(cluster => {
            cluster.classList.remove('black-frame', 'dark-frame', 'white-frame', 'light-frame'); // Remove all possible classes
            cluster.classList.add(newFrameClass);
        });

        // Update the total price
        // let currencyElement = document.querySelector('.currency');
        // let basePrice = parseFloat(currencyElement.getAttribute('data-val')) || 0;
        // let finalPrice = basePrice + newPrice;
        // currencyElement.innerHTML = `₹${finalPrice.toFixed(2)}`;
        // currencyElement.setAttribute('data-val', basePrice.toFixed(2));

        updatePrice();

        updateSelectedConfig();
    });
});

document.querySelectorAll('.select-finish .parentProperties.frame-change').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.select-finish .parentProperties.frame-change').forEach(li => li.classList.remove('active'));
        this.classList.add('active');

        let name = this.getAttribute('data-name');
        let newPrice = parseFloat(this.getAttribute('data-price')) || 0;

        // Always get the base price from the currency element
        // let currencyElement = document.querySelector('.currency');
        // let basePrice = parseFloat(currencyElement.getAttribute('data-val')) || 0;

        // // Calculate final price correctly
        // let finalPrice = basePrice + newPrice;
        // currencyElement.innerHTML = `₹${finalPrice.toFixed(2)}`;
        // currencyElement.setAttribute('data-val', basePrice.toFixed(2));

        updatePrice();

        updateSelectedConfig();
    });
});

document.querySelectorAll('.select-led .parentProperties.led-change').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.select-led .parentProperties.led-change').forEach(li => li.classList.remove('active'));
        this.classList.add('active');

        let value = this.getAttribute('data-val');
        // let newPrice = parseFloat(this.getAttribute('data-price')) || 0;

        // // Always get the base price from the currency element
        // let currencyElement = document.querySelector('.currency');
        // let basePrice = parseFloat(currencyElement.getAttribute('data-val')) || 0;

        // // Calculate final price correctly
        // let finalPrice = basePrice + newPrice;
        // currencyElement.innerHTML = `₹${finalPrice.toFixed(2)}`;
        // currencyElement.setAttribute('data-val', basePrice.toFixed(2));

        // Disable the button if value is "yes", otherwise enable it
        let accordionButton = document.querySelector('[data-bs-target="#flush-collapse1"]');
        if (value === "yes") {
            accordionButton.setAttribute("disabled", "disabled");
        } else {
            accordionButton.removeAttribute("disabled");
        }

        updatePrice();

        updateSelectedConfig();
    });
});

let zoomContainer = document.getElementById("zoomContainer");
let button = document.getElementById("zoombtn");
let isDragging = false;
let startX, startY;

document.getElementById("zoombtn").addEventListener("click", function() {
    if (zoomContainer.style.transform === "scale(2)") {
        zoomContainer.style.transform = "scale(1)"; // Zoom out
        button.textContent = "Zoom In"; // Change button text
    } else {
        zoomContainer.style.transform = "scale(2)"; // Zoom in
        button.textContent = "Zoom Out"; // Change button text
    }

    zoomContainer.style.transition = "transform 0.3s ease-in-out"; // Smooth effect
});

// Mouse Dragging functionality
zoomContainer.addEventListener("mousedown", function(e) {
    isDragging = true;
    startX = e.clientX - zoomContainer.offsetLeft;
    startY = e.clientY - zoomContainer.offsetTop;
    zoomContainer.style.transition = "none"; // Disable transition during dragging
});

document.addEventListener("mousemove", function(e) {
    if (isDragging) {
        let newX = e.clientX - startX;
        let newY = e.clientY - startY;
        zoomContainer.style.left = newX + "px";
        zoomContainer.style.top = newY + "px";
    }
});

document.addEventListener("mouseup", function() {
    isDragging = false;
    zoomContainer.style.transition = "transform 0.3s ease-in-out"; // Enable transition after dragging
});

// Mouse Wheel Zoom functionality
zoomContainer.addEventListener("wheel", function(e) {
    e.preventDefault(); // Prevent default scroll behavior
    let scale = parseFloat(zoomContainer.style.transform.replace("scale(", "").replace(")", "")) || 1;

    if (e.deltaY < 0) {
        // Zoom In
        scale += 0.1;
    } else {
        // Zoom Out
        scale = Math.max(1, scale - 0.1); // Prevent zooming out too much
    }

    zoomContainer.style.transform = `scale(${scale})`;
});


document.getElementById("copyUrlBtn").addEventListener("click", function() {
    let currentUrl = window.location.href; // Get current page URL
    navigator.clipboard.writeText(currentUrl).then(() => {
        let copyMessage = document.getElementById("copyMessage");
        copyMessage.style.display = "block"; // Show 'Copied' label

        // Hide the label after 2 seconds
        setTimeout(() => {
            copyMessage.style.display = "none";
        }, 2000);
    }).catch(err => {
        console.error("Failed to copy URL: ", err);
    });
});

function addToCart() {
    let isValid = true;
    const clusters = @json($clusters);  // Pass the clusters data to JavaScript
    let currentUrl = window.location.href;
    let colImageArr = [];
    let selectedConfigurations = {};


    clusters.forEach(cluster => {
        let imagePreview = document.getElementById(`preview-${cluster.id}`);

        if (!imagePreview.src || imagePreview.src === currentUrl) {
            // Handle the empty or uninitialized state
            isValid = false;
            // document.getElementById(`cluster-block-${cluster.id}`).style.border = '2px solid red';

        } else {
            colImageArr.push(imagePreview.src);
            // document.getElementById(`cluster-block-${cluster.id}`).style.border = ''; // Remove any previous highlight
        }
    });
    console.log(colImageArr);

    if (!isValid) {
        // Show a SweetAlert2 error message
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please upload an image for all frames before adding to cart.',
            confirmButtonText: 'OK'
        });
        return false;  // Prevent form submission or action
    }

    // Proceed with add to cart logic if all images are uploaded
    // You can add your logic to add the item to the cart here
    // Swal.fire({
    //     icon: 'success',
    //     title: 'Success!',
    //     text: 'All images uploaded! Proceeding to add to cart.',
    //     confirmButtonText: 'Proceed'
    // });

    html2canvas(document.getElementById('zoomContainer')).then(function(canvas) {
        canvas.toBlob(function(blob) {

            let price = $('.currency').attr('data-val');

            if (Object.keys(selectedConfig).length === 0) {
                selectedConfig = {
                    "led": { "val": "no", "price": "0" },
                    "color": { "name": "Black", "class": "black-frame", "price": "0" },
                    "frame": { "name": "classic", "class": "classic-image-width" },
                    "finish": { "name": "Normal", "price": "0" }
                };
            }

            let formData = new FormData();
            formData.append("image", blob, `{{ $product->name }}_${Date.now()}.png`);
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("product_id", "{{ $product->id }}");
            formData.append("name", "{{ $product->name }}");
            formData.append("quantity", 1);
            formData.append("price", price);
            formData.append("total", price);
            formData.append("slug", "{{ $product->slug }}");
            formData.append("colImageArr", JSON.stringify(colImageArr));
            formData.append("configuration", JSON.stringify(selectedConfig));

            // Send AJAX request to save image and add to cart
            $.ajax({
                url: "{{ route('add_to_cart_collection') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart',
                        text: 'Your frame has been added to the cart.'
                    }).then(() => {
                        // Redirect to cart page after success message
                        window.location.href = "{{ route('cart') }}"; // Update URL as needed
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }, "image/png");
    });

    return true;
}

function continueToCart() {
    let isValid = true;
    const clusters = @json($clusters);  // Pass the clusters data to JavaScript
    let currentUrl = window.location.href;
    let colImageArr = [];

    clusters.forEach(cluster => {
        let imagePreview = document.getElementById(`preview-${cluster.id}`);
        // console.log(imagePreview.src);

        if (!imagePreview.src || imagePreview.src === currentUrl) {
            // Handle the empty or uninitialized state
            isValid = false;
            // document.getElementById(`cluster-block-${cluster.id}`).style.border = '2px solid red';

        } else {
            colImageArr.push(imagePreview.src);
            // document.getElementById(`cluster-block-${cluster.id}`).style.border = ''; // Remove any previous highlight
        }
    });
    // console.log(colImageArr);
    // return false;

    if (!isValid) {
        // Show a SweetAlert2 error message
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please upload an image for all frames before adding to cart.',
            confirmButtonText: 'OK'
        });
        return false;  // Prevent form submission or action
    }

    // Proceed with add to cart logic if all images are uploaded
    // You can add your logic to add the item to the cart here
    // Swal.fire({
    //     icon: 'success',
    //     title: 'Success!',
    //     text: 'All images uploaded! Proceeding to add to cart.',
    //     confirmButtonText: 'Proceed'
    // });

    html2canvas(document.getElementById('zoomContainer')).then(function(canvas) {
        canvas.toBlob(function(blob) {

            let price = $('.currency').attr('data-val');

            let formData = new FormData();
            formData.append("image", blob, `{{ $product->name }}_${Date.now()}.png`);
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("product_id", "{{ $product->id }}");
            formData.append("name", "{{ $product->name }}");
            formData.append("quantity", 1);
            formData.append("price", price);
            formData.append("total", price);
            formData.append("slug", "{{ $product->slug }}");
            formData.append("exist_image", "{{ $image_name }}");
            formData.append("colImageArr", JSON.stringify(colImageArr));
            formData.append("configuration", JSON.stringify(selectedConfig));

            // Send AJAX request to save image and add to cart
            $.ajax({
                url: "{{ route('add_to_cart_collection') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart',
                        text: 'Your frame has been added to the cart.'
                    }).then(() => {
                        // Redirect to cart page after success message
                        window.location.href = "{{ route('cart') }}"; // Update URL as needed
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }, "image/png");
    });

    return true;
}

</script>
@endpush
