<header class="scrollheader">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="topmenu-logo">
                    <div class="sidehammenu" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample">
                        <img src="{{ asset('assets/images/menubar.png') }}" class="img-fluid" alt="">
                    </div>
                    <a class="main_logo" href="{{ route('home') }}">
                        @php
                            $img = get_setting('site_logo');
                        @endphp
                        @if ($img)
                            <img src="{{ asset('storage/' . $img) }}" class="img-fluid" alt="Logo">
                        @else
                            <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid" alt="Logo">
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<button class="hammenubtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
    <img src="{{ asset('assets/images/menubar.png') }}" class="img-fluid" alt="">
</button>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <a class="main_logo" href="{{ route('home') }}">
            @php
                $img = get_setting('site_logo');
            @endphp
            @if ($img)
                <img src="{{ asset('storage/' . $img) }}" class="img-fluid" alt="Logo">
            @else
                <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid" alt="Logo">
            @endif
        </a>

        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mixphototilessidemenu">
            <div class="right-navbar">
                <ul>
                    <li>
                        <a href="{{ route('cart') }}" class="nav-link">
                            <span>
                                <img src="{{ asset('assets/images/bag.svg') }}" alt="">
                            </span>
                            <span class="cart-count">
                                @php
                                    $cart = session()->get('cart', []);
                                @endphp
                                <p>{{ count($cart) ?? 0 }}</p>
                                Cart
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('home') }}"><img src="{{ asset('assets/images/home-pg.png') }}"
                            class="img-fluid" alt=""
                            style="width: 18px; height: 18px; margin-right: 10px; margin-left: 8px;'">
                        Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('design') ? 'active' : '' }}"
                        href="{{ route('design') }}"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 32 32" style="width: 32px; height: 32px; color: rgb(43, 5, 20);">
                            <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                clip-path="url(#Photo_svg__a)">
                                <path d="M15.99 16a2.09 2.09 0 1 0 0-4.18 2.09 2.09 0 0 0 0 4.18"></path>
                                <path d="M9.01 22.5a6.995 6.995 0 0 1 6.98-6.51c3.7 0 6.84 2.98 6.99 6.71"></path>
                                <path d="M22.99 9H9v13.79h13.99z"></path>
                            </g>
                            <defs>
                                <clipPath id="Photo_svg__a">
                                    <path fill="#fff" d="M8 8h15.99v15.79H8z"></path>
                                </clipPath>
                            </defs>
                        </svg> Design Your Frame</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('collections') ? 'active' : '' }}"
                        href="{{ route('collections') }}"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 32 32" style="width: 32px; height: 32px; color: rgb(43, 5, 20);">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.57 17.99 9 23h14.36l-1.29-2.53M19.47 15.41 16.18 9l-2 3.91">
                            </path>
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.32 13.01H8V18h7.32zM21.5 20a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"></path>
                        </svg> Your Collections</a>
                </li>
                {{-- <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">Installation & Care</a>
                                </li> --}}
                {{-- <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQs</a>
                                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}"><img src="{{ asset('assets/images/contact-pg.png') }}"
                            class="img-fluid" alt=""
                            style="width: 18px; height: 18px; margin-right: 10px; margin-left: 8px;'"> Contact Us</a>
                </li>
            </ul>
            <ul class="navbar-nav pt-0">
                @if (!Auth::check())
                    <li>
                        <a href="javascript:;" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"
                            class="btn custom-btn filled mt-3">Login / Sign up</a>
                    </li>
                @else
                    <li class="porfile-dropdown">
                        {{-- <a href="javascript:;" class="btn custom-btn" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 43 43"
                                class="w-em h-em ttl-44 mb-0 me-2">
                                <g transform="translate(4.369 4.281)">
                                    <circle cx="21.5" cy="21.5" r="21.5" transform="translate(-4.369 -4.282)"
                                        fill="#ffe2f8">
                                    </circle>
                                    <path d="M23.21,22.605a8.605,8.605,0,1,0-17.21,0" transform="translate(2.525 4.802)"
                                        fill="#9d0b78"></path>
                                    <circle cx="5.443" cy="5.443" r="5.443"
                                        transform="translate(11.688 7.031)" fill="#f860d2">
                                    </circle>
                                </g>
                            </svg>
                            My Profile
                            <span><i class="fa-solid fa-chevron-down"></i></span>
                        </a> --}}
                        <div class="profile-menu" aria-labelledby="dropdownMenuButton1">
                            <ul>
                                <li>
                                    <a href="{{ route('profile') }}">
                                        <span><svg width="22" height="22" viewBox="0 0 22 22"
                                                class="w-em h-em fs-18 me-2" xmlns="http://www.w3.org/2000/svg">
                                                <g transform="translate(-17 -131)">
                                                    <g transform="translate(-3539.758 221.032)">
                                                        <g fill="none" stroke-width="1.3" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            transform="translate(3563.094 -87.644)">
                                                            <circle cx="4.605" cy="4.605" r="4.605"
                                                                stroke="none"></circle>
                                                            <circle cx="4.605" cy="4.605" r="3.955"
                                                                fill="none"></circle>
                                                        </g>
                                                        <path fill="none" stroke-width="1.3" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            transform="translate(3559 -70.964) rotate(-90)"
                                                            d="M0,0C4.125,0,7.469,3.921,7.469,8.758S4.125,17.516,0,17.516">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg></span>
                                        My Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('orders') }}"><span><svg width="22" height="22"
                                                viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g transform="translate(20210 -482)">
                                                    <g transform="translate(-0.05 0.953)">
                                                        <rect width="17.896" height="11.609"
                                                            transform="translate(-20207.949 488.24)" fill="none"
                                                            stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-miterlimit="10"
                                                            stroke-width="1.3">
                                                        </rect>
                                                        <path d="M.164,3.35,2.28.158H15.969l2.08,3.193"
                                                            transform="translate(-20208.102 484.889)" fill="none"
                                                            stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-miterlimit="10"
                                                            stroke-width="1.3">
                                                        </path>
                                                        <line x2="1.886" transform="translate(-20194.793 496.511)"
                                                            fill="none" stroke="currentColor"
                                                            stroke-linecap="round" stroke-miterlimit="10"
                                                            stroke-width="1.3">
                                                        </line>
                                                    </g>
                                                </g>
                                            </svg></span>
                                        Orders</a>
                                </li>
                                <li>
                                    @if (in_array(Auth::user()->role, ['user']))
                                        <a href="{{ route('address') }}">
                                            <span><svg width="22" height="22" viewBox="0 0 22 22"
                                                    class="w-em h-em fs-18 me-2" xmlns="http://www.w3.org/2000/svg">
                                                    <g transform="translate(20197 -555)">
                                                        <g transform="translate(0.978 -10.8)">
                                                            <path fill="none" stroke-width="1.5"
                                                                stroke-miterlimit="10" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                transform="translate(-20194.016 567.763)"
                                                                d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                                            </path>
                                                            <g fill="none" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                transform="translate(-20190.488 571.316)">
                                                                <circle cx="3.574" cy="3.574" r="3.574"
                                                                    stroke="none"></circle>
                                                                <circle cx="3.574" cy="3.574" r="2.824"
                                                                    fill="none"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg></span>
                                            Addresses</a>
                                    @else
                                        <a href="{{ route('addresses.index') }}">
                                            <span><svg width="22" height="22" viewBox="0 0 22 22"
                                                    class="w-em h-em fs-18 me-2" xmlns="http://www.w3.org/2000/svg">
                                                    <g transform="translate(20197 -555)">
                                                        <g transform="translate(0.978 -10.8)">
                                                            <path fill="none" stroke-width="1.5"
                                                                stroke-miterlimit="10" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                transform="translate(-20194.016 567.763)"
                                                                d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                                            </path>
                                                            <g fill="none" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                transform="translate(-20190.488 571.316)">
                                                                <circle cx="3.574" cy="3.574" r="3.574"
                                                                    stroke="none"></circle>
                                                                <circle cx="3.574" cy="3.574" r="2.824"
                                                                    fill="none"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg></span>
                                            Addresses</a>
                                    @endif

                                </li>
                                <li>

                                    <a href="{{ route('resetpassword') }}">
                                        <span><svg width="22" height="22" viewBox="0 0 22 22"
                                                class="w-em h-em fs-18 me-2" xmlns="http://www.w3.org/2000/svg">
                                                <g transform="translate(20197 -555)">
                                                    <g transform="translate(-20210.467 157.19)">
                                                        <g fill="none" stroke-width="1.5" stroke="currentColor"
                                                            transform="translate(16 406.233)">
                                                            <rect rx="3" stroke="none" width="15.598"
                                                                height="11.438">
                                                            </rect>
                                                            <rect x="0.75" y="0.75" rx="2.25" fill="none"
                                                                width="14.098" height="9.938"></rect>
                                                        </g>
                                                        <path fill="none" stroke-width="1.5" stroke="currentColor"
                                                            stroke-miterlimit="10" transform="translate(19.442 400)"
                                                            d="M.158,6.559V3.839A3.681,3.681,0,0,1,3.839.158h.754A3.681,3.681,0,0,1,8.273,3.839v2.72">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg></span>
                                        Reset Password</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}">
                                        <span><svg width="22" height="22" viewBox="0 0 22 22"
                                                class="w-em h-em ttl-22 mb-0 me-2" xmlns="http://www.w3.org/2000/svg">
                                                <g transform="translate(20193 -761)">
                                                    <g transform="translate(0.379)">
                                                        <path fill="none" stroke-width="1.5"
                                                            stroke-miterlimit="10" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            transform="translate(-20190.537 763.96)"
                                                            d="M9.925,4.026V2.782A2.623,2.623,0,0,0,7.3.158H2.781A2.623,2.623,0,0,0,.158,2.782V13.3a2.624,2.624,0,0,0,2.623,2.626H7.3A2.624,2.624,0,0,0,9.925,13.3V12.061">
                                                        </path>
                                                        <path fill="none" stroke-width="1.5" stroke="currentColor"
                                                            stroke-miterlimit="10" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M6.207,1.765,10.582,6.14,6.473,10.251"
                                                            transform="translate(-20184.207 765.992)">
                                                        </path>
                                                        <line x1="10.257" fill="none" stroke-width="1.5"
                                                            stroke="currentColor" stroke-linecap="round"
                                                            stroke-miterlimit="10"
                                                            transform="translate(-20183.879 772.133)">
                                                        </line>
                                                    </g>
                                                </g>
                                            </svg></span>
                                        Logout</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('privacy') }}">Privacy Policy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('refund') }}">Refund Policy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('terms') }}">Terms &amp; Conditions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('shipping') }}">Shipping Policy</a>
                </li>
            </ul>
        </div>
    </div>
</div>


{{-- <header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="main_logo" href="{{ route('home') }}">
                            @php
                                $img = get_setting('site_logo');
                            @endphp
                            @if ($img)
                                <img src="{{ asset('storage/' . $img) }}" class="img-fluid" alt="Logo">
                            @else
                                <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid" alt="Logo">
                            @endif
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                        aria-current="page" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('design') ? 'active' : '' }}"
                                        href="{{ route('design') }}">Design Your Frame</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('collections') ? 'active' : '' }}"
                                        href="{{ route('collections') }}">Your Collections</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                                        href="{{ route('contact') }}">Contact Us</a>
                                </li>
                            </ul>
                            <span class="break-line"></span>
                            <div class="right-navbar">
                                <ul>
                                    <li>
                                        <a href="{{ route('cart') }}" class="nav-link">
                                            <span>
                                                <img src="{{ asset('assets/images/bag.svg') }}" alt="">
                                            </span>
                                            <span class="cart-count">
                                                @php
                                                    $cart = session()->get('cart', []);
                                                @endphp
                                                <p>{{ count($cart) ?? 0 }}</p>
                                                Cart
                                            </span>
                                        </a>
                                    </li>
                                    @if (!Auth::check())
                                        <li>
                                            <a href="javascript:;" data-bs-target="#exampleModalToggle"
                                                data-bs-toggle="modal" class="btn custom-btn">Login / Sign up</a>
                                        </li>
                                    @else
                                        <li class="porfile-dropdown">
                                            <a href="javascript:;" class="btn custom-btn" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="43" height="43"
                                                    viewBox="0 0 43 43" class="w-em h-em ttl-44 mb-0 me-2">
                                                    <g transform="translate(4.369 4.281)">
                                                        <circle cx="21.5" cy="21.5" r="21.5"
                                                            transform="translate(-4.369 -4.282)" fill="#ffe2f8">
                                                        </circle>
                                                        <path d="M23.21,22.605a8.605,8.605,0,1,0-17.21,0"
                                                            transform="translate(2.525 4.802)" fill="#9d0b78"></path>
                                                        <circle cx="5.443" cy="5.443" r="5.443"
                                                            transform="translate(11.688 7.031)" fill="#f860d2">
                                                        </circle>
                                                    </g>
                                                </svg>
                                                My Profile
                                                <span><i class="fa-solid fa-chevron-down"></i></span>
                                            </a>
                                            <div class="profile-menu dropdown-menu"
                                                aria-labelledby="dropdownMenuButton1">
                                                <ul>
                                                    <li>
                                                        <a href="{{ route('profile') }}">
                                                            <span><svg width="22" height="22"
                                                                    viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g transform="translate(-17 -131)">
                                                                        <g transform="translate(-3539.758 221.032)">
                                                                            <g fill="none" stroke-width="1.3"
                                                                                stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                transform="translate(3563.094 -87.644)">
                                                                                <circle cx="4.605" cy="4.605"
                                                                                    r="4.605" stroke="none"></circle>
                                                                                <circle cx="4.605" cy="4.605"
                                                                                    r="3.955" fill="none"></circle>
                                                                            </g>
                                                                            <path fill="none" stroke-width="1.3"
                                                                                stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                transform="translate(3559 -70.964) rotate(-90)"
                                                                                d="M0,0C4.125,0,7.469,3.921,7.469,8.758S4.125,17.516,0,17.516">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </svg></span>
                                                            My Profile</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('orders') }}"><span><svg width="22"
                                                                    height="22" viewBox="0 0 22 22"
                                                                    class="w-em h-em fs-18 me-2"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g transform="translate(20210 -482)">
                                                                        <g transform="translate(-0.05 0.953)">
                                                                            <rect width="17.896" height="11.609"
                                                                                transform="translate(-20207.949 488.24)"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-miterlimit="10"
                                                                                stroke-width="1.3">
                                                                            </rect>
                                                                            <path
                                                                                d="M.164,3.35,2.28.158H15.969l2.08,3.193"
                                                                                transform="translate(-20208.102 484.889)"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-miterlimit="10"
                                                                                stroke-width="1.3">
                                                                            </path>
                                                                            <line x2="1.886"
                                                                                transform="translate(-20194.793 496.511)"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-miterlimit="10"
                                                                                stroke-width="1.3">
                                                                            </line>
                                                                        </g>
                                                                    </g>
                                                                </svg></span>
                                                            Orders</a>
                                                    </li>
                                                    <li>
                                                        @if (in_array(Auth::user()->role, ['user']))
                                                            <a href="{{ route('address') }}">
                                                                <span><svg width="22" height="22"
                                                                        viewBox="0 0 22 22"
                                                                        class="w-em h-em fs-18 me-2"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <g transform="translate(20197 -555)">
                                                                            <g transform="translate(0.978 -10.8)">
                                                                                <path fill="none"
                                                                                    stroke-width="1.5"
                                                                                    stroke-miterlimit="10"
                                                                                    stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    transform="translate(-20194.016 567.763)"
                                                                                    d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                                                                </path>
                                                                                <g fill="none" stroke-width="1.5"
                                                                                    stroke="currentColor"
                                                                                    transform="translate(-20190.488 571.316)">
                                                                                    <circle cx="3.574"
                                                                                        cy="3.574" r="3.574"
                                                                                        stroke="none"></circle>
                                                                                    <circle cx="3.574"
                                                                                        cy="3.574" r="2.824"
                                                                                        fill="none"></circle>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </svg></span>
                                                                Addresses</a>
                                                        @else
                                                            <a href="{{ route('addresses.index') }}">
                                                                <span><svg width="22" height="22"
                                                                        viewBox="0 0 22 22"
                                                                        class="w-em h-em fs-18 me-2"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <g transform="translate(20197 -555)">
                                                                            <g transform="translate(0.978 -10.8)">
                                                                                <path fill="none"
                                                                                    stroke-width="1.5"
                                                                                    stroke-miterlimit="10"
                                                                                    stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    transform="translate(-20194.016 567.763)"
                                                                                    d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                                                                </path>
                                                                                <g fill="none" stroke-width="1.5"
                                                                                    stroke="currentColor"
                                                                                    transform="translate(-20190.488 571.316)">
                                                                                    <circle cx="3.574"
                                                                                        cy="3.574" r="3.574"
                                                                                        stroke="none"></circle>
                                                                                    <circle cx="3.574"
                                                                                        cy="3.574" r="2.824"
                                                                                        fill="none"></circle>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </svg></span>
                                                                Addresses</a>
                                                        @endif

                                                    </li>
                                                    <li>

                                                        <a href="{{ route('resetpassword') }}">
                                                            <span><svg width="22" height="22"
                                                                    viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g transform="translate(20197 -555)">
                                                                        <g transform="translate(-20210.467 157.19)">
                                                                            <g fill="none" stroke-width="1.5"
                                                                                stroke="currentColor"
                                                                                transform="translate(16 406.233)">
                                                                                <rect rx="3" stroke="none"
                                                                                    width="15.598" height="11.438">
                                                                                </rect>
                                                                                <rect x="0.75" y="0.75" rx="2.25"
                                                                                    fill="none" width="14.098"
                                                                                    height="9.938"></rect>
                                                                            </g>
                                                                            <path fill="none" stroke-width="1.5"
                                                                                stroke="currentColor"
                                                                                stroke-miterlimit="10"
                                                                                transform="translate(19.442 400)"
                                                                                d="M.158,6.559V3.839A3.681,3.681,0,0,1,3.839.158h.754A3.681,3.681,0,0,1,8.273,3.839v2.72">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </svg></span>
                                                            Reset Password</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('logout') }}">
                                                            <span><svg width="22" height="22"
                                                                    viewBox="0 0 22 22"
                                                                    class="w-em h-em ttl-22 mb-0 me-2"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g transform="translate(20193 -761)">
                                                                        <g transform="translate(0.379)">
                                                                            <path fill="none" stroke-width="1.5"
                                                                                stroke-miterlimit="10"
                                                                                stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                transform="translate(-20190.537 763.96)"
                                                                                d="M9.925,4.026V2.782A2.623,2.623,0,0,0,7.3.158H2.781A2.623,2.623,0,0,0,.158,2.782V13.3a2.624,2.624,0,0,0,2.623,2.626H7.3A2.624,2.624,0,0,0,9.925,13.3V12.061">
                                                                            </path>
                                                                            <path fill="none" stroke-width="1.5"
                                                                                stroke="currentColor"
                                                                                stroke-miterlimit="10"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6.207,1.765,10.582,6.14,6.473,10.251"
                                                                                transform="translate(-20184.207 765.992)">
                                                                            </path>
                                                                            <line x1="10.257" fill="none"
                                                                                stroke-width="1.5"
                                                                                stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-miterlimit="10"
                                                                                transform="translate(-20183.879 772.133)">
                                                                            </line>
                                                                        </g>
                                                                    </g>
                                                                </svg></span>
                                                            Logout</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header> --}}
