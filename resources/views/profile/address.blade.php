@extends('components.layouts.app')

@section('title', 'Order Summary')

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9">
                    <div class="account-information" hidden>
                        <div class="add-address">

                            {{-- <div class="position-relative mb-0 AddressListItem_addressCheckWrp__1U43Z form-check">
                                <input id="address-9464" class="position-absolute ms-0 z-1 AddressListItem_addressCheckInput__11sYK form-check-input" type="radio" checked="" name="checkout-address">
                                <label for="address-9464" class="d-block AddressListItem_addressCheckLabel__3yHo3 form-check-label">
                                    <div class="AddressListItem_addressCard__1NEr4 card">
                                    <div class="card-body">
                                        <p class="fs-16 fw-medium mb-2">Xena Garrison</p>
                                        <p class="fs-14 mb-1">519 Oak Court</p>
                                        <p class="fs-14 mb-1">Mobile: 1564897981</p>
                                        <div class="d-flex gap-4 pt-xl-5 pt-4">
                                            <button type="button" id="edit12" class="d-flex align-items-center AddressListItem_actionButton__9aAV9 btn btn-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15.615" height="14.926" viewBox="0 0 15.615 14.926" class="w-em h-em me-1">
                                                <g transform="translate(-2.25 -2.129)">
                                                    <path d="M12,20h7.058" transform="translate(-1.942 -3.695)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <path d="M13.586,3.366a1.663,1.663,0,1,1,2.353,2.353l-9.8,9.8L3,16.3l.784-3.137Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                </g>
                                                </svg>
                                                Edit
                                            </button>
                                            <button type="button" class="d-flex align-items-center AddressListItem_actionButton__9aAV9 btn btn-text">
                                                <svg width="15.9" height="17.5" class="w-em h-em me-1" viewBox="0 0 15.9 17.5" xmlns="http://www.w3.org/2000/svg">
                                                <g transform="translate(-2.25 -1.25)">
                                                    <path d="M3,6H17.4" transform="translate(0 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <path d="M16.2,6V17.2a1.721,1.721,0,0,1-1.6,1.6h-8A1.721,1.721,0,0,1,5,17.2V6" transform="translate(-0.4 -0.8)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <path d="M8,5.2V3.6A1.721,1.721,0,0,1,9.6,2h3.2a1.721,1.721,0,0,1,1.6,1.6V5.2" transform="translate(-1)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                                    <line y2="5" transform="translate(8.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                                    <line y2="5" transform="translate(12.2 9)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
                                                </g>
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                </label>
                            </div> --}}
                            <button class="btn custom-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <svg width="16" height="16" class="w-em h-em me-1 fs-20" fill="currentColor"
                                    viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                    </path>
                                </svg> Add New Address</button>
                        </div>
                    </div>
                    <div class="account-information_new">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="add-new-address">
                                    <h1>Add Address</h1>
                                    <div class="main-radio-select">
                                        <div class="new-address-added">
                                            <div class="radio-address">
                                                <input type="radio" id="huey" name="drone" value="huey"
                                                    checked />
                                            </div>
                                            <div class="address-info">
                                                <h5>Merrill Merritt Giacomo Petty</h5>
                                                <p>Suscipit eos fuga N</p>
                                                <p>Mobile: 7031698397</p>
                                            </div>
                                        </div>
                                        <div class="address-show">
                                            <button type="button" class="edit-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15.615" height="14.926"
                                                    viewBox="0 0 15.615 14.926" class="w-em h-em me-1">
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
                                                Edit
                                            </button>
                                            <button type="button" class="edit-btn">
                                                <svg width="15.9" height="17.5" class="w-em h-em me-1"
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
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn custom-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <svg width="16" height="16" class="w-em h-em me-1 fs-20" fill="currentColor"
                                viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-width=".5" fill-rule="evenodd" stroke="currentColor"
                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                </path>
                            </svg> Add New Address</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade address-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shipping Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form id="addressForm" action="{{ route('address.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Full Name">
                                        <small class="text-danger" id="nameError"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="phone" id="phone"
                                            placeholder="Mobile Number">
                                        <small class="text-danger" id="phoneError"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Email">
                                        <small class="text-danger" id="emailError"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="text" class="form-control" name="pin_code" id="pin_code"
                                            placeholder="Pin Code">
                                        <small class="text-danger" id="pinCodeError"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <textarea name="address1" class="form-control" id="address1" placeholder="Address Line 1" rows="3"></textarea>
                                        <small class="text-danger" id="address1Error"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <textarea name="address2" class="form-control" id="address2" placeholder="Address Line 2" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <select name="state" id="state" class="form-control">
                                            <option value="">Select State</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Delhi">Delhi</option>
                                        </select>
                                        <small class="text-danger" id="stateError"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="text" class="form-control" name="city" id="city"
                                            placeholder="City">
                                        <small class="text-danger" id="cityError"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="text" class="form-control" name="alt_phone" id="alt_phone"
                                            placeholder="Alternative Phone Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="gender-label">
                                        <div class="input-toggle-click mt-3 mb-3">
                                            <input type="checkbox" name="default_address" value="1">
                                            <label class="focusimg">Use this as default address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="save-btn">
                                        <button class="btn custom-btn" type="button">Cancel</button>
                                        <button class="btn custom-btn filled" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById("addressForm").addEventListener("submit", function(event) {
            let isValid = true;

            // Clear previous error messages
            document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');

            // Validate Full Name
            let name = document.getElementById("name");
            if (name.value.trim() === "") {
                document.getElementById("nameError").innerText = "Full Name is required.";
                isValid = false;
            }

            // Validate Phone Number
            let phone = document.getElementById("phone");
            if (phone.value.trim() === "") {
                document.getElementById("phoneError").innerText = "Mobile Number is required.";
                isValid = false;
            }

            // Validate Email
            let email = document.getElementById("email");
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === "") {
                document.getElementById("emailError").innerText = "Email is required.";
                isValid = false;
            } else if (!emailPattern.test(email.value)) {
                document.getElementById("emailError").innerText = "Enter a valid email address.";
                isValid = false;
            }

            // Validate Pin Code
            let pinCode = document.getElementById("pin_code");
            if (pinCode.value.trim() === "") {
                document.getElementById("pinCodeError").innerText = "Pin Code is required.";
                isValid = false;
            }

            // Validate Address Line 1
            let address1 = document.getElementById("address1");
            if (address1.value.trim() === "") {
                document.getElementById("address1Error").innerText = "Address Line 1 is required.";
                isValid = false;
            }

            // Validate State
            let state = document.getElementById("state");
            if (state.value.trim() === "") {
                document.getElementById("stateError").innerText = "Please select a state.";
                isValid = false;
            }

            // Validate City
            let city = document.getElementById("city");
            if (city.value.trim() === "") {
                document.getElementById("cityError").innerText = "City is required.";
                isValid = false;
            }

            // If any validation fails, prevent form submission
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
@endpush
