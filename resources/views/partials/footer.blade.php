<footer class="text-white Footer_footer">
    <div class="Footer_footerLinksWrp">
        <div class="container">
            <div class="row">
                <div class="col-md">
                    {{-- @php
                        $img = get_setting('site_logo');
                    @endphp
                    @if ($img) --}}
                        {{-- <img src="{{ asset('storage/' . $img) }}" class="img-fluid footer-logo" alt="Logo"> --}}
                    {{-- @else --}}
                        <img src="{{ asset('assets/images/logo_footer.png') }}" class="img-fluid footer-logo" alt="Logo">
                    {{-- @endif --}}
                    <div class="Footer_socialNav nav" style=" align-items: end; ">
                        <div class="nav-item">
                            <a title="javascript:;" rel="noopener noreferrer" target="_blank" class="nav-link"
                                href="{{ get_setting('facebook') ?? 'javascript:;' }}">
                                <svg width="11.01" height="22.019" class="w-em h-em d-block" viewBox="0 0 11.01 22.019"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor"
                                        d="M10.408,3.894A7.126,7.126,0,0,0,8.483,3.6c-.782,0-2.467.5-2.467,1.464V7.379h4v3.894h-4V22.019H1.985V11.273H0V7.379H1.985V5.417C1.985,2.46,3.369,0,6.708,0a16.4,16.4,0,0,1,4.3.439Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a title="javascript:;" rel="noopener noreferrer" target="_blank" class="nav-link"
                                href="{{ get_setting('instagram') ?? 'javascript:;' }}">
                                <svg width="22.019" height="22.019" class="w-em h-em d-block"
                                    viewBox="0 0 22.019 22.019" xmlns="http://www.w3.org/2000/svg">
                                    <g transform="translate(3827 6277.01)">
                                        <path fill="currentColor" transform="translate(-3821.484 -6271.497)"
                                            d="M5.7,11.391A5.7,5.7,0,1,1,11.389,5.7,5.7,5.7,0,0,1,5.7,11.391Zm0-9.175A3.481,3.481,0,1,0,9.173,5.7,3.485,3.485,0,0,0,5.7,2.215Z">
                                        </path>
                                        <path fill="currentColor" transform="translate(-3827 -6277.01)"
                                            d="M15.459,22.019h-8.9A6.567,6.567,0,0,1,0,15.459v-8.9A6.567,6.567,0,0,1,6.559,0h8.9a6.567,6.567,0,0,1,6.559,6.559v8.9A6.567,6.567,0,0,1,15.459,22.019Zm-8.9-19.8A4.349,4.349,0,0,0,2.215,6.559v8.9A4.349,4.349,0,0,0,6.559,19.8h8.9A4.349,4.349,0,0,0,19.8,15.459v-8.9a4.349,4.349,0,0,0-4.344-4.344ZM16.715,6.722A1.365,1.365,0,1,1,18.08,5.357,1.366,1.366,0,0,1,16.715,6.722Z">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        {{-- <div class="nav-item">
                            <a title="javascript:;" rel="noopener noreferrer" target="_blank" class="nav-link"
                                href="{{ get_setting('twitter') ?? 'javascript:;' }}">
                                <svg width="22.019" height="22.019" class="w-em h-em d-block"
                                    viewBox="0 0 22.019 22.019" xmlns="http://www.w3.org/2000/svg">
                                    <g transform="scale(1.2)">
                                        <path id="X_logo_2023_original"
                                            d="M9.464,6.739,15.383,0h-1.4L8.839,5.85,4.735,0H0L6.208,8.847,0,15.912H1.4L6.829,9.733l4.335,6.179H15.9M1.908,1.036H4.063L13.98,14.928H11.825"
                                            transform="matrix(1, 0.017, -0.017, 1, 0.278, 0)" fill="currentColor">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md">
                    <h5 class="mb-4 text-brand-dark fw-bold">Quick Links</h5>
                    <div class="flex-column Footer_footerLinks nav nav-underline">
                        <div><a href="{{ route('home') }}" class="active link" style=" text-decoration: none; ">Home</a>
                        </div>
                        <div><a href="{{ route('design') }}" class="link" style=" text-decoration: none; ">Design</a>
                        </div>
                        <div><a href="{{ route('collections') }}" class="link" style=" text-decoration: none; ">Your
                                Collections</a></div>
                        {{-- <div><a href="#" class="link" style=" text-decoration: none; ">Installation &amp;
                                Care</a></div> --}}
                    </div>
                </div>
                <div class="col-md">
                    <h5 class="mb-4 text-brand-dark fw-bold">Help</h5>
                    <div class="flex-column Footer_footerLinks nav nav-underline">
                        <div><a href="{{ route('contact') }}" class="link" style=" text-decoration: none; "><span
                                    class=" link">Contact Us </span></div></a>
                    </div>
                </div>
                {{-- <div class="col-md">
                    <h5 class="mb-4 text-brand-dark fw-bold">Not sure how to do?</h5>
                    <p class="mb-2 Footer_footerContact">Call:<a class="text-decoration-none ps-1" href="javascript:;">+917975339182</a></p>
                    <p class="mb-2 Footer_footerContact"><a class="text-decoration-none ps-1" href="mailto:{{ get_setting('contact_email', 'help@magentickphotoframes.com') }}">
                        {{ get_setting('contact_email', 'help@magentickphotoframes.com') }}</a></p>
                </div> --}}
                <div class="col-md">
                    <h5 class="mb-4 text-brand-dark fw-bold">Not sure how to do?</h5>
                    <p class="mb-2 Footer_footerContact">
                        <a class="text-decoration-none d-flex align-items-center" href="https://wa.me/919342874392"
                            target="_blank">
                            <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp" class="whatsapp-icon"
                                style="width: 50px;height: 51px;vertical-align: middle;margin-left: -5px;">
                            <span class="ps-1" style=" font-size: 14px; font-weight: 400; line-height: 20px; ">Send
                                your picture to our way and we'll frame it.</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-white text-opacity-35  fs-15 Footer_footerBottomWrp">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center align-items-center flex-column flex-xl-row gap-3 down-footer">
                <div class="Footer_footerBottomNav nav">
                    <div class="nav-item"><a class="nav-link " href="{{ route('privacy') }}">Privacy Policy</a></div>
                    <div class="nav-item"><a class="nav-link " href="{{ route('refund') }}">Refund Policy</a></div>
                    <div class="nav-item"><a class="nav-link " href="{{ route('terms') }}">Terms &amp; Conditions</a>
                    </div>
                    <div class="nav-item"><a class="nav-link " href="{{ route('shipping') }}">Shipping Policy</a>
                    </div>
                </div>
                <div
                    class="d-flex mx-auto me-xl-0 align-items-center flex-wrap text-center justify-content-center flex-column flex-sm-row gap-2">
                    <p class="mb-0">© <!-- -->{{ date('Y') }}<!-- --> {{ get_setting('site_name') }}, Inc. All
                        rights reserved</p><span class="d-none d-sm-block"></span>
                    <!-- <p class="mb-0">Designed by<a target="_blank" class="text-decoration-none ps-1" href="javascript:;">Webandcrafts</a></p> -->
                </div>
            </div>
        </div>
    </div>
</footer>

@if(!in_array(Route::currentRouteName(), ['design', 'cart', 'order_summary']))
    <div class="shopbtnmobile">
        <div class="shopvideobtn">
            <a href="{{ route('design') }}" class="btn custom-btn filled">Order Yours</a>
        </div>
    </div>
@endif
<!-- custom modal html  -->
<div class="custom-modal">


    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="Login_authWrp">
                        <h4 class="heading-6">Login</h4>
                        <p class="text-center">Select method to login</p>
                        <div class="btnParentlogin">
                            @php
                                $currentRoute = Route::currentRouteName();
                                $allowedRoutes = ['cart', 'order_summary'];
                            @endphp
                            <button class="btn google-btn">
                                @if (session()->has('google_user'))
                                    <a href="{{ route('google.login', ['redirect_to' => in_array($currentRoute, $allowedRoutes) ? $currentRoute : null]) }}" class="btn google-btn">
                                        <span class="googleimg">
                                            <img src="{{ session('google_user')->avatar }}" alt="Google Avatar"
                                                style="width: 24px; height: 24px; border-radius: 50%;">
                                        </span>
                                        <span class="btntext">Signed in as {{ session('google_user')->name }}</span>
                                    </a>
                                @else
                                    <a href="{{ route('google.login', ['redirect_to' => in_array($currentRoute, $allowedRoutes) ? $currentRoute : null]) }}" class="btn google-btn">
                                        <span class="googleimg">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 48 48" class="LgbsSe-Bz112c">
                                                <g>
                                                    <path fill="#EA4335"
                                                        d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                                    </path>
                                                    <path fill="#4285F4"
                                                        d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                                    </path>
                                                    <path fill="#FBBC05"
                                                        d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                                    </path>
                                                    <path fill="#34A853"
                                                        d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                                    </path>
                                                    <path fill="none" d="M0 0h48v48H0z"></path>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="btntext">Sign in with Google</span>
                                    </a>
                                @endif
                            </button>
                        </div>
                        <div class="position-relative text-center mb-4 Login_separator"><span
                                class="bg-white px-2 position-relative">or</span></div>
                        <form class="loginForm">
                            <div class="mb-4 form-floating">
                                <input placeholder="Email address" id="emailInput" class="form-control"
                                    type="email" value="" name="emailOrMobile">
                                <label for="emailInput">Email address</label>
                                <small class="text-danger" id="emailOrMobileError"></small>
                            </div>
                            <div class="position-relative PasswordInput_passwordWrp mb-3 form-floating">
                                <input placeholder="Password" id="PasswordInput2" class="form-control"
                                    type="password" value="" name="password">
                                <button type="button"
                                    class="position-absolute top-0 end-0 rounded-pill PasswordInput_showButton btn btn-text toggle-password">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <label for="PasswordInput2">Password</label>
                                <small class="text-danger" id="passwordError"></small>
                            </div>
                            <div class="d-flex Login_forgotBtn">
                                <button type="button" class="ms-auto btn btn-text btn-sm"
                                    data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Forgot
                                    password</button>
                            </div>
                            <div class="d-grid pt-3 pb-4">
                                <button type="button" class="btn custom-btn" onclick="submitLogin()">Login</button>
                            </div>
                        </form>
                        <div id="loginMessage"></div>
                        <p class="mb-0 text-center d-flex align-items-center justify-content-center">Don't
                            have an account?<button data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"
                                class="Login_authSwitch">Signup</button>
                        </p>
                        <p class="mb-0 text-center">
                            <button data-bs-target="#exampleModalToggleVerify" data-bs-toggle="modal"
                                class="Login_authSwitch btn-otp-login">Verify Email OTP</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="Login_authWrp">
                            <h4 class="heading-6">Sign Up</h4>
                            <p class="text-center">Select method to signup</p>
                            <div class="btnParentlogin">
                                <button class="btn google-btn">
                                    <a href="{{ route('google.login') }}" class="btn google-btn">
                                        <span class="googleimg">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 48 48" class="LgbsSe-Bz112c">
                                                <g>
                                                    <path fill="#EA4335"
                                                        d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                                    </path>
                                                    <path fill="#4285F4"
                                                        d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                                    </path>
                                                    <path fill="#FBBC05"
                                                        d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                                    </path>
                                                    <path fill="#34A853"
                                                        d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                                    </path>
                                                    <path fill="none" d="M0 0h48v48H0z"></path>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="btntext">Sign up with Google</span>
                                    </a>
                                </button>
                            </div>
                            <div class="position-relative text-center mb-4 Login_separator"><span
                                    class="bg-white px-2 position-relative">or</span></div>
                            <form id="signupForm">
                                @csrf
                                <div class="mb-4 form-floating">
                                    <input placeholder="Name" id="nameInput3" class="form-control" type="text"
                                        name="name">
                                    <label for="nameInput3">Name </label>
                                </div>
                                <div class="mb-4 form-floating">
                                    <input placeholder="Email" id="emailInput3" class="form-control" type="text"
                                        name="email">
                                    <label for="emailInput3">Email </label>
                                </div>
                                <div class="mb-4 form-floating">
                                    <input placeholder="Mobile number" id="phone" class="form-control"
                                        type="text" name="phone">
                                    <label for="phone">Mobile number</label>
                                </div>
                                <div class="position-relative PasswordInput_passwordWrp mb-3 form-floating">
                                    <input placeholder="Password" id="PasswordInput"
                                        class="form-control password-field" type="password" name="password">
                                    <button type="button"
                                        class="position-absolute top-0 end-0 rounded-pill PasswordInput_showButton btn btn-text toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <label for="PasswordInput">Password</label>
                                </div>

                                <div class="position-relative PasswordInput_passwordWrp mb-3 form-floating">
                                    <input placeholder="Confirm Password" id="ConfirmPasswordInput"
                                        class="form-control password-field" type="password"
                                        name="password_confirmation">
                                    <button type="button"
                                        class="position-absolute top-0 end-0 rounded-pill PasswordInput_showButton btn btn-text toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <label for="ConfirmPasswordInput">Confirm Password</label>
                                </div>
                                <div class="d-flex Login_forgotBtn"><button type="button"
                                        class="ms-auto btn btn-text btn-sm">Forgot password</button></div>
                                <div class="d-grid pt-3 pb-4">
                                    <button type="submit" class="btn custom-btn">Sign Up</button>
                                </div>
                            </form>
                            <p class="mb-0 text-center d-flex align-items-center justify-content-center">Already have
                                an account?
                                <button data-bs-target="#exampleModalToggle" data-bs-toggle="modal" id="signupBtn"
                                    class="Login_authSwitch">Login</button>
                            </p>
                            <p class="mb-0 text-center">
                                <button data-bs-target="#exampleModalToggleVerify" data-bs-toggle="modal"
                                    class="Login_authSwitch btn-otp-login">Verify Email OTP</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggleVerify" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabelVerify" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="Login_authWrp">
                        <h4 class="heading-6">Verify Email</h4>
                        <p>Enter your email to receive an OTP.</p>
                        <form>
                            <div class="mb-4 form-floating">
                                <input placeholder="Email" id="emailInputVerify" class="form-control" type="text"
                                    name="email">
                                <label for="emailInputVerify">Email</label>
                                <small class="text-danger" id="emailErrorVerify"></small>
                            </div>
                            <div class="d-grid pt-3 pb-4">
                                <button type="button" class="btn custom-btn btn-otp-verify"
                                    onclick="sendOtpEmail()">Send OTP</button>
                            </div>
                            <div id="forgotPasswordMessageVerify"></div>
                        </form>

                        <p class="mb-0 text-center">Back To Login
                            <button data-bs-target="#exampleModalToggle" data-bs-toggle="modal"
                                class="Login_authSwitch btn-otp-login">Login</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="Login_authWrp">
                        <h4 class="heading-6">Forgot Password?</h4>
                        <p>Enter your email to receive an OTP.</p>
                        <form>
                            <div class="mb-4 form-floating">
                                <input placeholder="Email" id="emailInputPass" class="form-control" type="text"
                                    name="email">
                                <label for="emailInputPass">Email</label>
                                <small class="text-danger" id="emailError"></small>
                            </div>
                            <div class="d-grid pt-3 pb-4">
                                <button type="button" class="btn custom-btn btn-otp" onclick="sendOtp()">Send
                                    OTP</button>
                            </div>
                            <div id="forgotPasswordMessage"></div>
                        </form>

                        <p class="mb-0 text-center">Back To Login
                            <button data-bs-target="#exampleModalToggle" data-bs-toggle="modal"
                                class="Login_authSwitch btn-otp-login">Login</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggleOtp" aria-hidden="true"
        aria-labelledby="exampleModalToggleOtpLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="Login_authWrp">
                        <h4 class="heading-6">Verify OTP</h4>
                        <p>Enter the OTP sent to your email.</p>
                        <form id="otpForm">
                            <div class="mb-4 form-floating">
                                <input placeholder="OTP" id="otpInputEdit" class="form-control" type="text"
                                    name="otp">
                                <label for="otpInputEdit">OTP</label>
                                <small class="text-danger" id="otpError"></small>
                            </div>
                            <div class="d-grid pt-3 pb-4">
                                <button type="button" class="btn custom-btn btn-verify" onclick="verifyOtp()">Verify
                                    OTP</button>
                            </div>
                            <div id="otpMessage"></div>
                        </form>
                        <p class="mb-0 text-center">Resend OTP
                            <button type="button" class="Login_authSwitch btn-verify-resend"
                                onclick="resendOtp()">Resend</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggleOtpSign" aria-hidden="true"
        aria-labelledby="exampleModalToggleOtpSignLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="Login_authWrp">
                        <h4 class="heading-6">Verify OTP</h4>
                        <p>Enter the OTP sent to your email.</p>
                        <form id="otpFormSign">
                            <div class="mb-4 form-floating">
                                <input placeholder="OTP" id="otpInputEditSign" class="form-control" type="text"
                                    name="otp">
                                <label for="otpInputEditSign">OTP</label>
                                <small class="text-danger" id="otpErrorSign"></small>
                            </div>
                            <div class="d-grid pt-3 pb-4">
                                <button type="button" class="btn custom-btn btn-verify-sign"
                                    onclick="verifyOtpSign()">Verify OTP</button>
                            </div>
                            <div id="otpMessageSign"></div>
                        </form>
                        <p class="mb-0 text-center">Resend OTP
                            <button type="button" class="Login_authSwitch btn-verify-resend-sign"
                                onclick="resendOtpVerify()">Resend</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggleReset" aria-hidden="true"
        aria-labelledby="exampleModalToggleResetLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="Login_authWrp">
                        <h4 class="heading-6">Reset Password</h4>
                        <form id="resetPasswordForm">
                            <input type="hidden" name="email" id="get_email">
                            <div class="mb-4 form-floating">
                                <input placeholder="New Password" id="newPassword" class="form-control"
                                    type="password" name="password">
                                <button type="button"
                                    class="position-absolute top-0 end-0 rounded-pill PasswordInput_showButton btn btn-text toggle-password">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <label for="newPassword">New Password</label>
                            </div>
                            <div class="mb-4 form-floating">
                                <input placeholder="Confirm Password" id="confirmPassword" class="form-control"
                                    type="password" name="password_confirmation">
                                <button type="button"
                                    class="position-absolute top-0 end-0 rounded-pill PasswordInput_showButton btn btn-text toggle-password">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <label for="confirmPassword">Confirm Password</label>
                            </div>
                            <div class="d-grid pt-3 pb-4">
                                <button type="button" class="btn custom-btn btn-reset"
                                    onclick="resetPassword()">Reset Password</button>
                            </div>
                            <div id="resetPasswordMessage"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- custom modal html  -->
