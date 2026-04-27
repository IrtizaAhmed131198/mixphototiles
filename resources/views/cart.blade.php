@extends('components.layouts.app')

@section('noindex', true)

@section('title', 'Cart')

@push('css')
    <style>
        /* @keyframes circle {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);

            }
        } */
        .parentCart h4 .btn {
            margin-left: 27px;
        }
    </style>
@endpush

@section('content')
    @php
        $subtotal = 0;
        $shipping = get_setting('shipping_price') ?? 0;
    @endphp

    {{-- <div class="loadermain">
        <div class="loader-container">
            <div class="loaderMain">
                <img src="{{ asset('assets/images/loader.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div> --}}

    @if (!empty($cartItems))

        <section class="cartSection">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="parentCart">
                            <h4 class="">
                                Your Cart
                                <span class="itemsCount">({{ count($cartItems) ?? 0 }} Items)</span>
                                <form action="{{ route('cart.clear') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn design-btn filled">
                                        Remove All
                                    </button>
                                </form>
                            </h4>
                        </div>

                        <div class="cardList">

                            @foreach ($cartItems as $item)
                                @php
                                    $product = App\Models\Product::find($item['product_id']);
                                    $subtotal += (float) $item['price'];
                                @endphp
                                <div class="listGroup">
                                    <figure class="carditemimage">
                                        <img src="{{ asset($item['image']) }}" class="img-fluid" alt="{{ $item['name'] }}">
                                    </figure>
                                    <div class="cardlistdetail">
                                        <p class="heading-6">
                                            {{ $item['name'] }}
                                        </p>
                                        <div class="cardlistaction">
                                            <button type="button" class="CartListItem_action remove-item"
                                                data-product-id="{{ $item['product_id'] }}" data-type="{{ $item['type'] }}">
                                                <svg width="15.9" height="17.5" class="w-em h-em pe-1 fs-16"
                                                    viewBox="0 0 15.9 17.5" xmlns="http://www.w3.org/2000/svg">
                                                    <g transform="translate(-2.25 -1.25)">
                                                        <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none"
                                                            stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5"></path>
                                                        <path
                                                            d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6"
                                                            transform="translate(-0.4 -0.8)" fill="none"
                                                            stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5"></path>
                                                        <path
                                                            d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2"
                                                            transform="translate(-1)" fill="none" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"></path>
                                                        <line y2="5" transform="translate(8.2 9)" fill="none"
                                                            stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5"></line>
                                                        <line y2="5" transform="translate(12.2 9)" fill="none"
                                                            stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5"></line>
                                                    </g>
                                                </svg>
                                                Remove
                                            </button>
                                            <button type="button" class="CartListItem_action edit-item"
                                                data-product-id="{{ $item['product_id'] }}"
                                                data-image-name="{{ $item['image'] }}" data-type="{{ $item['type'] }}"
                                                data-slug="{{ $item['slug'] }}" data-temp-slug="{{ $product['slug'] }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15.615" height="14.926"
                                                    viewBox="0 0 15.615 14.926" class="w-em h-em pe-1 fs-16">
                                                    <g transform="translate(-2.25 -2.129)">
                                                        <path d="M12,20h7.058" transform="translate(-1.942 -3.695)"
                                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5"></path>
                                                        <path
                                                            d="M13.586,3.366a1.663,1.663,0,1,1,2.353,2.353l-9.8,9.8L3,16.3l.784-3.137Z"
                                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.5"></path>
                                                    </g>
                                                </svg>
                                                Edit Items
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cartPrice">
                                        <h5>₹{{ round($item['price'], 0) }}</h5>
                                    </div>
                                </div>
                            @endforeach


                            {{-- <div class="pt-4 form-check giftcheck">
                        <input id="send-gift-checkbox" class="form-check-input" type="checkbox" {{ session('gift_card_applied') ? 'checked' : '' }}>
                        <label for="send-gift-checkbox" class="form-check-label">Send this as a gift
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.053" height="17.5" viewBox="0 0 19.053 17.5" class="w-em h-em ps-1 fs-20">
                                <g transform="translate(0 -1029.356)">
                                    <path d="M1,1037.4v9.526a1.59,1.59,0,0,0,1.588,1.588H16.877a1.59,1.59,0,0,0,1.588-1.588V1037.4Z" transform="translate(-0.206 -1.658)" fill="#f39c12"></path>
                                    <path d="M1,1036.4v9.526a1.59,1.59,0,0,0,1.588,1.588H16.877a1.59,1.59,0,0,0,1.588-1.588V1036.4Z" transform="translate(-0.206 -1.452)" fill="#f1c40f"></path>
                                    <path d="M1.588,1034.4A1.59,1.59,0,0,0,0,1035.988v1.588H19.053v-1.588a1.59,1.59,0,0,0-1.588-1.588H1.588Z" transform="translate(0 -1.04)" fill="#f1c40f"></path>
                                    <rect width="4.763" height="14.289" transform="translate(7.145 1032.566)" fill="#e74c3c"></rect>
                                    <path d="M7.29,1029.391a2.171,2.171,0,0,0-1.991.952,1.858,1.858,0,0,0,.821,2.7,1.84,1.84,0,0,0,1.083.318h6.706a1.866,1.866,0,0,0,1.092-.318,1.854,1.854,0,0,0,.812-2.7,2.372,2.372,0,0,0-3.048-.714,1.778,1.778,0,0,0-.8.714h-.017c-.025.079-.048.079-.07.159l-1.319,1.985L9.238,1030.5c-.022-.079-.044-.079-.07-.159H9.15a1.76,1.76,0,0,0-.795-.714,2.5,2.5,0,0,0-1.065-.239Zm-.131.952a1.8,1.8,0,0,1,.637.159c.067,0,.128.079.183.079.039.079.072.079.1.159h.026c.018,0,.037.079.052.079H8.2c.013.079.033.079.044.079l.926,1.429H7.037a.144.144,0,0,1-.148-.08.235.235,0,0,1-.21-.079c-.134,0-.253-.159-.341-.238a.923.923,0,0,1-.07-1.111,1.234,1.234,0,0,1,.891-.476Zm6.8,0a1.235,1.235,0,0,1,.891.476.923.923,0,0,1-.079,1.112c-.087.079-.2.238-.332.238a.234.234,0,0,1-.21.079.155.155,0,0,1-.157.079h-2.13l.925-1.429c.011,0,.031,0,.044-.079h.035c.016,0,.035-.079.052-.079h.026c.033-.079.075-.079.114-.159.056,0,.117-.08.183-.08a1.812,1.812,0,0,1,.637-.158Z" transform="translate(-1.031)" fill="#c0392b"></path>
                                    <rect width="17.465" height="0.794" transform="translate(0.794 1036.536)" fill="#f39c12"></rect>
                                    <rect width="4.763" height="0.794" transform="translate(7.145 1036.536)" fill="#c0392b"></rect>
                                    <rect width="4.763" height="0.794" transform="translate(7.145 1046.062)" fill="#c0392b"></rect>
                                </g>
                            </svg>
                        </label>
                    </div> --}}

                            <div class="listGroup giftitemparent gift-amount-wrapper" style="display: none">
                                <figure class="carditemimage">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19.053" height="17.5"
                                        viewBox="0 0 19.053 17.5" class="w-em h-em ps-1 ttl-36 m-0">
                                        <g transform="translate(0 -1029.356)">
                                            <path
                                                d="M1,1037.4v9.526a1.59,1.59,0,0,0,1.588,1.588H16.877a1.59,1.59,0,0,0,1.588-1.588V1037.4Z"
                                                transform="translate(-0.206 -1.658)" fill="#f39c12"></path>
                                            <path
                                                d="M1,1036.4v9.526a1.59,1.59,0,0,0,1.588,1.588H16.877a1.59,1.59,0,0,0,1.588-1.588V1036.4Z"
                                                transform="translate(-0.206 -1.452)" fill="#f1c40f"></path>
                                            <path
                                                d="M1.588,1034.4A1.59,1.59,0,0,0,0,1035.988v1.588H19.053v-1.588a1.59,1.59,0,0,0-1.588-1.588H1.588Z"
                                                transform="translate(0 -1.04)" fill="#f1c40f"></path>
                                            <rect width="4.763" height="14.289" transform="translate(7.145 1032.566)"
                                                fill="#e74c3c"></rect>
                                            <path
                                                d="M7.29,1029.391a2.171,2.171,0,0,0-1.991.952,1.858,1.858,0,0,0,.821,2.7,1.84,1.84,0,0,0,1.083.318h6.706a1.866,1.866,0,0,0,1.092-.318,1.854,1.854,0,0,0,.812-2.7,2.372,2.372,0,0,0-3.048-.714,1.778,1.778,0,0,0-.8.714h-.017c-.025.079-.048.079-.07.159l-1.319,1.985L9.238,1030.5c-.022-.079-.044-.079-.07-.159H9.15a1.76,1.76,0,0,0-.795-.714,2.5,2.5,0,0,0-1.065-.239Zm-.131.952a1.8,1.8,0,0,1,.637.159c.067,0,.128.079.183.079.039.079.072.079.1.159h.026c.018,0,.037.079.052.079H8.2c.013.079.033.079.044.079l.926,1.429H7.037a.144.144,0,0,1-.148-.08.235.235,0,0,1-.21-.079c-.134,0-.253-.159-.341-.238a.923.923,0,0,1-.07-1.111,1.234,1.234,0,0,1,.891-.476Zm6.8,0a1.235,1.235,0,0,1,.891.476.923.923,0,0,1-.079,1.112c-.087.079-.2.238-.332.238a.234.234,0,0,1-.21.079.155.155,0,0,1-.157.079h-2.13l.925-1.429c.011,0,.031,0,.044-.079h.035c.016,0,.035-.079.052-.079h.026c.033-.079.075-.079.114-.159.056,0,.117-.08.183-.08a1.812,1.812,0,0,1,.637-.158Z"
                                                transform="translate(-1.031)" fill="#c0392b"></path>
                                            <rect width="17.465" height="0.794" transform="translate(0.794 1036.536)"
                                                fill="#f39c12"></rect>
                                            <rect width="4.763" height="0.794" transform="translate(7.145 1036.536)"
                                                fill="#c0392b"></rect>
                                            <rect width="4.763" height="0.794" transform="translate(7.145 1046.062)"
                                                fill="#c0392b"></rect>
                                        </g>
                                    </svg>
                                </figure>
                                <div class="cardlistdetail">
                                    <p class="heading-6">
                                        Gift Wrap
                                    </p>
                                    <div class="cardlistaction">
                                        <button type="button" class="CartListItem_action">
                                            <svg width="15.9" height="17.5" class="w-em h-em pe-1 fs-16"
                                                viewBox="0 0 15.9 17.5" xmlns="http://www.w3.org/2000/svg">
                                                <g transform="translate(-2.25 -1.25)">
                                                    <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <path
                                                        d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6"
                                                        transform="translate(-0.4 -0.8)" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <path
                                                        d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2"
                                                        transform="translate(-1)" fill="none" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"></path>
                                                    <line y2="5" transform="translate(8.2 9)" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"></line>
                                                    <line y2="5" transform="translate(12.2 9)" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"></line>
                                                </g>
                                            </svg>
                                            Remove
                                        </button>
                                        <button type="button" class="CartListItem_action"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="15.615" height="14.926"
                                                viewBox="0 0 15.615 14.926" class="w-em h-em pe-1 fs-16">
                                                <g transform="translate(-2.25 -2.129)">
                                                    <path d="M12,20h7.058" transform="translate(-1.942 -3.695)"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <path
                                                        d="M13.586,3.366a1.663,1.663,0,1,1,2.353,2.353l-9.8,9.8L3,16.3l.784-3.137Z"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.5"></path>
                                                </g>
                                            </svg>Edit Items
                                        </button>
                                    </div>

                                </div>
                                <div class="cartPrice">
                                    <h5>₹{{ round($gift, 0) }}</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="parentRightcart">

                            <div class="paymentdetailsbody">
                                <div class="cartheader">
                                    <div id="couponContainer">
                                        <div class="ApplyCoupon_couponApply">
                                            <p>
                                                <span>
                                                    <img src="{{ asset('assets/images/tags.svg') }}" class="img-fluid"
                                                        alt="">
                                                </span> Apply Coupon
                                            </p>
                                            <a href="javascript:;" data-bs-target="#applycoupon" data-bs-toggle="modal"
                                                class="btn design-btn filled" id="applyCouponButton">Apply</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="parentcardlistdetail">
                                    <div class="cartParent">
                                        <h5 class="pricedetails">
                                            Price Details
                                        </h5>
                                        <ul class="cartListpaymentdetails">
                                            <li>
                                                <p class="customTilename">Sub Total</p>
                                                <span id="subtotal" data-val="{{ round($subtotal) }}">
                                                    ₹{{ round($subtotal) }}
                                                </span>
                                            </li>

                                            <li>
                                                <p class="customTilename">Discount</p>
                                                <span class="discounttag">
                                                    ₹{{ round($discount) }}
                                                </span>
                                            </li>

                                            <li style="display: none" id="gift-price">
                                                <p class="customTilename">Gift</p>
                                                <span id="gift" data-val="{{ round($gift) }}">
                                                    ₹{{ round($gift) }}
                                                </span>
                                            </li>

                                            <li>
                                                <p class="customTilename">Shipping</p>
                                                <span id="shipping" data-val="{{ round($shipping_price) }}">
                                                    @if($shipping_price == 0)
                                                        Free
                                                    @else
                                                        ₹{{ round($shipping_price) }}
                                                    @endif
                                                </span>
                                            </li>

                                            <li class="grandTotal">
                                                <p class="customTilename">Grand Total</p>
                                                @php
                                                    $grandTotal = (int) round((float)$subtotal + (float)$discount + (float)$shipping_price);
                                                @endphp
                                                <span id="grand_total" data-val="{{ $grandTotal }}">
                                                    ₹{{ $grandTotal }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                    <button type="button" class="btn design-btn filled"
                                        onclick="updateCartAndRedirect()">
                                        Continue
                                    </button>

                                </div>
                            </div>

                            <div class="noticeproductdetail">
                                <p>
                                    Our Magentick Photo Frames are custom-made to order. Once your order is placed, please
                                    allow 2–3 business days for production. After that, your frames will be shipped.
                                    Delivery times may vary depending on holidays, weather conditions, or courier delays. As
                                    this is a customized product, we kindly ask you to anticipate potential delays. For more
                                    accurate delivery estimates, please refer to our Shipping Policy
                                </p>
                            </div>
                            <div class="productpolicylinks">
                                <a class="" href="{{ route('shipping') }}">Shipping Policy</a>
                                {{-- <a class="" href="{{ route('faq') }}">FAQ's</a> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="parent-empty-cart">
            <div class="Cart_cartNoData">
                <div class="row">
                    <div class="col-12 justify-content-center text-center">
                        <h2 class="heading-5">Cart is empty!</h2>
                        <p class="para">Please add some products</p><br>
                    </div>
                    <div class="col-12 text-center ">
                        <button type="button" onclick="window.location.href='{{ route('design') }}';"
                            class="btn design-btn filled">Continue</button>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <div class="custom-modal">


        <div class="modal fade" id="applycoupon" aria-hidden="true" aria-labelledby="applycouponLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="Login_authWrp">
                            <div class="pb-4">
                                <h4 class="ttl-20 fw-semibold mb-sm-3 mb-2">Apply Benefits</h4>
                                <h6 class="fs-16 fw-semibold mb-2 pb-1">Add Coupon Code</h6>
                                <div class="d-flex pb-2 mb-1">
                                    <input placeholder="Enter coupon code" class="ApplyCoupon_couponInput form-control"
                                        value="" id="manualCoupon">
                                    <button type="button" class="btn-apply-coupon" id="btnManualApply">Apply</button>
                                    <span id="manualCouponError"
                                        style="color: red; display: none; margin-top: 5px; font-size: 13px;">Invalid Coupon
                                        Code</span>
                                </div>
                            </div>
                            <div class="pb-3">
                                <h4 class="ttl-20 fw-semibold mb-sm-3 mb-2">Available Offers</h4>
                                @foreach ($coupons as $coupon)
                                    <div class="available_offers card mb-3">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="fs-16 fw-semibold">{{ $coupon->title }}</h6>
                                                <p class="text-black text-opacity-50 fs-14">{{ $coupon->description }}</p>
                                                <div
                                                    class="d-flex justify-content-between align-items-center pt-3 coupon-container">
                                                    <button type="button"
                                                        class="rounded-pill d-flex align-items-center AvailableOffers_btnCopyCoupon__zYN7a btn btn-light btn-sm copy-coupon-btn"
                                                        data-coupon="{{ $coupon->code }}">
                                                        <div>
                                                            {{ $coupon->code }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12.58"
                                                                height="12.58" viewBox="0 0 12.58 12.58"
                                                                class="w-em h-em ms-4">
                                                                <g transform="translate(0.5 0.5)">
                                                                    <path
                                                                        d="M14.8,13.5h5.867a1.3,1.3,0,0,1,1.3,1.3v5.867a1.3,1.3,0,0,1-1.3,1.3H14.8a1.3,1.3,0,0,1-1.3-1.3V14.8A1.3,1.3,0,0,1,14.8,13.5Z"
                                                                        transform="translate(-10.395 -10.395)"
                                                                        fill="none" stroke="currentColor"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="1"></path>
                                                                    <path
                                                                        d="M4.956,11.475H4.3a1.3,1.3,0,0,1-1.3-1.3V4.3A1.3,1.3,0,0,1,4.3,3h5.867a1.3,1.3,0,0,1,1.3,1.3v.652"
                                                                        transform="translate(-3 -3)" fill="none"
                                                                        stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="1"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    <span class="coupon-copied-message"
                                                        style="display:none; color:green; margin-left:-55px;">Copied</span>
                                                    <button type="button" class="btn-input-apply"
                                                        data-coupon="{{ $coupon->code }}">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="couponAppliedModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="couponsuccess">
                            <div>
                                <img alt="modal" loading="lazy" width="73" height="73" decoding="async"
                                    data-nimg="1" class="flex-shrink-0"
                                    src="{{ asset('assets/images/success-animation.gif') }}"
                                    style="color: transparent;width: 100%;height: 100%;">
                            </div>
                            <div class="couponsuccess_heading1" id="appliedCouponCode">10FLY applied</div>
                            <div class="couponsuccess_price" id="discountedPrice">₹80</div>
                            <div class="couponsuccess_desc1">savings with this coupon</div>
                            <div class="couponsuccess_successText">Woohoo! Your coupon is successfully applied</div>
                            <div class="couponsuccess_btn" id="closeSuccessModal">Yay!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const staticCoupons = @json($couponsSelect);

        document.addEventListener('DOMContentLoaded', function() {
            const couponButtons = document.querySelectorAll('.copy-coupon-btn');

            couponButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const couponCode = button.getAttribute('data-coupon');

                    // Copy coupon code to clipboard
                    navigator.clipboard.writeText(couponCode).then(function() {
                        // Find the nearest copied message span
                        const copiedMessage = button.closest('.coupon-container')
                            .querySelector('.coupon-copied-message');
                        if (copiedMessage) {
                            copiedMessage.style.display = 'inline';

                            // Hide after 2 seconds
                            setTimeout(() => {
                                copiedMessage.style.display = 'none';
                            }, 2000);
                        }
                    }).catch(function(err) {
                        console.error('Failed to copy coupon:', err);
                    });
                });
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            const giftCheckbox = document.getElementById('send-gift-checkbox');
            const giftAmountWrapper = document.querySelector('.gift-amount-wrapper');
            const giftPriceRow = document.getElementById('gift-price');
            const giftAmount = parseFloat(document.getElementById('gift').getAttribute('data-val')) || 0;

            // Function to handle showing/hiding and updating total
            function handleGiftSection() {
                const isChecked = giftCheckbox.checked;

                // Show/hide sections
                giftAmountWrapper.style.display = isChecked ? 'grid' : 'none';
                giftPriceRow.style.display = isChecked ? 'flex' : 'none';

                // Update session using AJAX
                fetch('{{ url('/update-gift-session') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        gift_card_applied: isChecked
                    })
                });

                // Update grand total
                updateGrandTotal(giftAmount, isChecked);
            }

            if (giftCheckbox) {
                giftCheckbox.addEventListener('change', handleGiftSection);
                handleGiftSection(); // Initial setup only if checkbox exists
            }

            // Grand total function
            function updateGrandTotal(giftAmount, isGiftChecked) {
                const subtotal = parseFloat({{ $subtotal }});
                const discount = parseFloat({{ $discount }});
                // const shipping = parseFloat({{ $shipping }});

                let grandTotal = subtotal + discount;

                if (isGiftChecked) {
                    grandTotal += giftAmount;
                }

                const grandTotalElement = document.getElementById('grand_total');
                grandTotalElement.setAttribute('data-val', grandTotal);
                grandTotalElement.innerText = `₹${Math.round(grandTotal)}`;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // const staticCoupons = {
            //     '10FLY': 10, // 10% discount
            //     'B10G2': 15, // Flat 15% discount
            //     '20BIG': 20  // 20% discount
            // };

            const subTotal = $('#grand_total').attr('data-val'); // Example subtotal (can be dynamically fetched)
            // console.log(subTotal);

            // Handle static coupon apply buttons
            document.querySelectorAll('.btn-input-apply').forEach(button => {
                button.addEventListener('click', function() {
                    const couponCode = this.getAttribute('data-coupon');
                    applyCoupon(couponCode);
                });
            });

            // Handle manual coupon apply button
            document.getElementById('btnManualApply').addEventListener('click', function() {
                const couponCode = document.getElementById('manualCoupon').value.trim().toUpperCase();
                if (couponCode && staticCoupons[couponCode] !== undefined) {
                    applyCoupon(couponCode);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Invalid Coupon Code',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__slow'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    });
                }
            });

            function applyCoupon(couponCode) {
                const discountPercent = staticCoupons[couponCode];
                const discountAmount = (subTotal * discountPercent) / 100;
                const discountedPrice = Math.round(discountAmount);

                const discountSpan = document.querySelector('.discounttag');
                if (discountSpan) {
                    discountSpan.textContent = `-₹${Math.round(discountAmount)}`;
                }

                const grandTotalElement = document.getElementById('grand_total');
                if (grandTotalElement) {
                    const originalGrandTotal = parseFloat(grandTotalElement.getAttribute('data-val'));
                    const newGrandTotal = Math.round(originalGrandTotal - discountAmount);

                    grandTotalElement.textContent = `₹${newGrandTotal}`;
                }


                // Update modal content
                document.getElementById('appliedCouponCode').textContent = couponCode + " applied";
                document.getElementById('discountedPrice').textContent = "₹" + discountedPrice;

                // Hide apply coupon modal if open
                let applyCouponModal = bootstrap.Modal.getInstance(document.getElementById('applycoupon'));
                if (applyCouponModal) {
                    applyCouponModal.hide();
                }

                // Show success modal
                let successModal = new bootstrap.Modal(document.getElementById('couponAppliedModal'));
                successModal.show();

                // Hide apply coupon section and show applied coupon section
                const couponApplyDiv = document.querySelector('.ApplyCoupon_couponApply');
                const couponContainer = document.getElementById('couponContainer');

                if (couponApplyDiv) {
                    couponApplyDiv.style.display = 'none';
                }

                // Add applied coupon section dynamically
                const appliedCouponHTML = `
                <div class="ApplyCoupon_couponItem" id="appliedCouponSection">
                    <div class="ApplyCoupon_textContainer">
                        <div class="ApplyCoupon_heading">${couponCode}</div>
                        <div class="ApplyCoupon_description">Offer applied on the bill</div>
                    </div>
                    <span class="ApplyCoupon_button_remove" id="removeCouponButton">remove</span>
                </div>
            `;

                couponContainer.innerHTML = appliedCouponHTML;

                // Add remove coupon functionality
                attachRemoveCouponListener();

                saveCouponToSession(couponCode, discountAmount);
            }

            function saveCouponToSession(couponCode, discountAmount) {
                fetch("{{ route('save_coupon') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content') // Ensure CSRF token for Laravel
                        },
                        body: JSON.stringify({
                            coupon: couponCode,
                            discount: discountAmount
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Coupon saved to session:', data);
                        loadCouponSection();
                    })
                    .catch(error => {
                        console.error('Error saving coupon to session:', error);
                    });
            }

            function attachRemoveCouponListener() {
                const removeButton = document.getElementById('removeCouponButton');
                if (removeButton) {
                    removeButton.addEventListener('click', function() {
                        // Show the apply coupon section again
                        const couponContainer = document.getElementById('couponContainer');

                        const appliedCouponHTML = `
                        <div class="ApplyCoupon_couponApply">
                            <p>
                                <span>
                                    <img src="{{ asset('assets/images/tags.svg') }}" class="img-fluid" alt="">
                                </span> Apply Coupon
                            </p>
                            <a href="javascript:;" data-bs-target="#applycoupon" data-bs-toggle="modal" class="btn design-btn" id="applyCouponButton">Apply</a>
                        </div>
                    `;

                        couponContainer.innerHTML = appliedCouponHTML;

                        const discountSpan = document.querySelector('.discounttag');
                        if (discountSpan) {
                            discountSpan.textContent = `₹0`;
                        }

                        // Reset Grand Total to Original
                        const grandTotalElement = document.getElementById('grand_total');
                        if (grandTotalElement) {
                            const originalGrandTotal = parseFloat(grandTotalElement.getAttribute(
                                'data-val'));
                            grandTotalElement.textContent = `₹${Math.round(originalGrandTotal)}`;
                        }

                        removeCouponFromSession();
                    });
                }
            }

            function removeCouponFromSession() {
                fetch("{{ route('remove_coupon') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content') // CSRF token for Laravel
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Coupon removed from session:', data);
                        loadCouponSection();
                    })
                    .catch(error => {
                        console.error('Error removing coupon from session:', error);
                    });
            }

            function loadCouponSection() {
                fetch("{{ route('get_applied_coupon') }}", {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const couponContainer = document.getElementById('couponContainer');
                        if (data.coupon) {
                            // Coupon exists, show applied coupon
                            const appliedCouponHTML = `
                        <div class="ApplyCoupon_couponItem" id="appliedCouponSection">
                            <div class="ApplyCoupon_textContainer">
                                <div class="ApplyCoupon_heading">${data.coupon.code}</div>
                                <div class="ApplyCoupon_description">Offer applied on the bill</div>
                            </div>
                            <span class="ApplyCoupon_button_remove" id="removeCouponButton">remove</span>
                        </div>
                    `;
                            couponContainer.innerHTML = appliedCouponHTML;
                            const discountSpan = document.querySelector('.discounttag');
                            if (discountSpan) {
                                discountSpan.textContent = `-₹${Math.round(data.coupon.discount)}`;
                            }

                            const grandTotalElement = document.getElementById('grand_total');
                            if (grandTotalElement) {
                                const originalGrandTotal = parseFloat(grandTotalElement.getAttribute(
                                    'data-val'));
                                const newGrandTotal = Math.round(originalGrandTotal - data.coupon.discount);
                                grandTotalElement.textContent = `₹${newGrandTotal}`;
                            }
                            attachRemoveCouponListener();
                        } else {
                            // No coupon, show Apply Coupon button
                            const applyCouponHTML = `
                        <div class="ApplyCoupon_couponApply">
                            <p>
                                <span>
                                    <img src="${document.querySelector('#applyCouponButton')?.getAttribute('data-img-src')}" class="img-fluid" alt="">
                                </span> Apply Coupon
                            </p>
                            <a href="javascript:;" data-bs-target="#applycoupon" data-bs-toggle="modal" class="btn design-btn" id="applyCouponButton">Apply</a>
                        </div>
                    `;
                            couponContainer.innerHTML = applyCouponHTML;

                            const discountSpan = document.querySelector('.discounttag');
                            if (discountSpan) {
                                discountSpan.textContent = `₹0`;
                            }

                            // Reset Grand Total to Original
                            const grandTotalElement = document.getElementById('grand_total');
                            if (grandTotalElement) {
                                const originalGrandTotal = parseFloat(grandTotalElement.getAttribute(
                                    'data-val'));
                                grandTotalElement.textContent = `₹${Math.round(originalGrandTotal)}`;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error loading coupon section:', error);
                    });
            }

            loadCouponSection();

            // Call on page load
            // document.addEventListener('DOMContentLoaded', loadCouponSection);


        });

        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const productId = button.getAttribute('data-product-id');
                const listGroup = button.closest('.listGroup');
                const fullImagePath = listGroup.querySelector('img').getAttribute('src');
                const imageName = fullImagePath.replace(`${window.location.origin}/`,
                    ''); // Remove domain part to match stored filename

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to remove this product from the cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'Cancel',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn animate__slow'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut animate__faster'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route('remove_from_cart') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: productId,
                                    image_name: imageName // <-- Send the image name
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: data.message,
                                        showClass: {
                                            popup: 'animate__animated animate__fadeIn animate__slow'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOut animate__faster'
                                        }
                                    }).then(() => {
                                        location
                                            .reload(); // Reload the page after success
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Something went wrong',
                                        text: data.message,
                                        showClass: {
                                            popup: 'animate__animated animate__fadeIn animate__slow'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOut animate__faster'
                                        }
                                    });
                                }
                            })
                            .catch(() => {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                });
                            });
                    }
                });
            });
        });

        document.querySelectorAll('.edit-item').forEach(button => {
            button.addEventListener('click', function() {
                const imageType = button.getAttribute('data-type');
                const imageSlug = button.getAttribute('data-slug');
                const imageTempSlug = button.getAttribute('data-temp-slug');
                const imageName = button.getAttribute(
                    'data-image-name'); // Get image name from data attribute\
                let filePath = imageName.split('/').pop();

                if (imageType === "manual") {
                    // Case: User uploaded a manual image
                    const designUrl = `{{ route('design') }}?image_name=${encodeURIComponent(imageName)}&temp_slug=${encodeURIComponent(imageTempSlug)}`;
                    window.location.href = designUrl; // Redirect to design page
                } else if (imageType === "collection") {
                    // Case: Image generated from collection
                    const editUrl =
                        `{{ url('collection') }}/${imageSlug}?image_name=${encodeURIComponent(filePath)}&temp_slug=${encodeURIComponent(imageTempSlug)}`;
                    window.location.href = editUrl; // Redirect to edit collection product
                } else {
                    alert("Editing is not supported for this item.");
                }
            });
        });


        function updateCartAndRedirect() {
            const grandTotalElement = document.getElementById('subtotal');
            const gift_card = $('#gift').attr('data-val');
            // const shipping = $('#shipping').attr('data-val');
            const grandTotal = grandTotalElement ? grandTotalElement.getAttribute('data-val') : 0;

            fetch('{{ route('update_cart_grand_total') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        grand_total: grandTotal,
                        gift_card: gift_card
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route('order_summary') }}'; // Redirect after update
                    } else if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update cart. Try again.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });
                    }
                })
                .catch(error => console.error('Error updating cart:', error));
        }


        $(document).ready(function() {
            setTimeout(function() {
                $('.loadermain').fadeOut();
            }, 3000);
        })
    </script>
@endpush
