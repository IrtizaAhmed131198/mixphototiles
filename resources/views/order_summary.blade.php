@extends('components.layouts.app')

@section('title', 'Order Summary')

@section('content')

<section class="myinformatinfoamsection">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="myinformatinfoam">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    My information
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">

                                    <div class="GuestAddress_faqContent">
                                        <form action="{{ route('place_order') }}" method="POST">
                                            @csrf
                                            <div class="row GuestAddress_addressFormRow__Tupge">
                                                <div class="col-lg-6">
                                                    <div label="Full Name">
                                                        <input placeholder="Full Name" id="nameInput" class="form-control" type="text" name="full_name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div label="Mobile Number"><input placeholder="Mobile number" maxlength="10" id="phoneInput" class="form-control" type="tel" name="phone_number"></div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div label="Email"><input placeholder="Email" id="emailInput" class="form-control" type="email" name="email"></div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div label="Pin Code"><input placeholder="Pin Code" maxlength="6" id="pinCodeInput" class="form-control" type="tel" name="pincode"></div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div label="Address Line 1 (Flat/House Number, Building/Community)">
                                                        <textarea name="address_line1" placeholder="Address Line 1 (Flat/House Number, Building/Community)" id="address1Input" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div label="Address Line 2 (Street, Locality, City)">
                                                        <textarea name="address_line2" placeholder="Address Line 2 (Street, Locality, City)" id="address2Input" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-select form-control" aria-label="Default select example">
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div label="City"><input placeholder="City" id="pinCodeInput" class="form-control" name="city"></div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div label="Alternative Phone Number">
                                                        <input placeholder="Alternative Phone Number" maxlength="10" id="altPhoneInput" class="form-control" type="text" name="alternate_phone_number">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6"><button type="submit" class="btn custom-btn filled">Save</button></div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="parentRightcart">

                    <div class="paymentdetailsbody">
                        <div class="cartheader">
                            <div class="ApplyCoupon_couponApply">
                                <p>Cart Summary</p>
                            </div>
                        </div>

                        @foreach ($cart as $item)
                        <div class="purchaseditem">
                            <figure class="carditemimage">
                                <img src="{{ asset($item['image']) }}" class="img-fluid" alt="{{ $item['name'] }}">
                            </figure>
                            <div class="cardlistdetail">
                                <p class="heading-6">{{ $item['name'] }}</p>
                                <h5>₹{{ number_format($item['total'], 2) }}</h5>
                            </div>
                        </div>
                        @endforeach

                        <div class="parentcardlistdetail">
                            <div class="cartParent">
                                <h5 class="pricedetails">Price Details</h5>
                                <ul class="cartListpaymentdetails">
                                    <li>
                                        <p class="customTilename">Sub Total</p>
                                        <span>₹{{ number_format($cartGrandTotal, 2) }}</span>
                                    </li>

                                    @if ($appliedCoupon['code'])
                                    <li>
                                        <p class="customTilename">Coupon Applied ({{ $appliedCoupon['code'] }})</p>
                                        <span class="discounttag">- ₹{{ number_format($appliedCoupon['discount'], 2) }}</span>
                                    </li>
                                    @endif

                                    <li>
                                        <p class="customTilename">Gift Card</p>
                                        <span class="discounttag">- ₹{{ number_format($giftCard, 2) }}</span>
                                    </li>

                                    <li class="grandTotal">
                                        <p class="customTilename">Grand Total</p>
                                        @php
                                            $finalTotal = $cartGrandTotal - $appliedCoupon['discount'] - $giftCard;
                                        @endphp
                                        <span>₹{{ number_format($finalTotal, 2) }}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="pt-3">
                                <div class="pay_options">
                                    <label>
                                        <input type="radio" value="razorpay" checked name="payment_method">
                                        <img src="{{ asset('assets/images/razorpay.png') }}" alt="Razorpay" class="img-fluid">
                                    </label>
                                    <label>
                                        <input type="radio" value="paytm" name="payment_method">
                                        <img src="{{ asset('assets/images/paytm.png') }}" alt="Paytm" class="img-fluid">
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input id="agreeTc" class="form-check-input" type="checkbox">
                                    <label for="agreeTc" class="fs-14 fw-medium form-check-label">
                                        I hereby agree to the <a href="#" class="text-decoration-underline fw-semibold px-1">Terms and Conditions</a>.
                                    </label>
                                </div>

                                <button type="button" class="btn custom-btn filled">
                                    Pay Now
                                </button>
                            </div>
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
