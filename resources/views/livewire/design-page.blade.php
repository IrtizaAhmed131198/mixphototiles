@extends('components.layouts.app')

@section('title', 'Design Page')

@push('css')
    <style>
        .ordered-list {
            padding-left: 20px;
            margin: 0;
            list-style-type: decimal;
            /* Numbers (1, 2, 3, ...) */
        }

        .ordered-list li {
            margin-bottom: 5px;
            /* Optional spacing between items */
            font-size: 14px;
            /* Optional - adjust font size */
        }

        /* @keyframes circle {
                            0% {
                                transform: rotate(0deg);
                            }

                            100% {
                                transform: rotate(360deg);

                            }
                        } */

        .progress-bar-container {
            width: 100%;
            height: 5px;
            background-color: #ddd;
            position: relative;
            margin-top: 10px;
        }

        .progress-bar {
            width: 0%;
            height: 100%;
            background-color: #4caf50;
            transition: width 0.5s;
        }

        .frameinner img {
            object-fit: fill !important;
        }

        .grid-2 {
            height: unset;
        }

        .frameless-design {
            padding: 0 !important;
        }

        .no-border-design {
            padding: 18px !important;
        }

        @media(max-width:991) {
            footer {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    <style>
        /* Hide the editing section initially */
        .FrameDesignSection {
            display: none;
        }

        /* Animation for image loading */
        /* @keyframes fadeIn {
                                                                from {
                                                                    opacity: 0;
                                                                    transform: rotate(0deg);
                                                                }

                                                                to {
                                                                    opacity: 1;
                                                                    transform: rotate(360deg);
                                                                }
                                                            } */

        .frameinner img {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
    {{-- <div class="loadermain">
        <div class="loader-container">
            <div class="loaderMain">
                <img src="{{ asset('assets/images/loader.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div> --}}
    <main class="main-design-blade" style=" margin-top: 56px; ">
        <section class="file-uploadSection" style="display: {{ count($images) > 0 ? 'none' : 'flex' }};">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="file-uploadMain">
                        <input type="file" accept="image/*" class="upload-photo" multiple="">
                        <label class="d-block">
                            <div class="MiniUploadBtn card">
                                <div class="MiniUploadBtn_uploadInner card-body">
                                    <span class="MiniUploadBtn_sign">
                                        <svg width="16" height="16" class="w-em h-em mb-0 " fill="currentColor"
                                            viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <h6 class="instruction">Upload your Photos</h6>
                                    <p class="minResolution">Minimum resolution</p>
                                    <p class="sizeuploaded">125px * 112px</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <div class="progress-bar-container" style="display: none;">
            <div class="progress-bar"></div>
        </div>

        <section class="FrameDesignSection" style="display: {{ count($images) > 0 ? 'block' : 'none' }};">
            <div class="wrapper">
                <div class="grid-parent">
                    <div class="mobile-toolbar-container">
                        <div class="grid-1">
                            <ul class="LeftSidebar_designTool">
                                <!-- 1 dropdown -->
                                <li class="designToolPropertiesChild btn-group dropend">

                                    <button type="button" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 22 22" class="w-em h-em LeftSidebar_designIcon__3UjGH">
                                            <g transform="translate(1 1)">
                                                <line x1="20" transform="translate(0 4)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></line>
                                                <line x1="20" transform="translate(0 16)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></line>
                                                <line y2="20" transform="translate(4)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></line>
                                                <line y2="20" transform="translate(16)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></line>
                                            </g>
                                        </svg>
                                        <p class="para">Frame</p>
                                    </button>
                                    <ul class="designToolPropertiesLists dropdown-menu frame-tab design_1">

                                        <!-- Dropdown menu links -->
                                        <div class="menuParent">
                                            <p class="propertyTitle">
                                                Select Frame
                                            </p>
                                        </div>

                                        <li type="button"
                                            class="parentProperties frame-change dropdown-item li-border-color "
                                            data-design="classic-card-design" data-price="0" data-text="Border">
                                            <figure class="PropertiesleftChild">
                                                <img alt="drawer" width="72" height="72" class="LeftSidebar"
                                                    src="{{ asset('assets/images/1704186592728.png') }}">
                                            </figure>
                                            <div class="PropertiesRightChild">
                                                <p class="propertyName">Border</p>
                                                <p class="propertyPrize" style="display: none">$0</p>
                                            </div>
                                        </li>

                                        <li type="button" class="parentProperties frame-change dropdown-item"
                                            data-design="bold-card-design" data-price="0" data-text="NoBorder">
                                            <figure class="PropertiesleftChild">
                                                <img alt="drawer" width="72" height="72" class="LeftSidebar"
                                                    src="{{ asset('assets/images/1704186603683.png') }}">
                                            </figure>
                                            <div class="PropertiesRightChild">
                                                <p class="propertyName">No Border</p>
                                                <p class="propertyPrize" style="display: none">$0</p>
                                            </div>
                                        </li>

                                        <li type="button" class="parentProperties frame-change dropdown-item"
                                            data-design="frameless-card-design" data-price="0" data-text="Frameless">
                                            <figure class="PropertiesleftChild">
                                                <img alt="drawer" width="72" height="72" class="LeftSidebar"
                                                    src="{{ asset('assets/images/1704186603681.png') }}">
                                            </figure>
                                            <div class="PropertiesRightChild">
                                                <p class="propertyName">Frameless</p>
                                                <p class="propertyPrize" style="display: none">$0</p>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!-- 1 dropdown -->

                                <!-- 2 dropdown -->
                                <li class="designToolPropertiesChild btn-group dropend">
                                    <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21.992" height="22"
                                            viewBox="0 0 21.992 22" class="w-em h-em LeftSidebar_designIcon__3UjGH">
                                            <g transform="translate(1 1)">
                                                <circle cx="0.5" cy="0.5" r="0.5" transform="translate(11 4)"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"></circle>
                                                <circle cx="0.5" cy="0.5" r="0.5" transform="translate(15 8)"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"></circle>
                                                <circle cx="0.5" cy="0.5" r="0.5" transform="translate(6 5)"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"></circle>
                                                <circle cx="0.5" cy="0.5" r="0.5" transform="translate(4 10)"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"></circle>
                                                <path
                                                    d="M12,2a10,10,0,0,0,0,20,1.652,1.652,0,0,0,1.648-1.688,1.712,1.712,0,0,0-.437-1.125,1.5,1.5,0,0,1-.438-1.125,1.64,1.64,0,0,1,1.668-1.668h2a5.576,5.576,0,0,0,5.555-5.554C21.965,6.012,17.461,2,12,2Z"
                                                    transform="translate(-2 -2)" fill="none" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                </path>
                                            </g>
                                        </svg>
                                        <p class="para">Color</p>
                                    </button>
                                    <ul class="designToolPropertiesLists dropdown-menu design_2">
                                        <!-- Dropdown menu links -->
                                        <div class="menuParent">
                                            <p class="propertyTitle">
                                                Select Color
                                            </p>
                                        </div>

                                        @include('partials.custom-css')

                                    </ul>
                                </li>
                                <!-- 2 dropdown -->

                                <!-- 5 dropdown -->
                                @if (get_setting('led') == 1)
                                    <li class="designToolPropertiesChild btn-group dropend">
                                        <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img width="20.414" height="20.414" class="LeftSidebar img-fluid"
                                                src="{{ asset('assets/images/led.svg') }}" alt="">
                                            <p class="para">LED</p>
                                        </button>
                                        <ul class="designToolPropertiesLists dropdown-menu design_3">
                                            <!-- Dropdown menu links -->
                                            <div class="menuParent">
                                                <p class="propertyTitle">
                                                    Select LED
                                                </p>
                                            </div>

                                            @foreach ($led as $key => $val)
                                                @php
                                                    $name = strtolower(str_replace(' ', '-', $val->name));
                                                @endphp
                                                <li type="button"
                                                    class="parentProperties dropdown-item frame-led {{ $key == 0 ? 'li-border-color' : '' }}"
                                                    data-price="{{ $val->price }}" data-val="{{ $name }}">
                                                    <figure class="PropertiesleftChild">
                                                        <img alt="drawer" width="72" height="72"
                                                            class="LeftSidebar" src="{{ asset($val->image) }}">
                                                    </figure>
                                                    <div class="PropertiesRightChild">
                                                        <p class="propertyName">{{ $val->name }}</p>
                                                        {{-- <p class="propertyPrize">Rs.{{ $val->price }}</p> --}}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                                <!-- 5 dropdown -->

                                <!-- 3 dropdown -->
                                <li class="designToolPropertiesChild btn-group dropend">
                                    <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414"
                                            viewBox="0 0 20.414 20.414" class="w-em h-em LeftSidebar_designIcon__3UjGH">
                                            <g transform="translate(1 1.414)">
                                                <path d="M21,3,9,15" transform="translate(-3 -3)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                                <path d="M12,3H3V21H21V12" transform="translate(-3 -3)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                                <path d="M16,3h5V8" transform="translate(-3 -3)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                                <path d="M14,15H9V10" transform="translate(-3 -3)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </g>
                                        </svg>
                                        <p class="para">Size</p>
                                    </button>
                                    <ul class="designToolPropertiesLists dropdown-menu design_4">
                                        <!-- Dropdown menu links -->
                                        <div class="menuParent">
                                            <p class="propertyTitle">
                                                Select Size (Inches)
                                            </p>
                                        </div>

                                        @foreach ($sizes as $key => $val)
                                            <li type="button"
                                                class="parentProperties dropdown-item frame-size {{ $key == 0 ? 'li-border-color' : '' }}"
                                                data-height="{{ $val->height }}px" data-width="{{ $val->width }}px"
                                                data-max-width="500px" data-price="{{ $val->price }}"
                                                data-val='{{ $val->label }}'>
                                                <figure class="PropertiesleftChild">
                                                    <img alt="drawer" width="72" height="72"
                                                        class="LeftSidebar" src="{{ asset($val->image) }}">
                                                </figure>
                                                <div class="PropertiesRightChild">
                                                    <p class="propertyName">{{ $val->label }}</p>
                                                    {{-- <p class="propertyPrize">Rs.{{ $val->price }}</p> --}}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <!-- 3 dropdown -->

                                <!-- 4 dropdown -->
                                @if (get_setting('finish') == 1)
                                    <li class="designToolPropertiesChild btn-group dropend" id="frame-finish-li">
                                        <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" class="w-em h-em LeftSidebar_designIcon__3UjGH">
                                                <path
                                                    d="M12,3,10.1,8.8a2,2,0,0,1-1.287,1.288L3,12l5.8,1.9a2,2,0,0,1,1.288,1.287L12,21l1.9-5.8a2,2,0,0,1,1.287-1.288L21,12l-5.8-1.9a2,2,0,0,1-1.288-1.287Z"
                                                    transform="translate(-2 -2)" fill="none" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                </path>
                                            </svg>
                                            <p class="para">Finish</p>
                                        </button>
                                        <ul class="designToolPropertiesLists dropdown-menu design_5">
                                            <!-- Dropdown menu links -->
                                            <div class="menuParent">
                                                <p class="propertyTitle">
                                                    Select Finish
                                                </p>
                                            </div>

                                            @foreach ($finish as $key => $val)
                                                <li type="button"
                                                    class="parentProperties dropdown-item frame-finish {{ $key == 0 ? 'li-border-color' : '' }}"
                                                    data-price="{{ $val->price }}" data-val="{{ $val->label }}">
                                                    <figure class="PropertiesleftChild">
                                                        <img alt="drawer" width="72" height="72"
                                                            class="LeftSidebar"
                                                            src="{{ asset('assets/images/1701851447650.png') }}">
                                                    </figure>
                                                    <div class="PropertiesRightChild">
                                                        <p class="propertyName">{{ $val->label }}</p>
                                                        {{-- <p class="propertyPrize">Rs.{{ $val->price }}</p> --}}
                                                    </div>
                                                </li>
                                            @endforeach

                                            {{-- <li type="button" class="parentProperties dropdown-item frame-finish li-border-color"
                                            data-price="{{ get_setting('average_cost') ?? 0 }}" data-val="Normal">
                                            <figure class="PropertiesleftChild">
                                                <img alt="drawer" width="72" height="72" class="LeftSidebar"
                                                    src="{{ asset('assets/images/1701851447650.png') }}">
                                            </figure>
                                            <div class="PropertiesRightChild">
                                                <p class="propertyName">Normal</p>
                                                <p class="propertyPrize">${{ get_setting('average_cost') ?? 0 }}</p>
                                            </div>
                                        </li>

                                        <li type="button" class="parentProperties dropdown-item frame-finish"
                                            data-price="453" data-val="Matte">
                                            <figure class="PropertiesleftChild">
                                                <img alt="drawer" width="72" height="72" class="LeftSidebar"
                                                    src="{{ asset('assets/images/1701851447650.png') }}">
                                            </figure>
                                            <div class="PropertiesRightChild">
                                                <p class="propertyName">Matte</p>
                                                <p class="propertyPrize">$453</p>
                                            </div>
                                        </li>
                                        <li type="button" class="parentProperties dropdown-item frame-finish"
                                            data-price="492" data-val="Gloss">
                                            <figure class="PropertiesleftChild">
                                                <img alt="drawer" width="72" height="72" class="LeftSidebar"
                                                    src="{{ asset('assets/images/1701851447650.png') }}">
                                            </figure>
                                            <div class="PropertiesRightChild">
                                                <p class="propertyName">Gloss</p>
                                                <p class="propertyPrize">$492</p>
                                            </div>
                                        </li>
                                        <li type="button" class="parentProperties dropdown-item frame-finish"
                                            data-price="537" data-val="Canvas">
                                            <figure class="PropertiesleftChild">
                                                <img alt="drawer" width="72" height="72" class="LeftSidebar"
                                                    src="{{ asset('assets/images/1701851447650.png') }}">
                                            </figure>
                                            <div class="PropertiesRightChild">
                                                <p class="propertyName">Canvas</p>
                                                <p class="propertyPrize">$537</p>
                                            </div>
                                        </li> --}}
                                        </ul>
                                    </li>
                                @endif
                                <!-- 4 dropdown -->

                                <!-- 6 dropdown -->
                                <li class="designToolPropertiesChild">
                                    <button type="button" id="openCropModal">
                                        <label class="cabinet">
                                            <svg id="item-img-output" xmlns="http://www.w3.org/2000/svg" width="22"
                                                height="22" viewBox="0 0 22 22"
                                                class="w-em h-em LeftSidebar_designIcon__3UjGH">
                                                <g transform="translate(1 1)">
                                                    <path d="M6,2V16a2,2,0,0,0,2,2H22" transform="translate(-2 -2)"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"></path>
                                                    <path d="M18,22V8a2,2,0,0,0-2-2H2" transform="translate(-2 -2)"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"></path>
                                                </g>
                                            </svg>
                                            <p class="para">Crop</p>
                                        </label>
                                    </button>
                                </li>

                                <li class="designToolPropertiesChild">
                                    <button type="button" id="reset-image">
                                        <label class="cabinet">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                viewBox="0 0 24 24" class="w-em h-em LeftSidebar_designIcon__3UjGH">
                                                <path fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    d="M1 4v6h6M3.51 9a9 9 0 1 0 .49-2" />
                                            </svg>
                                            <p class="para" title="Reset to original">Reset</p>
                                        </label>
                                    </button>
                                </li>

                                <!-- partial:index.partial.html -->
                                <!-- <div class="container mt-4">
                                                                                        <div class="row">
                                                                                            <div class="col-12 text-center">
                                                                                                <label class="cabinet">
                                                                                                    <figure>
                                                                                                        <img src="" class="gambar img-fluid img-thumbnail"
                                                                                                            id="item-img-output" />
                                                                                                        <figcaption><i class="fa fa-camera"></i></figcaption>
                                                                                                    </figure>
                                                                                                    <input type="file" class="item-img file" name="file_photo" />
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> -->
                                <!-- partial -->










                                <!-- 7 dropdown -->

                                <!-- 8 dropdown -->
                                <li class="designToolPropertiesChild btn-group dropend">
                                    <button type="button" id="remove-image" data-redirect="{{ route('design') }}">
                                        <svg width="15.9" height="17.5"
                                            class="w-em h-em LeftSidebar_designIcon__3UjGH" viewBox="0 0 15.9 17.5"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g transform="translate(-2.25 -1.25)">
                                                <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"></path>
                                                <path
                                                    d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6"
                                                    transform="translate(-0.4 -0.8)" fill="none" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                                </path>
                                                <path
                                                    d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2"
                                                    transform="translate(-1)" fill="none" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                                </path>
                                                <line y2="5" transform="translate(8.2 9)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5">
                                                </line>
                                                <line y2="5" transform="translate(12.2 9)" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5">
                                                </line>
                                            </g>
                                        </svg>
                                        <p class="para">Remove</p>
                                    </button>
                                </li>
                                <!-- 8 dropdown -->

                                <!-- 9 dropdown -->
                                {{-- <li class="designToolPropertiesChild btn-group dropend">
                                    <button class="d-sm-none">
                                        <svg class="LeftSidebar_designIcon__AcLPk" xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="20" viewBox="0 0 20 20">
                                            <g id="Group_2" data-name="Group 2" transform="translate(-762 -1646)">
                                                <g id="Rectangle_1" data-name="Rectangle 1" transform="translate(762 1646)"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect width="9" height="9" rx="1" stroke="none">
                                                    </rect>
                                                    <rect x="1" y="1" width="7" height="7" fill="none"></rect>
                                                </g>
                                                <g id="Rectangle_3" data-name="Rectangle 3" transform="translate(762 1657)"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect width="9" height="9" rx="1" stroke="none">
                                                    </rect>
                                                    <rect x="1" y="1" width="7" height="7" fill="none"></rect>
                                                </g>
                                                <g id="Rectangle_2" data-name="Rectangle 2" transform="translate(773 1646)"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect width="9" height="9" rx="1" stroke="none">
                                                    </rect>
                                                    <rect x="1" y="1" width="7" height="7" fill="none"></rect>
                                                </g>
                                                <g id="Rectangle_4" data-name="Rectangle 4" transform="translate(773 1657)"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect width="9" height="9" rx="1" stroke="none">
                                                    </rect>
                                                    <rect x="1" y="1" width="7" height="7" fill="none"></rect>
                                                </g>
                                            </g>
                                        </svg>
                                        <p class="para">More</p>
                                    </button>
                                </li> --}}
                                <!-- 9 dropdown -->
                            </ul>
                        </div>
                    </div>
                    <div class="modal fade customcroppopup" id="cropImagePop" tabindex="-1"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="myModalLabel">Edit Photo</h5> -->
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-times" aria-hidden="true"></i>

                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="upload-demo" class="mx-auto"></div>
                                </div>
                                <div class="modal-footer mt-4">
                                    <button type="button" class="btn custom-btn filled"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="cropImageBtn" class="btn custom-btn filled">Crop</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-4">
                        <div class="Right-Sidebar-footer view-grand-total-1">
                            <div class="GrandTotal">
                                <p class="">Grand Total</p>
                                <h6 class="" id="grand-total-1" data-val="{{ $item_price ?? 0 }}">₹{{ $item_price ?? 0 }}</h6>
                            </div>
                            <button type="button" class="btn custom-btn filled" id="add-to-cart-1"> Add to Cart
                                <svg width="21" height="21" viewBox="0 0 21 21"
                                    class="w-em h-em RightSidebar_addtocart_btn_icon__nIKa3"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g transform="translate(-1336 -29)">
                                        <g transform="translate(1335.75 28.891)">
                                            <path
                                                d="M5.583,2,3,5.444V19.219c.744-.008.771,0,1.722,0H18.5c0-1.634,0-.771,0-1.722V5.444L15.914,2Z"
                                                transform="translate(0)" fill="none" stroke="currentColor"
                                                stroke-width="2"></path>
                                            <line x2="15" transform="translate(3 6)" fill="none"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"></line>
                                            <path d="M14.888,10A3.444,3.444,0,1,1,8,10"
                                                transform="translate(-0.695 -1.112)" fill="none" stroke="#9d0b78"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </div>

                        <div class="grid-2">
                            <span class="caption-crop">If needed, use the Crop button to adjust your pictures</span>
                            <div class="box frame-box">
                                <div class="frame-main-wrap classic-card-design box-shadow-black frame-main-wrap-main"
                                    id="frameWrap">
                                    <div class="frameborder inherit-design" id="frameWrapChild">
                                        <div class="frameinner child-inherit-design">
                                            <!-- Placeholder for uploaded image -->
                                            <img alt="Frame" class="img-fluid" id="uploaded-image" src="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="multi-upload-Main">
                                <div class="file-uploadMain">
                                    <input type="file" accept="image/*" class="upload-photo" multiple="">
                                    <label class="d-block">
                                        <div class="MiniUploadBtn card">
                                            <div class=" MiniUploadBtn_uploadInner card-body">
                                                <span class="MiniUploadBtn_sign">
                                                    <svg width="16" height="16" class="w-em h-em mb-0 "
                                                        fill="currentColor" viewBox="0 0 16 16"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor"
                                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <h6 class="instruction">Upload</h6>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="multi-Images-frame-slider">
                                    <div class="swiper Images-frame-slider">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="box">
                                                    <div class="frame-main-wrap"
                                                        style="
                                        padding: 10px;
                                        border: 10px solid black;
                                        max-width: 310px;
                                        margin: auto;
                                        height: 100%;
                                        width: 100%;
                                        ">
                                                        <div class="frameborder">
                                                            <div class="frameinner">
                                                                <!-- Placeholder for uploaded image -->
                                                                <img alt="Frame" class="img-fluid" id="slider-image"
                                                                    srcset="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="grid-3">
                            <div class="Right-Sidebar-Cart-Parent">

                                <div class="Right-Sidebar-header">
                                    <div class="card-header">
                                        <h5 class="heading-3">Frame Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0 row g-4">
                                            <li class="col-6">
                                                <div class="d-flex align-items-center"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                        viewBox="0 0 22 22" class="w-em h-em ttl-22 mb-0">
                                                        <g transform="translate(1 1)">
                                                            <line x1="20" transform="translate(0 4)"
                                                                fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"></line>
                                                            <line x1="20" transform="translate(0 16)"
                                                                fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"></line>
                                                            <line y2="20" transform="translate(4)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"></line>
                                                            <line y2="20" transform="translate(16)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"></line>
                                                        </g>
                                                    </svg>
                                                    <div class="frame-detail">
                                                        <p class="para frame">Frame </p>
                                                        <h6 class="heading-4" id="frame-show">Border</h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="col-6">
                                                <div class="d-flex align-items-center"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="21.992" height="22"
                                                        viewBox="0 0 21.992 22" class="w-em h-em ttl-22 mb-0">
                                                        <g transform="translate(1 1)">
                                                            <circle cx="0.5" cy="0.5" r="0.5"
                                                                transform="translate(11 4)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"></circle>
                                                            <circle cx="0.5" cy="0.5" r="0.5"
                                                                transform="translate(15 8)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"></circle>
                                                            <circle cx="0.5" cy="0.5" r="0.5"
                                                                transform="translate(6 5)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"></circle>
                                                            <circle cx="0.5" cy="0.5" r="0.5"
                                                                transform="translate(4 10)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"></circle>
                                                            <path
                                                                d="M12,2a10,10,0,0,0,0,20,1.652,1.652,0,0,0,1.648-1.688,1.712,1.712,0,0,0-.437-1.125,1.5,1.5,0,0,1-.438-1.125,1.64,1.64,0,0,1,1.668-1.668h2a5.576,5.576,0,0,0,5.555-5.554C21.965,6.012,17.461,2,12,2Z"
                                                                transform="translate(-2 -2)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"></path>
                                                        </g>
                                                    </svg>
                                                    <div class="frame-detail">
                                                        <p class="para frame">Color </p>
                                                        <h6 class="heading-4" id="color-show">Black</h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="col-6">
                                                <div class="d-flex align-items-center"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414"
                                                        viewBox="0 0 20.414 20.414" class="w-em h-em ttl-22 mb-0">
                                                        <g transform="translate(1 1.414)">
                                                            <path d="M21,3,9,15" transform="translate(-3 -3)"
                                                                fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"></path>
                                                            <path d="M12,3H3V21H21V12" transform="translate(-3 -3)"
                                                                fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"></path>
                                                            <path d="M16,3h5V8" transform="translate(-3 -3)"
                                                                fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"></path>
                                                            <path d="M14,15H9V10" transform="translate(-3 -3)"
                                                                fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"></path>
                                                        </g>
                                                    </svg>
                                                    <div class="frame-detail">
                                                        <p class="para frame">Size </p>
                                                        <h6 class="heading-4" id="size-show">8" X 8"</h6>
                                                    </div>
                                                </div>
                                            </li>

                                            @if (get_setting('finish') == 1)
                                                <li class="col-6">
                                                    <div class="d-flex align-items-center"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 20 20"
                                                            class="w-em h-em ttl-22 mb-0">
                                                            <path
                                                                d="M12,3,10.1,8.8a2,2,0,0,1-1.287,1.288L3,12l5.8,1.9a2,2,0,0,1,1.288,1.287L12,21l1.9-5.8a2,2,0,0,1,1.287-1.288L21,12l-5.8-1.9a2,2,0,0,1-1.288-1.287Z"
                                                                transform="translate(-2 -2)" fill="none"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2">
                                                            </path>
                                                        </svg>
                                                        <div class="frame-detail">
                                                            <p class="para frame">Finish </p>
                                                            <h6 class="heading-4" id="finish-show">
                                                                {{ $finish[0]->label }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif

                                            @if (get_setting('led') == 1)
                                                <li class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <svg version="1.1" id="Layer_1"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                            viewBox="0 0 102.94 122.88"
                                                            style="enable-background:new 0 0 102.94 122.88;width: 16px;"
                                                            xml:space="preserve">
                                                            <g>
                                                                <path
                                                                    d="M1.69,0.03h99.55c0.44-0.08,0.91,0.04,1.25,0.38c0.27,0.27,0.41,0.63,0.41,0.99v0v0l0,0.03v119.71 c0.1,0.44-0.02,0.93-0.36,1.28c-0.07,0.07-0.14,0.13-0.22,0.18c-0.23,0.17-0.52,0.27-0.83,0.27H1.42c-0.78,0-1.4-0.63-1.4-1.4V1.61 c-0.06-0.42,0.07-0.87,0.4-1.2C0.76,0.06,1.24-0.06,1.69,0.03L1.69,0.03z M90.58,109l9.52,9.13V4.8l-9.52,9.54V109L90.58,109z M98.08,120.07l-9.53-9.14H14.46l-9.55,9.14H98.08L98.08,120.07z M2.82,118.19l9.52-9.12V14.33L2.82,4.81V118.19L2.82,118.19z M88.44,12.51l9.65-9.68H4.82l9.67,9.68H88.44L88.44,12.51z M87.76,15.33h-72.6v92.77h72.6V15.33L87.76,15.33z">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                        <div class="frame-detail">
                                                            <p class="para frame">LED Frame</p>
                                                            <h6 class="heading-4" id="led-show">No</h6>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif

                                            <li class="col-6">
                                                <div class="d-flex align-items-center hang-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        width="18" height="24.413" viewBox="0 0 18 24.413"
                                                        class="w-em h-em ttl-24 mb-0">
                                                        <g transform="translate(2638 17326.398)">
                                                            <g transform="translate(-2636.575 -17318)">
                                                                <rect width="16" height="15" rx="2"
                                                                    transform="translate(-0.425 -0.397)" fill="none"
                                                                    stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"></rect>
                                                                <circle cx="1.5" cy="1.5" r="1.5"
                                                                    transform="translate(2.575 3.603)" fill="none"
                                                                    stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"></circle>
                                                                <path
                                                                    d="M18.611,14.264,16.016,11.8a1.743,1.743,0,0,0-2.378,0L6,19.062"
                                                                    transform="translate(-3.508 -4.46)" fill="none"
                                                                    stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"></path>
                                                            </g>
                                                            <path d="M-2567-17497.715l5.251-4.811,4.893,4.811"
                                                                transform="translate(-67.072 179.128)" fill="none"
                                                                stroke="currentColor" stroke-width="2"></path>
                                                            <circle r="2" cx="2" cy="2"
                                                                fill="currentColor"
                                                                transform="translate(-2631 -17326.398)"></circle>
                                                        </g>
                                                    </svg>
                                                    <div class="frame-detail">
                                                        <p class="para frame">Hang</p>
                                                        <h6 class="heading-4" id="hang1-show">Free magentick reusable
                                                            stickers
                                                        </h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="summary-card-footer">
                                        <p class="para">Item Price</p>
                                        <h6 class="prizing" id="price-show" data-val="{{ $item_price ?? 0 }}">₹{{ $item_price ?? 0 }}</h6>
                                        <input type="hidden" name="quantity" id="quantity" value="1">
                                    </div>
                                </div>
                                <div class="Right-Sidebar-footer view-grand-total-2">
                                    <div class="GrandTotal">
                                        <p class="">Grand Total</p>
                                        <h6 class="" id="grand-total-2" data-val="0">₹0</h6>
                                    </div>
                                    <button type="button" class="btn custom-btn filled" id="add-to-cart-2"> Add to Cart
                                        <svg width="21" height="21" viewBox="0 0 21 21"
                                            class="w-em h-em RightSidebar_addtocart_btn_icon__nIKa3"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g transform="translate(-1336 -29)">
                                                <g transform="translate(1335.75 28.891)">
                                                    <path
                                                        d="M5.583,2,3,5.444V19.219c.744-.008.771,0,1.722,0H18.5c0-1.634,0-.771,0-1.722V5.444L15.914,2Z"
                                                        transform="translate(0)" fill="none" stroke="currentColor"
                                                        stroke-width="2"></path>
                                                    <line x2="15" transform="translate(3 6)" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"></line>
                                                    <path d="M14.888,10A3.444,3.444,0,1,1,8,10"
                                                        transform="translate(-0.695 -1.112)" fill="none"
                                                        stroke="#9d0b78" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </button>
                                </div>

                                <input type="hidden" name="active_config" id="active_config" value="">

                                <input type="hidden" name="url" id="url"
                                    value="{{ route('update.frame.config') }}">
                                <input type="hidden" name="upload_images" id="upload_images"
                                    value="{{ route('get.uploaded.images') }}">
                                <input type="hidden" name="delete_images" id="delete_images"
                                    value="{{ route('delete.frame.config') }}">
                                <input type="hidden" name="add_to_cart_product" id="add_to_cart_product"
                                    value="{{ route('add_to_cart_product') }}">
                                <input type="hidden" name="get_session_images" id="get_session_images"
                                    value="{{ route('get_session_images') }}">
                                <input type="hidden" name="upload_image" id="upload_image"
                                    value="{{ route('upload_image') }}">
                                <input type="hidden" name="delete_session_image" id="delete_session_image"
                                    value="{{ route('delete_session_image') }}">
                                <input type="hidden" name="get_frame_config" id="get_frame_config"
                                    value="{{ route('get_frame_config') }}">
                                <input type="hidden" name="save_cropped_image" id="save_cropped_image"
                                    value="{{ route('save_cropped_image') }}">
                                <input type="hidden" name="get_grand_total" id="get_grand_total"
                                    value="{{ route('get_grand_total') }}">
                                <input type="hidden" name="get_all_images" id="get_all_images"
                                    value="{{ route('get_all_images') }}">
                                <input type="hidden" name="add_to_cart" id="add_to_cart"
                                    value="{{ route('add_to_cart') }}">
                                <input type="hidden" name="cart_page" id="cart_page" value="{{ route('cart') }}">
                                <input type="hidden" name="reset_cropped_image" id="reset_cropped_image"
                                    value="{{ route('reset_cropped_image') }}">
                                <input type="hidden" name="getFrameDefaults" id="getFrameDefaults"
                                    value="{{ route('getFrameDefaults') }}">
                                <input type="hidden" name="delivery_cost" id="delivery_cost"
                                    value="{{ get_setting('delivery_cost') ?? 0 }}">
                                <input type="hidden" name="average_cost" id="average_cost"
                                    value="{{ get_setting('average_cost') ?? 0 }}">
                                <input type="hidden" name="base_margin" id="base_margin"
                                    value="{{ get_setting('base_margin') ?? 0 }}">
                                <input type="hidden" name="item_price" id="item_price"
                                    value="{{ $item_price ?? 0 }}">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        window.designUrl = "{{ route('design') }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exif-js/2.3.0/exif.js"></script>
    <script src="{{ asset('assets/js/design.js') }}"></script>
    <script>
        // $(document).ready(function() {
        //     setTimeout(function() {
        //         $('.loadermain').fadeOut();
        //     }, 3000);
        // })
    </script>
@endpush
