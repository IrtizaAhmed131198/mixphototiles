@extends('components.layouts.app')

@section('title', 'Collectio Detail')

@push('css')
<style>
    .black-frame {
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
    }

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

    .bold-image-width {
        border-image-width: 4px !important;
        border-image-slice: 30 fill !important;
        border-image-repeat: round !important;
        /* border: 4px solid !important; */
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
                                        <!-- dynamic frames -->
                                        @foreach ($clusters as $key => $cluster)
                                            <div class="clusterFrameWrp {{ $colorClass }} {{ $frameClass }}" id="cluster-block-{{ $cluster->id }}"
                                                style="position: absolute;
                                                    top: {{ $cluster->y }}px;
                                                    left: {{ $cluster->x }}px;
                                                    width: {{ $cluster->width }}px;
                                                    height: {{ $cluster->height }}px;"
                                                onclick="document.getElementById('upload-photo-cluster-{{ $cluster->id }}').click();">

                                                <input type="file" id="upload-photo-cluster-{{ $cluster->id }}" class="image-input d-none" accept="image/*"
                                                    onchange="previewImage(event, '{{ $cluster->id }}')">

                                                <div class="frame-main-wrap">
                                                    <div class="frameborder">
                                                        <div class="frameinner d-flex align-items-center justify-content-center">

                                                            @php
                                                            $image_path = $collectionImages[$key]['image'];
                                                            @endphp

                                                            <img src="{{ asset($image_path) }}" id="preview-{{ $cluster->id }}" class="image-preview w-100 h-100 object-fit-cover" alt="Preview">
                                                        </div>
                                                        <!-- Image Preview -->
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
                                                onclick="document.getElementById('upload-photo-cluster-{{ $cluster->id }}').click();">

                                                <input type="file" id="upload-photo-cluster-{{ $cluster->id }}" class="image-input d-none" accept="image/*"
                                                    onchange="previewImage(event, '{{ $cluster->id }}')">

                                                <div class="frame-main-wrap">
                                                    <div class="frameborder">
                                                        <div class="frameinner d-flex align-items-center justify-content-center">
                                                            <!-- Default Plus Icon -->
                                                            <svg width="32" height="32" class="image-placeholder" fill="currentColor" viewBox="0 0 16 16">
                                                                <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor"
                                                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                                                </path>
                                                            </svg>

                                                            <img src="" id="preview-{{ $cluster->id }}" class="image-preview d-none w-100 h-100 object-fit-cover" alt="Preview">
                                                        </div>
                                                        <!-- Image Preview -->
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
                                    <span class="currency" data-val="{{ $total_price }}">₹{{ number_format($total_price, 2) }}</span>
                                @else
                                    <span class="currency" data-val="{{ $finalPrice }}">₹{{ number_format($finalPrice, 2) }}</span>
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

                                        <ul class="designToolPropertiesLists CustomizeOption select-finish">
                                            <!-- Dropdown menu links -->


                                            <li type="button" class="parentProperties frame-change active" data-name="Normal" data-price="399">
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

                                        <ul class="designToolPropertiesLists CustomizeOption select-color">
                                            <!-- Dropdown menu links -->


                                            <li type="button" class="parentProperties frame-change active" data-price="0"
                                                data-color="Black" data-class="black-frame">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Black</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-price="0"
                                                data-color="Dark" data-class="dark-frame">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Dark</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-price="0"
                                                data-color="White" data-class="white-frame">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186603683.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">White</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-price="0"
                                                data-color="Light" data-class="light-frame">
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

                                        <ul class="designToolPropertiesLists CustomizeOption select-frame">
                                            <!-- Dropdown menu links -->

                                            <li type="button" class="parentProperties frame-change active" data-name="classic"
                                                data-class="classic-image-width">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1704186592728.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Classic</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties frame-change" data-name="bold"
                                                data-class="bold-image-width">
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

                                            <li type="button" class="parentProperties led-change active" data-price="0" data-val="no">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1702976645152.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">No</p>
                                                </div>
                                            </li>

                                            <li type="button" class="parentProperties led-change" data-price="1200" data-val="yes">
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72" class="LeftSidebar" src="{{ asset('assets/images/1702976624908.png') }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">Yes</p>
                                                </div>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>



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
@endsection

@push('scripts')
<script>

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
            });
        }
    }

    if (config.finish) {
        updateActiveClass(".select-finish .parentProperties.frame-change", "data-name", config.finish.name);
    }

    if (config.led) {
        updateActiveClass(".select-finish .parentProperties.led-change", "data-val", config.led.val);
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

    console.log(selectedConfig);

    return selectedConfig;
}

// Example usage: Call this function when you need the selected configurations
// console.log(updateSelectedConfig());


function previewImage(event, clusterId) {
    let input = event.target;
    let preview = document.getElementById(`preview-${clusterId}`);
    let placeholder = document.querySelector(`#cluster-block-${clusterId} .image-placeholder`);

    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove("d-none"); // Show image preview
            placeholder.classList.add("d-none"); // Hide the plus icon
        };
        reader.readAsDataURL(input.files[0]); // Convert image to Base64 for preview
    }
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
                framinner.classList.add('frameinner-pad');
            });
        } else {
            framinners.forEach(framinner => { // Loop over the NodeList
                framinner.classList.remove('frameinner-pad');
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
        let currencyElement = document.querySelector('.currency');
        let basePrice = parseFloat(currencyElement.getAttribute('data-val')) || 0;
        let finalPrice = basePrice + newPrice;
        currencyElement.innerHTML = `₹${finalPrice.toFixed(2)}`;
        currencyElement.setAttribute('data-val', finalPrice.toFixed(2));

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
        let currencyElement = document.querySelector('.currency');
        let basePrice = parseFloat(currencyElement.getAttribute('data-val')) || 0;

        // Calculate final price correctly
        let finalPrice = basePrice + newPrice;
        currencyElement.innerHTML = `₹${finalPrice.toFixed(2)}`;
        currencyElement.setAttribute('data-val', finalPrice.toFixed(2));

        updateSelectedConfig();
    });
});

document.querySelectorAll('.select-led .parentProperties.led-change').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.select-led .parentProperties.led-change').forEach(li => li.classList.remove('active'));
        this.classList.add('active');

        let value = this.getAttribute('data-val');
        let newPrice = parseFloat(this.getAttribute('data-price')) || 0;

        // Always get the base price from the currency element
        let currencyElement = document.querySelector('.currency');
        let basePrice = parseFloat(currencyElement.getAttribute('data-val')) || 0;

        // Calculate final price correctly
        let finalPrice = basePrice + newPrice;
        currencyElement.innerHTML = `₹${finalPrice.toFixed(2)}`;
        currencyElement.setAttribute('data-val', finalPrice.toFixed(2));

        // Disable the button if value is "yes", otherwise enable it
        let accordionButton = document.querySelector('[data-bs-target="#flush-collapse1"]');
        if (value === "yes") {
            accordionButton.setAttribute("disabled", "disabled");
        } else {
            accordionButton.removeAttribute("disabled");
        }

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

        if (!imagePreview.src || imagePreview.src === currentUrl) {
            // Handle the empty or uninitialized state
            isValid = false;
            // document.getElementById(`cluster-block-${cluster.id}`).style.border = '2px solid red';

        } else {
            colImageArr.push(imagePreview.src);
            // document.getElementById(`cluster-block-${cluster.id}`).style.border = ''; // Remove any previous highlight
        }
    });

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
