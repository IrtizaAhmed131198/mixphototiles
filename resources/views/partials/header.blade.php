<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <!-- <a class="navbar-brand main-logo" href="javascript:;"> -->
                            <img src="{{ asset('assets/images/logo.png') }}" alt="" style=" height: 131px; ">
                            <!-- MixPhotoTiles -->
                        <!-- </a> -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('design') ? 'active' : '' }}" href="{{ route('design') }}">Design Your Frame</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('collections') ? 'active' : '' }}" href="{{ route('collections') }}">Your Collections</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">Installation & Care</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">FAQs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:;">Contact Us</a>
                                </li>
                            </ul>
                            <span class="break-line"></span>
                            <div class="right-navbar">
                                <ul>
                                    <li>
                                        <a href="javascript:;" class="nav-link">
                                            <span>
                                                <img src="{{ asset('assets/images/bag.svg') }}" alt="">
                                            </span>
                                            <span>
                                                Cart
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" class="btn custom-btn">Login / Sign up</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
