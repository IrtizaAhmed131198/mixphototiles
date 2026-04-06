@extends('components.layouts.app')

@section('noindex', true)

@section('title', 'OrderSummary')

@push('css')
    <style>
        .show_address {
            padding: 10px 20px;
            list-style: none;
            width: 100%;
            border: 1px solid #fff;
        }

        .show_address_first {
            margin: 10px 0;
            font-size: 1.1em;
            font-weight: 600;
        }

        .show_address li {
            margin: 10px 0;
        }

        /* @keyframes circle {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);

            }
        } */
    </style>
@endpush

@section('content')
{{-- <div class="loadermain">
    <div class="loader-container">
        <div class="loaderMain">
            <img src="{{ asset('assets/images/loader.png') }}" class="img-fluid" alt="">
        </div>
    </div>
</div> --}}

    <section class="myinformatinfoamsection">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="myinformatinfoam">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseOne">
                                        My information
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne"
                                    class="accordion-collapse collapse {{ session()->has('user_address') ? '' : 'show' }}">
                                    <div class="accordion-body">
                                        <div class="GuestAddress_faqContent">
                                            <form id="addressForm">
                                                @csrf
                                                <div class="row GuestAddress_addressFormRow__Tupge">
                                                    <div class="col-lg-6">
                                                        <div label="Full Name">
                                                            <input placeholder="Full Name" id="nameInput"
                                                                class="form-control" type="text" name="full_name"
                                                                value="{{ $shipping_address->recipient_name ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div label="Mobile Number">
                                                            <input placeholder="Mobile number" maxlength="10"
                                                                id="phoneInput" class="form-control" type="text"
                                                                name="phone_number" value="{{ $shipping_address->phone ?? '' }}"
                                                                maxlength="15" pattern="\d{10,15}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div label="Email">
                                                            <input placeholder="Email" id="emailInput" class="form-control"
                                                                autocomplete="off" type="email" name="email"
                                                                value="{{ $shipping_address->email ?? '' }}">
                                                        </div>
                                                    </div>

                                                    <!--signup-->
                                                    @if (!Auth::check())
                                                        <div class="col-lg-6">
                                                            <div label="Password">
                                                                <input placeholder="Password" id="passwordInput"
                                                                    class="form-control" autocomplete="new-password"
                                                                    type="password" name="password" value="">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="col-lg-6">
                                                        <div label="Pin Code">
                                                            <input placeholder="Pin Code" maxlength="6" pattern="\d{6}" id="pinCodeInput"
                                                                class="form-control" type="number" name="pincode"
                                                                value="{{ $shipping_address->pin_code ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div label="Address Line 1 (Flat/House Number, Building/Community)">
                                                            <textarea name="address_line1" placeholder="Address Line 1 (Flat/House Number, Building/Community)" id="address1Input"
                                                                class="form-control">{{ $shipping_address->address_line1 ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div label="Address Line 2 (Street, Locality, City)">
                                                            <textarea name="address_line2" placeholder="Address Line 2 (Street, Locality, City)" id="address2Input"
                                                                class="form-control">{{ $shipping_address->address_line2 ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select class="form-select form-control" id="stateDropdown" name="state">
                                                            <option value="">---Select State---</option>
                                                            <option value="other">Other</option> <!-- Added Other -->
                                                        </select>
                                                        <input type="text" id="stateInput" name="state_name" class="form-control mt-2 d-none" placeholder="Enter State">
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <select class="form-select form-control" id="cityDropdown" name="city">
                                                            <option value="">---Select City---</option>
                                                            <option value="other">Other</option> <!-- Added Other -->
                                                        </select>
                                                        <input type="text" id="cityInput" name="city_name" class="form-control mt-2 d-none" placeholder="Enter City">
                                                    </div>

                                                    <input type="hidden" name="shipping" id="shippingInput" value="0">
                                                    <div class="col-lg-6">
                                                        <div label="Alternative Phone Number">
                                                            <input placeholder="Alternative Phone Number" id="altPhoneInput"
                                                                class="form-control" type="text"
                                                                name="alternate_phone_number" maxlength="15" pattern="\d{10,15}"
                                                                value="{{ $shipping_address->alt_phone ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        @php
                                                            $email = $shipping_address->email ?? '';
                                                            $disabled = '';
                                                            $css = '';
                                                            if($email){
                                                                $disabled = ($shipping_address->email == '') ? '' : 'disabled';
                                                                $css = ($shipping_address->email == '') ? '' : 'opacity: .6 !important';
                                                            }
                                                        @endphp
                                                        <button type="button" id="saveAddressBtn"
                                                            class="btn design-btn filled" style=""
                                                            >Save @if (!Auth::check()) & Sign Up @endif
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="addressDisplay">
                            @if (session()->has('user_address'))
                                @php
                                    $address = session('user_address');
                                @endphp
                                <ul class="show_address">
                                    <li class="show_address_first">{{ $address['full_name'] }}</li>
                                    <li>{{ $address['email'] }}</li>
                                    <li>{{ $address['address_line1'] }}, {{ $address['address_line2'] }},
                                        {{ $address['city'] }}, {{ $address['state'] }}, {{ $address['pincode'] }}, India
                                    </li>
                                </ul>
                            @endif
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
                                        <img src="{{ asset($item['image']) }}" class="img-fluid"
                                            alt="{{ $item['name'] }}">
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
                                                <p class="customTilename">Coupon Applied ({{ $appliedCoupon['code'] }})
                                                </p>
                                                <span class="discounttag">-
                                                    ₹{{ number_format($appliedCoupon['discount'], 2) }}</span>
                                            </li>
                                        @endif

                                        {{-- <li>
                                        <p class="customTilename">Gift Card</p>
                                        <span class="">₹{{ number_format($giftCard, 2) }}</span>
                                    </li> --}}

                                        <li>
                                            <p class="customTilename">Shipping</p>
                                            <span class="shipping_total">
                                                @if($shipping == 0)
                                                    Free
                                                @else
                                                    ₹{{ number_format($shipping, 2) }}
                                                @endif
                                            </span>
                                        </li>

                                        @php
                                            $finalTotal = $cartGrandTotal + $shipping + $giftCard - $appliedCoupon['discount'];
                                        @endphp
                                        <li class="grandTotal">
                                            <p class="customTilename">Grand Total</p>
                                            <span>₹{{ number_format($finalTotal, 2) }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="pt-3">
                                    <div class="pay_options">
                                        <label>
                                            <input type="radio" value="razorpay" checked name="payment_method" checked>
                                            <img src="{{ asset('assets/images/razorpay.png') }}" alt="Razorpay"
                                                class="img-fluid">
                                        </label>
                                        {{-- <label>
                                            <input type="radio" value="paytm" name="payment_method">
                                            <img src="{{ asset('assets/images/paytm.png') }}" alt="Paytm"
                                                class="img-fluid">
                                        </label> --}}
                                    </div>

                                    <div class="form-check">
                                        <input id="agreeTc" class="form-check-input" type="checkbox">
                                        <label for="agreeTc" class="fs-14 fw-medium form-check-label">
                                            I hereby agree to the <a href="{{ route('terms') }}" target="_blank"
                                                class="text-decoration-underline fw-semibold px-1">Terms and
                                                Conditions</a>.
                                        </label>
                                    </div>

                                    <button type="button" class="btn design-btn filled" onclick="validateAndProceed()">
                                        Pay Now
                                    </button>

                                </div>
                            </div>
                        </div>


                        <div class="noticeproductdetail">
                            <p>
                                Our Magentick Photo Frames are custom-made to order. Once your order is placed, please allow
                                2–3 business days for production.
                                After that, your frames will be shipped. Delivery times may vary depending on holidays,
                                weather conditions, or courier delays.
                                As this is a customized product, we kindly ask you to anticipate potential delays. For more
                                accurate delivery estimates, please
                                refer to our Shipping Policy.
                            </p>
                        </div>
                        <div class="productpolicylinks">
                            <a class="" href="{{ route('shipping') }}" target="_blank">Shipping Policy</a>
                            {{-- <a class="" href="{{ route('faq') }}" target="_blank">FAQ's</a> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        const mainLoader = document.querySelector('.loadermain');
        if (mainLoader) mainLoader.style.display = 'none';
        const selectedStateId = "{{ $shipping_address->state ?? '' }}";
        const selectedCityId = "{{ $shipping_address->city ?? '' }}";

        let shippingPrice = {{ $shipping ?? 0 }};
        let cartGrandTotal = {{ $cartGrandTotal }};
        let giftCard = {{ $giftCard }};
        let discount = {{ $appliedCoupon['discount'] ?? 0 }};

        const numericFields = [{
                id: 'pinCodeInput',
                max: 6
            },
            {
                id: 'phoneInput',
                max: 15
            },
            {
                id: 'altPhoneInput',
                max: 15
            }
        ];

        numericFields.forEach(field => {
            const input = document.getElementById(field.id);
            if (!input) return;

            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, ''); // remove non-digits
                if (field.max && this.value.length > field.max) {
                    this.value = this.value.slice(0, field.max);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const stateDropdown = document.getElementById('stateDropdown');
            const cityDropdown = document.getElementById('cityDropdown');
            const stateInput = document.getElementById('stateInput');
            const cityInput = document.getElementById('cityInput');

            // State change
            stateDropdown.addEventListener('change', function () {
                if (this.value === 'other') {
                    stateInput.classList.remove('d-none');

                    // Reset city dropdown and show Other option
                    cityDropdown.innerHTML = '<option value="other">Other</option>';
                    cityInput.classList.remove('d-none'); // user can type city directly
                } else {
                    stateInput.classList.add('d-none');
                    cityInput.classList.add('d-none');
                }
            });

            // City change
            cityDropdown.addEventListener('change', function () {
                if (this.value === 'other') {
                    cityInput.classList.remove('d-none');
                } else {
                    cityInput.classList.add('d-none');
                }
            });

            // Load states
            fetch("{{ route('states') }}")
                .then(response => response.json())
                .then(result => {
                    const states = result.data;
                    states.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state.id;
                        option.textContent = state.name;
                        if (state.id == selectedStateId) {
                            option.selected = true;
                        }
                        stateDropdown.appendChild(option);
                    });

                    // Always add "Other"
                    const otherOption = document.createElement('option');
                    otherOption.value = "other";
                    otherOption.textContent = "Other";
                    stateDropdown.appendChild(otherOption);

                    // Trigger change to load cities if pre-selected
                    if (selectedStateId) {
                        stateDropdown.dispatchEvent(new Event('change'));
                    }
                })
                .catch(error => console.error('Error fetching states:', error));

            // When state changes, load cities
            stateDropdown.addEventListener('change', function() {
                const stateId = this.value;
                cityDropdown.innerHTML = '<option value="">---Select City---</option>';

                if (stateId && stateId !== 'other') {
                    fetch("{{ url('cities') }}/" + stateId)
                        .then(response => response.json())
                        .then(result => {
                            const cities = result.data;
                            cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                option.setAttribute('data-shipping', city.shipping);
                                if (city.id == selectedCityId) {
                                    option.selected = true;
                                }
                                cityDropdown.appendChild(option);
                            });

                            // Always add "Other"
                            const otherOption = document.createElement('option');
                            otherOption.value = "other";
                            otherOption.textContent = "Other";
                            cityDropdown.appendChild(otherOption);

                            // Trigger change if city was preselected
                            if (selectedCityId) {
                                cityDropdown.dispatchEvent(new Event('change'));
                            }
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                } else if (stateId === 'other') {
                    // Show only "Other" in city dropdown
                    cityDropdown.innerHTML = '<option value="other">Other</option>';
                }
            });

            // City shipping calculation
            cityDropdown.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const shippingPrice = parseFloat(selectedOption.getAttribute('data-shipping')) || 0;

                // Update UI
                if (shippingPrice === 0) {
                    document.querySelector('.shipping_total').textContent = 'Free';
                } else {
                    document.querySelector('.shipping_total').textContent = `₹${shippingPrice.toFixed(2)}`;
                }
                document.querySelector('#shippingInput').value = `${shippingPrice.toFixed(2)}`;

                const newGrandTotal = (cartGrandTotal + giftCard + shippingPrice) - discount;
                document.querySelector('.grandTotal span').textContent = `₹${newGrandTotal.toFixed(2)}`;
            });
        });

        $('#saveAddressBtn').on('click', function() {
            let formData = $('#addressForm').serialize();

            $.ajax({
                url: "{{ route('add_address') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Show success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });

                        // Update the address display
                        showAddress(response.address);

                        // Collapse the accordion
                        let accordionElement = document.getElementById('panelsStayOpen-collapseOne');
                        let bsCollapse = new bootstrap.Collapse(accordionElement, {
                            toggle: false // Prevent auto-toggle (because it's open already)
                        });
                        bsCollapse.hide(); // This will close the accordion section
                    } else if (response.error) {
                        if (response.type === 'email_exists') {

                            // Show a small message above the login form
                            $('#loginMessage').html(
                                '<div class="alert alert-warning text-center mb-3">' + response.message + '</div>'
                            );

                            // Close any open modal first, then open login modal
                            $('.modal').modal('hide');
                            setTimeout(function() {
                                $('#exampleModalToggle').one('shown.bs.modal', function() {
                                    $('.emailOrMobileInput').val(response.email);
                                });
                                $('#exampleModalToggle').modal('show');
                            }, 400);

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__slow'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                }
                            });
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save address.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '<ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul>';

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorHtml,
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
                            text: 'Something went wrong. Please try again.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });
                    }
                }
            });
        });

        function showAddress(address) {
            let html = `
            <ul class="show_address">
                <li class="show_address_first">${address.full_name}</li>
                <li>${address.email}</li>
                <li>${address.address_line1}, ${address.address_line2}, ${address.city}, ${address.state}, ${address.pincode}, India</li>
            </ul>
        `;
            $('#addressDisplay').html(html);
        }

        function validateAndProceed() {
            let agreeTc = document.getElementById('agreeTc').checked;
            if (!agreeTc) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'You must agree to the Terms and Conditions.',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn animate__slow'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut animate__faster'
                    }
                });
                return;
            }

            fetch("{{ route('check_user_address') }}")
                .then(response => response.json())
                .then(data => {
                    if (!data.hasAddress) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please save your address before proceeding.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });
                    } else {
                        if (mainLoader) mainLoader.style.display = 'flex';
                        // Step 1: Create Razorpay Order
                        fetch("{{ route('razorpay.create_order') }}", {
                                method: 'GET',
                            })
                            .then(response => response.json())
                            .then(order => {
                                let options = {
                                    "key": "{{ env('RAZORPAY_KEY') }}", // Or use config('services.razorpay.key')
                                    "amount": order.amount,
                                    "currency": "INR",
                                    "name": "Magentick Photo Frames",
                                    "description": "Order Payment",
                                    "order_id": order.id,
                                    "handler": function(response) {
                                        // Step 2: Verify payment
                                        fetch("{{ route('razorpay.verify_payment') }}", {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                },
                                                body: JSON.stringify({
                                                    razorpay_payment_id: response
                                                        .razorpay_payment_id,
                                                    razorpay_order_id: response
                                                        .razorpay_order_id,
                                                    razorpay_signature: response
                                                        .razorpay_signature
                                                })
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    const method = data.method;
                                                    // Step 3: Place order in Laravel
                                                    fetch("{{ route('place_order') }}", {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            },
                                                            body: JSON.stringify({
                                                                razorpay_payment_id: response.razorpay_payment_id,
                                                                payment_method: method, // <-- Send actual method here
                                                                payment: data.payment    // Full payment details if you want to log it
                                                            })
                                                        })
                                                        .then(res => res.json())
                                                        .then(result => {
                                                            if (result.success) {
                                                                if (mainLoader) mainLoader.style.display = 'none';
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Success',
                                                                    text: 'Order placed successfully!',
                                                                    timer: 2000,
                                                                    showConfirmButton: false,
                                                                    showClass: {
                                                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                                                    },
                                                                    hideClass: {
                                                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                                                    }
                                                                }).then(() => {
                                                                    window.location.href = "{{ route('home') }}";
                                                                });
                                                            } else {
                                                                if (mainLoader) mainLoader.style.display = 'none';
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Error',
                                                                    text: 'Order placement failed!',
                                                                    showClass: {
                                                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                                                    },
                                                                    hideClass: {
                                                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                                                    }
                                                                });
                                                            }
                                                        });
                                                } else {
                                                    if (mainLoader) mainLoader.style.display = 'none';
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: 'Payment verification failed!',
                                                        showClass: {
                                                            popup: 'animate__animated animate__fadeIn animate__slow'
                                                        },
                                                        hideClass: {
                                                            popup: 'animate__animated animate__fadeOut animate__faster'
                                                        }
                                                    });
                                                }
                                            });
                                    },
                                    "modal": {
                                        "ondismiss": function () {
                                            if (mainLoader) mainLoader.style.display = 'none';
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Payment Cancelled',
                                                text: 'You have cancelled the payment process.',
                                                showClass: {
                                                    popup: 'animate__animated animate__fadeIn animate__slow'
                                                },
                                                hideClass: {
                                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                                }
                                            });
                                        }
                                    },
                                    "prefill": {
                                        "name": order.customer_name ?? "",
                                        "email": order.customer_email ?? ""
                                    },
                                    "theme": {
                                        "color": "#3399cc"
                                    },
                                    "method": {
                                        "wallet": false,
                                        "paylater": false
                                    }
                                };

                                let rzp = new Razorpay(options);
                                rzp.open();
                            });
                    }
                });
        }
    </script>
@endpush
