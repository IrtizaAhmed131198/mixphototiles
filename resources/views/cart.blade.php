@extends('components.layouts.app')

@section('title', 'Cart')

@section('content')
<section class="cartSection">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="parentCart">
                    <h4 class="">
                        Your Cart
                        <span class="itemsCount">(1 Items)</span>
                    </h4>
                </div>

                <div class="cardList">
                    <div class="listGroup">
                        <figure class="carditemimage">
                            <img src="{{ asset('assets/images/1702965251740.jpeg') }}" class="img-fluid" alt="">
                        </figure>
                        <div class="cardlistdetail">
                            <p class="heading-6">
                                Symmetry
                            </p>
                            <div class="cardlistaction">
                                <button type="button" class="CartListItem_action">
                                    <svg width="15.9" height="17.5" class="w-em h-em pe-1 fs-16" viewBox="0 0 15.9 17.5" xmlns="http://www.w3.org/2000/svg">
                                        <g transform="translate(-2.25 -1.25)">
                                            <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <path d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6" transform="translate(-0.4 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <path d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2" transform="translate(-1)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <line y2="5" transform="translate(8.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                            <line y2="5" transform="translate(12.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                        </g>
                                    </svg>
                                    Remove
                                </button>
                                <button type="button" class="CartListItem_action"><svg xmlns="http://www.w3.org/2000/svg" width="15.615" height="14.926" viewBox="0 0 15.615 14.926" class="w-em h-em pe-1 fs-16">
                                        <g transform="translate(-2.25 -2.129)">
                                            <path d="M12,20h7.058" transform="translate(-1.942 -3.695)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <path d="M13.586,3.366a1.663,1.663,0,1,1,2.353,2.353l-9.8,9.8L3,16.3l.784-3.137Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                        </g>
                                    </svg>Edit Items
                                </button>
                            </div>

                        </div>
                        <div class="cartPrice">
                            <h5>₹3674.00</h5>
                        </div>
                    </div>

                    <div class="pt-4 form-check giftcheck">
                        <input id="send-gift-checkbox" class="form-check-input" type="checkbox">
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
                    </div>

                    <div class="listGroup giftitemparent">
                        <figure class="carditemimage">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.053" height="17.5" viewBox="0 0 19.053 17.5" class="w-em h-em ps-1 ttl-36 m-0">
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
                        </figure>
                        <div class="cardlistdetail">
                            <p class="heading-6">
                                Symmetry
                            </p>
                            <div class="cardlistaction">
                                <button type="button" class="CartListItem_action">
                                    <svg width="15.9" height="17.5" class="w-em h-em pe-1 fs-16" viewBox="0 0 15.9 17.5" xmlns="http://www.w3.org/2000/svg">
                                        <g transform="translate(-2.25 -1.25)">
                                            <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <path d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6" transform="translate(-0.4 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <path d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2" transform="translate(-1)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <line y2="5" transform="translate(8.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                            <line y2="5" transform="translate(12.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                        </g>
                                    </svg>
                                    Remove
                                </button>
                                <button type="button" class="CartListItem_action"><svg xmlns="http://www.w3.org/2000/svg" width="15.615" height="14.926" viewBox="0 0 15.615 14.926" class="w-em h-em pe-1 fs-16">
                                        <g transform="translate(-2.25 -2.129)">
                                            <path d="M12,20h7.058" transform="translate(-1.942 -3.695)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <path d="M13.586,3.366a1.663,1.663,0,1,1,2.353,2.353l-9.8,9.8L3,16.3l.784-3.137Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                        </g>
                                    </svg>Edit Items
                                </button>
                            </div>

                        </div>
                        <div class="cartPrice">
                            <h5>₹3674.00</h5>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="parentRightcart">

                    <div class="paymentdetailsbody">
                        <div class="cartheader">
                            <div class="ApplyCoupon_couponApply">
                                <p>
                                    <span>
                                        <img src="{{ asset('assets/images/tags.svg') }}" class="img-fluid" alt="">
                                    </span> Apply Coupon
                                </p>
                                <button class="btn custom-btn">Apply</button>
                            </div>
                        </div>

                        <div class="parentcardlistdetail">
                            <div class="cartParent">
                                <h5 class="pricedetails">
                                    Price Details
                                </h5>
                                <ul class="cartListpaymentdetails">
                                    <li>
                                        <p class="customTilename">Sub Total
                                            <span class="text-body-tertiary">includes ₹394 GST @ 12%</span>
                                        </p>
                                        <span> ₹3674 </span>
                                    </li>
                                    <li>
                                        <p class="customTilename">Discount
                                        </p>
                                        <span class="discounttag"> ₹0 </span>
                                    </li>
                                    <li class="grandTotal">
                                        <p class="customTilename">Sub Total
                                        </p>
                                        <span> ₹59 </span>
                                    </li>
                                </ul>
                            </div>

                            <button type="button" class="btn custom-btn filled" onclick="window.location.href='{{ route('order_summary') }}'">
                                Continue
                            </button>

                        </div>
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
