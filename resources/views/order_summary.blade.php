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
                                        <form>
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
                                <p>
                                    Cart Summary
                                </p>
                                <button type="button" class="CartListItem_action"><svg xmlns="http://www.w3.org/2000/svg" width="15.615" height="14.926" viewBox="0 0 15.615 14.926" class="w-em h-em pe-1 fs-16">
                                        <g transform="translate(-2.25 -2.129)">
                                            <path d="M12,20h7.058" transform="translate(-1.942 -3.695)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                            <path d="M13.586,3.366a1.663,1.663,0,1,1,2.353,2.353l-9.8,9.8L3,16.3l.784-3.137Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                        </g>
                                    </svg>Edit Items
                                </button>
                            </div>
                        </div>

                        <div class="purchaseditem">
                            <figure class="carditemimage">
                                <img src="assets/images/1702965251740.jpeg" class="img-fluid" alt="">
                            </figure>
                            <div class="cardlistdetail">
                                <p class="heading-6">
                                    Symmetry
                                </p>
                                <h5>₹3674.00</h5>

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
                                        <p class="customTilename">Grand Total
                                        </p>
                                        <span> ₹59 </span>
                                    </li>
                                </ul>
                            </div>

                            <div class="pt-3">
                                <div class="pay_options">
                                    <label>
                                        <input type="radio" value="razorpay" checked="" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                        <img alt="razorPay" width="80" height="17" class="img" class="img-fluid" src="assets/images/razorpay.png" for="flexRadioDefault1">
                                    </label>
                                    <label>
                                        <input type="radio" value="paytm" name="flexRadioDefault" id="flexRadioDefault2">
                                        <img alt="paytm" width="40" height="13" class="img-fluid" src="assets/images/paytm.png" for="flexRadioDefault2" >
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="agreeTc" class="form-check-input" type="checkbox">
                                    <label for="agreeTc" class="fs-14 fw-medium form-check-label">I here by agree to the <a href="#" class="text-decoration-underline fw-semibold px-1">Terms and Conditions</a> mentioned herewith.</label>
                                </div>
                            </div>

                            <button type="button" class="btn custom-btn filled">
                                Pay Now
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
