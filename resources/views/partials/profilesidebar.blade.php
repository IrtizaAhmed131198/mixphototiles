@if (Auth::check())
    <figure class="text-center">
        <blockquote class="blockquote">
            <p>{{ Auth::user()->name }}</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Role <cite title="Source Title">({{ Auth::user()->role }})</cite>
        </figcaption>
    </figure>
@endif
<div class="profilesidebar">
    <ul class="sidedata">
        <li>
            <a href="{{ route('profile') }}">
                <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(-17 -131)">
                            <g transform="translate(-3539.758 221.032)">
                                <g fill="none" stroke-width="1.3" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" transform="translate(3563.094 -87.644)">
                                    <circle cx="4.605" cy="4.605" r="4.605" stroke="none">
                                    </circle>
                                    <circle cx="4.605" cy="4.605" r="3.955" fill="none">
                                    </circle>
                                </g>
                                <path fill="none" stroke-width="1.3" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" transform="translate(3559 -70.964) rotate(-90)"
                                    d="M0,0C4.125,0,7.469,3.921,7.469,8.758S4.125,17.516,0,17.516">
                                </path>
                            </g>
                        </g>
                    </svg></span>
                My Profile</a>
        </li>

        @if (in_array(Auth::user()->role, ['super_admin', 'admin']))
            <li>
                <a href="{{ route('admin.index') }}">
                    <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                            xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(-17 -131)">
                                <g transform="translate(-3539.758 221.032)">
                                    <g fill="none" stroke-width="1.3" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" transform="translate(3563.094 -87.644)">
                                        <circle cx="4.605" cy="4.605" r="4.605" stroke="none">
                                        </circle>
                                        <circle cx="4.605" cy="4.605" r="3.955" fill="none">
                                        </circle>
                                    </g>
                                    <path fill="none" stroke-width="1.3" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" transform="translate(3559 -70.964) rotate(-90)"
                                        d="M0,0C4.125,0,7.469,3.921,7.469,8.758S4.125,17.516,0,17.516">
                                    </path>
                                </g>
                            </g>
                        </svg></span>
                    {{ Auth::user()->role == 'super_admin' ? 'Admin/User' : 'User' }}</a>
            </li>
            <li>
                <a href="{{ route('settings.index') }}"
                    style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                    <span style="display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-settings">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33
                            1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06
                            a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09
                            a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0
                            1.82.33h.09a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0
                            1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21
                            a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                    </span>
                    <span>Settings</span>
                </a>

            </li>
        @endif

        @if (in_array(Auth::user()->role, ['super_admin']))
            <li>
                <a href="{{ route('contact.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="20" fill="currentColor"
                            class="w-em h-em fs-18 me-2" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        </svg>
                    </span>
                    Contact User
                </a>
            </li>
        @endif

        @if (in_array(Auth::user()->role, ['admin', 'super_admin']))
            <li>
                <a href="{{ route('frames.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="20" fill="currentColor"
                            class="w-em h-em fs-18 me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5z">
                            </path>
                        </svg></span>
                    Collections</a>
            </li>
        @endif

        <li>
            <a href="{{ route('orders') }}"><span><svg width="22" height="22" viewBox="0 0 22 22"
                        class="w-em h-em fs-18 me-2" xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(20210 -482)">
                            <g transform="translate(-0.05 0.953)">
                                <rect width="17.896" height="11.609" transform="translate(-20207.949 488.24)"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="1.3">
                                </rect>
                                <path d="M.164,3.35,2.28.158H15.969l2.08,3.193"
                                    transform="translate(-20208.102 484.889)" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    stroke-width="1.3">
                                </path>
                                <line x2="1.886" transform="translate(-20194.793 496.511)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                    stroke-width="1.3">
                                </line>
                            </g>
                        </g>
                    </svg></span>
                Orders</a>
        </li>

        @if (in_array(Auth::user()->role, ['user']))
            <li>

                <a href="{{ route('address') }}">
                    <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                            xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(20197 -555)">
                                <g transform="translate(0.978 -10.8)">
                                    <path fill="none" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        transform="translate(-20194.016 567.763)"
                                        d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                    </path>
                                    <g fill="none" stroke-width="1.5" stroke="currentColor"
                                        transform="translate(-20190.488 571.316)">
                                        <circle cx="3.574" cy="3.574" r="3.574" stroke="none">
                                        </circle>
                                        <circle cx="3.574" cy="3.574" r="2.824" fill="none">
                                        </circle>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    Addresses</a>
            </li>
        @else
            <li>

                <a href="{{ route('addresses.index') }}">
                    <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                            xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(20197 -555)">
                                <g transform="translate(0.978 -10.8)">
                                    <path fill="none" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        transform="translate(-20194.016 567.763)"
                                        d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                    </path>
                                    <g fill="none" stroke-width="1.5" stroke="currentColor"
                                        transform="translate(-20190.488 571.316)">
                                        <circle cx="3.574" cy="3.574" r="3.574" stroke="none">
                                        </circle>
                                        <circle cx="3.574" cy="3.574" r="2.824" fill="none">
                                        </circle>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    Addresses</a>
            </li>
        @endif

        <li>

            <a href="{{ route('resetpassword') }}">
                <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(20197 -555)">
                            <g transform="translate(-20210.467 157.19)">
                                <g fill="none" stroke-width="1.5" stroke="currentColor"
                                    transform="translate(16 406.233)">
                                    <rect rx="3" stroke="none" width="15.598" height="11.438"></rect>
                                    <rect x="0.75" y="0.75" rx="2.25" fill="none" width="14.098"
                                        height="9.938"></rect>
                                </g>
                                <path fill="none" stroke-width="1.5" stroke="currentColor" stroke-miterlimit="10"
                                    transform="translate(19.442 400)"
                                    d="M.158,6.559V3.839A3.681,3.681,0,0,1,3.839.158h.754A3.681,3.681,0,0,1,8.273,3.839v2.72">
                                </path>
                            </g>
                        </g>
                    </svg></span>
                Reset Password</a>
        </li>
        @if (in_array(Auth::user()->role, ['super_admin']))
            <li>
                <a href="{{ route('color.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            class="w-em h-em fs-18 me-2">
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
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </g>
                        </svg></span>
                    Custom Color</a>
            </li>
            <li>
                <a href="{{ route('size.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            class="w-em h-em fs-18 me-2">
                            <g transform="translate(1 1.414)">
                                <path d="M21,3,9,15" transform="translate(-3 -3)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                                <path d="M12,3H3V21H21V12" transform="translate(-3 -3)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                                <path d="M16,3h5V8" transform="translate(-3 -3)" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M14,15H9V10" transform="translate(-3 -3)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                            </g>
                        </svg></span>
                    Sizes</a>
            </li>
            <li>
                <a href="{{ route('finish.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            class="w-em h-em fs-18 me-2">
                            <path
                                d="M12,3,10.1,8.8a2,2,0,0,1-1.287,1.288L3,12l5.8,1.9a2,2,0,0,1,1.288,1.287L12,21l1.9-5.8a2,2,0,0,1,1.287-1.288L21,12l-5.8-1.9a2,2,0,0,1-1.288-1.287Z"
                                transform="translate(-2 -2)" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg></span>
                    Finish</a>
            </li>
            <li>
                <a href="{{ route('coupon.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <path fill="none" stroke="currentColor" stroke-width="2"
                                d="M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2a2 2 0 1 0 0 4v2a2 2 0 1 0 0 4v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 1 0 0-4v-2a2 2 0 1 0 0-4V5Z" />
                            <circle cx="12" cy="12" r="1" fill="currentColor" />
                        </svg>
                    </span>
                    Coupon
                </a>
            </li>
            <li>
                <a href="{{ route('led.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <!-- Frame -->
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"
                                fill="none" stroke="currentColor" stroke-width="2" />

                            <!-- LED Dots -->
                            <circle cx="8" cy="8" r="1" fill="currentColor" />
                            <circle cx="12" cy="8" r="1" fill="currentColor" />
                            <circle cx="16" cy="8" r="1" fill="currentColor" />

                            <circle cx="8" cy="12" r="1" fill="currentColor" />
                            <circle cx="12" cy="12" r="1" fill="currentColor" />
                            <circle cx="16" cy="12" r="1" fill="currentColor" />

                            <circle cx="8" cy="16" r="1" fill="currentColor" />
                            <circle cx="12" cy="16" r="1" fill="currentColor" />
                            <circle cx="16" cy="16" r="1" fill="currentColor" />
                        </svg>
                    </span>
                    Led
                </a>
            </li>
            <li>
                <a href="{{ route('states.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <path fill="currentColor"
                                d="M20.5 3l-5.1 2.1L9 3 3.5 5v16l6-2.1 6.5 2.1L21 19V3h-.5zm-1.5 14.7l-4.5 1.6V6.3l4.5-1.8v14.2zM4.5 6.2L8 5l4 1.6v13.6L8 18.6l-3.5 1.3V6.2z" />
                        </svg>
                    </span>
                    States
                </a>
            </li>
            <li>
                <a href="{{ route('city.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <path fill="currentColor"
                                d="M3 21V10h4v11H3Zm14 0v-6h4v6h-4ZM8 21V3h4v18H8Zm6 0v-8h4v8h-4Z" />
                        </svg>
                    </span>
                    Cities
                </a>
            </li>
        @endif
        <li>

            <a href="{{ route('logout') }}">
                <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em ttl-22 mb-0 me-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(20193 -761)">
                            <g transform="translate(0.379)">
                                <path fill="none" stroke-width="1.5" stroke-miterlimit="10" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    transform="translate(-20190.537 763.96)"
                                    d="M9.925,4.026V2.782A2.623,2.623,0,0,0,7.3.158H2.781A2.623,2.623,0,0,0,.158,2.782V13.3a2.624,2.624,0,0,0,2.623,2.626H7.3A2.624,2.624,0,0,0,9.925,13.3V12.061">
                                </path>
                                <path fill="none" stroke-width="1.5" stroke="currentColor" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.207,1.765,10.582,6.14,6.473,10.251"
                                    transform="translate(-20184.207 765.992)">
                                </path>
                                <line x1="10.257" fill="none" stroke-width="1.5" stroke="currentColor"
                                    stroke-linecap="round" stroke-miterlimit="10"
                                    transform="translate(-20183.879 772.133)">
                                </line>
                            </g>
                        </g>
                    </svg></span>
                Logout</a>
        </li>
    </ul>
</div>

<div class="profilesidebar mobile-view">
    <ul>
        <li>
            <a href="{{ route('profile') }}">
                <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(-17 -131)">
                            <g transform="translate(-3539.758 221.032)">
                                <g fill="none" stroke-width="1.3" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" transform="translate(3563.094 -87.644)">
                                    <circle cx="4.605" cy="4.605" r="4.605" stroke="none">
                                    </circle>
                                    <circle cx="4.605" cy="4.605" r="3.955" fill="none">
                                    </circle>
                                </g>
                                <path fill="none" stroke-width="1.3" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" transform="translate(3559 -70.964) rotate(-90)"
                                    d="M0,0C4.125,0,7.469,3.921,7.469,8.758S4.125,17.516,0,17.516">
                                </path>
                            </g>
                        </g>
                    </svg></span>
                My Profile</a>
        </li>

        @if (in_array(Auth::user()->role, ['super_admin', 'admin']))
            <li>
                <a href="{{ route('admin.index') }}">
                    <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                            xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(-17 -131)">
                                <g transform="translate(-3539.758 221.032)">
                                    <g fill="none" stroke-width="1.3" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        transform="translate(3563.094 -87.644)">
                                        <circle cx="4.605" cy="4.605" r="4.605" stroke="none">
                                        </circle>
                                        <circle cx="4.605" cy="4.605" r="3.955" fill="none">
                                        </circle>
                                    </g>
                                    <path fill="none" stroke-width="1.3" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        transform="translate(3559 -70.964) rotate(-90)"
                                        d="M0,0C4.125,0,7.469,3.921,7.469,8.758S4.125,17.516,0,17.516">
                                    </path>
                                </g>
                            </g>
                        </svg></span>
                    {{ Auth::user()->role == 'super_admin' ? 'Admin/User' : 'User' }}</a>
            </li>
            <li>
                <a href="{{ route('settings.index') }}"
                    style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                    <span style="display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-settings">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33
                            1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06
                            a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09
                            a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0
                            1.82.33h.09a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0
                            1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21
                            a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                    </span>
                    <span>Settings</span>
                </a>

            </li>
        @endif

        @if (in_array(Auth::user()->role, ['admin', 'super_admin']))
            <li>
                <a href="{{ route('frames.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="20" fill="currentColor"
                            class="w-em h-em fs-18 me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5z">
                            </path>
                        </svg></span>
                    Collections</a>
            </li>
        @endif

        <li>
            <a href="{{ route('orders') }}"><span><svg width="22" height="22" viewBox="0 0 22 22"
                        class="w-em h-em fs-18 me-2" xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(20210 -482)">
                            <g transform="translate(-0.05 0.953)">
                                <rect width="17.896" height="11.609" transform="translate(-20207.949 488.24)"
                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.3">
                                </rect>
                                <path d="M.164,3.35,2.28.158H15.969l2.08,3.193"
                                    transform="translate(-20208.102 484.889)" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    stroke-width="1.3">
                                </path>
                                <line x2="1.886" transform="translate(-20194.793 496.511)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                    stroke-width="1.3">
                                </line>
                            </g>
                        </g>
                    </svg></span>
                Orders</a>
        </li>

        @if (in_array(Auth::user()->role, ['user']))
            <li>

                <a href="{{ route('address') }}">
                    <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                            xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(20197 -555)">
                                <g transform="translate(0.978 -10.8)">
                                    <path fill="none" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        transform="translate(-20194.016 567.763)"
                                        d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                    </path>
                                    <g fill="none" stroke-width="1.5" stroke="currentColor"
                                        transform="translate(-20190.488 571.316)">
                                        <circle cx="3.574" cy="3.574" r="3.574" stroke="none">
                                        </circle>
                                        <circle cx="3.574" cy="3.574" r="2.824" fill="none">
                                        </circle>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    Addresses</a>
            </li>
        @else
            <li>

                <a href="{{ route('addresses.index') }}">
                    <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                            xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(20197 -555)">
                                <g transform="translate(0.978 -10.8)">
                                    <path fill="none" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        transform="translate(-20194.016 567.763)"
                                        d="M6.673,17.855l.43.392.43-.392c.27-.244,6.635-6.025,6.635-10.752A7.065,7.065,0,0,0,.038,7.1c0,4.727,6.365,10.508,6.634,10.752Z">
                                    </path>
                                    <g fill="none" stroke-width="1.5" stroke="currentColor"
                                        transform="translate(-20190.488 571.316)">
                                        <circle cx="3.574" cy="3.574" r="3.574" stroke="none">
                                        </circle>
                                        <circle cx="3.574" cy="3.574" r="2.824" fill="none">
                                        </circle>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    Addresses</a>
            </li>
        @endif

        <li>

            <a href="{{ route('resetpassword') }}">
                <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em fs-18 me-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(20197 -555)">
                            <g transform="translate(-20210.467 157.19)">
                                <g fill="none" stroke-width="1.5" stroke="currentColor"
                                    transform="translate(16 406.233)">
                                    <rect rx="3" stroke="none" width="15.598" height="11.438"></rect>
                                    <rect x="0.75" y="0.75" rx="2.25" fill="none" width="14.098"
                                        height="9.938"></rect>
                                </g>
                                <path fill="none" stroke-width="1.5" stroke="currentColor" stroke-miterlimit="10"
                                    transform="translate(19.442 400)"
                                    d="M.158,6.559V3.839A3.681,3.681,0,0,1,3.839.158h.754A3.681,3.681,0,0,1,8.273,3.839v2.72">
                                </path>
                            </g>
                        </g>
                    </svg></span>
                Reset Password</a>
        </li>
        @if (in_array(Auth::user()->role, ['super_admin']))
            <li>
                <a href="{{ route('color.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            class="w-em h-em fs-18 me-2">
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
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </g>
                        </svg></span>
                    Custom Color</a>
            </li>
            <li>
                <a href="{{ route('size.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            class="w-em h-em fs-18 me-2">
                            <g transform="translate(1 1.414)">
                                <path d="M21,3,9,15" transform="translate(-3 -3)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                                <path d="M12,3H3V21H21V12" transform="translate(-3 -3)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                                <path d="M16,3h5V8" transform="translate(-3 -3)" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M14,15H9V10" transform="translate(-3 -3)" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                            </g>
                        </svg></span>
                    Sizes</a>
            </li>
            <li>
                <a href="{{ route('finish.index') }}"><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                            class="w-em h-em fs-18 me-2">
                            <path
                                d="M12,3,10.1,8.8a2,2,0,0,1-1.287,1.288L3,12l5.8,1.9a2,2,0,0,1,1.288,1.287L12,21l1.9-5.8a2,2,0,0,1,1.287-1.288L21,12l-5.8-1.9a2,2,0,0,1-1.288-1.287Z"
                                transform="translate(-2 -2)" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg></span>
                    Finish</a>
            </li>
            <li>
                <a href="{{ route('coupon.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <path fill="none" stroke="currentColor" stroke-width="2"
                                d="M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2a2 2 0 1 0 0 4v2a2 2 0 1 0 0 4v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 1 0 0-4v-2a2 2 0 1 0 0-4V5Z" />
                            <circle cx="12" cy="12" r="1" fill="currentColor" />
                        </svg>
                    </span>
                    Coupon
                </a>
            </li>
            <li>
                <a href="{{ route('led.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <!-- Frame -->
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"
                                fill="none" stroke="currentColor" stroke-width="2" />

                            <!-- LED Dots -->
                            <circle cx="8" cy="8" r="1" fill="currentColor" />
                            <circle cx="12" cy="8" r="1" fill="currentColor" />
                            <circle cx="16" cy="8" r="1" fill="currentColor" />

                            <circle cx="8" cy="12" r="1" fill="currentColor" />
                            <circle cx="12" cy="12" r="1" fill="currentColor" />
                            <circle cx="16" cy="12" r="1" fill="currentColor" />

                            <circle cx="8" cy="16" r="1" fill="currentColor" />
                            <circle cx="12" cy="16" r="1" fill="currentColor" />
                            <circle cx="16" cy="16" r="1" fill="currentColor" />
                        </svg>
                    </span>
                    Led
                </a>
            </li>
            <li>
                <a href="{{ route('states.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <path fill="currentColor"
                                d="M20.5 3l-5.1 2.1L9 3 3.5 5v16l6-2.1 6.5 2.1L21 19V3h-.5zm-1.5 14.7l-4.5 1.6V6.3l4.5-1.8v14.2zM4.5 6.2L8 5l4 1.6v13.6L8 18.6l-3.5 1.3V6.2z" />
                        </svg>
                    </span>
                    States
                </a>
            </li>
            <li>
                <a href="{{ route('city.index') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            class="w-em h-em fs-18 me-2">
                            <path fill="currentColor"
                                d="M3 21V10h4v11H3Zm14 0v-6h4v6h-4ZM8 21V3h4v18H8Zm6 0v-8h4v8h-4Z" />
                        </svg>
                    </span>
                    Cities
                </a>
            </li>
        @endif
        <li>

            <a href="{{ route('logout') }}">
                <span><svg width="22" height="22" viewBox="0 0 22 22" class="w-em h-em ttl-22 mb-0 me-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(20193 -761)">
                            <g transform="translate(0.379)">
                                <path fill="none" stroke-width="1.5" stroke-miterlimit="10" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    transform="translate(-20190.537 763.96)"
                                    d="M9.925,4.026V2.782A2.623,2.623,0,0,0,7.3.158H2.781A2.623,2.623,0,0,0,.158,2.782V13.3a2.624,2.624,0,0,0,2.623,2.626H7.3A2.624,2.624,0,0,0,9.925,13.3V12.061">
                                </path>
                                <path fill="none" stroke-width="1.5" stroke="currentColor" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.207,1.765,10.582,6.14,6.473,10.251"
                                    transform="translate(-20184.207 765.992)">
                                </path>
                                <line x1="10.257" fill="none" stroke-width="1.5" stroke="currentColor"
                                    stroke-linecap="round" stroke-miterlimit="10"
                                    transform="translate(-20183.879 772.133)">
                                </line>
                            </g>
                        </g>
                    </svg></span>
                Logout</a>
        </li>
    </ul>
</div>
