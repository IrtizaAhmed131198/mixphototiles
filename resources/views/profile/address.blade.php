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
                    @if(!$data)
                        <div class="account-information">
                            <div class="add-address">
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
                    @else
                        <div class="account-information_new">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="add-new-address">
                                        <h1>Add Address</h1>
                                        <div class="row parent-address">
                                            @foreach ($data as $val)
                                                <div class="main-radio-select col-md-5">
                                                    <div class="new-address-added">
                                                        <div class="radio-address">
                                                            <input type="radio" id="default_address_check" name="default_address_check" value=""
                                                                {{ $val->default_address == 1 ? 'checked' : '' }} />
                                                        </div>
                                                        <div class="address-info">
                                                            <h5>{{ $val->recipient_name }}</h5>
                                                            <p>{{ $val->address_line1 }}</p>
                                                            <p>Mobile: {{ $val->phone }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="address-show">
                                                        <button type="button" class="edit-btn edit-address" data-id="{{ $val->id }}"
                                                            data-name="{{ $val->recipient_name }}"
                                                            data-phone="{{ $val->phone }}"
                                                            data-email="{{ $val->email }}"
                                                            data-pin_code="{{ $val->pin_code }}"
                                                            data-address1="{{ $val->address_line1 }}"
                                                            data-address2="{{ $val->address_line2 }}"
                                                            data-state="{{ $val->state }}"
                                                            data-city="{{ $val->city }}"
                                                            data-alt_phone="{{ $val->alt_phone }}"
                                                            data-default_address="{{ $val->default_address }}"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            Edit
                                                        </button>
                                                        <button type="button" class="delete-btn" data-id="{{ $val->id }}">
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
                                            @endforeach
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
                    @endif
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
                                            <option value="" disabled selected>---Select State---</option>
                                        </select>
                                        <small class="text-danger" id="stateError"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <select class="form-select form-control" id="city" name="city">
                                            <option value="">---Select City---</option>
                                        </select>
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

        $(document).ready(function () {
            $(".edit-address").click(function () {
                let id = $(this).data("id");
                $("#addressForm").attr("action", "{{ url('address/update') }}/" + id); // Set action for update

                $("#name").val($(this).data("name"));
                $("#phone").val($(this).data("phone"));
                $("#email").val($(this).data("email"));
                $("#pin_code").val($(this).data("pin_code"));
                $("#address1").val($(this).data("address1"));
                $("#address2").val($(this).data("address2"));
                $("#state").val($(this).data("state"));
                $("#city").val($(this).data("city"));
                $("#alt_phone").val($(this).data("alt_phone"));
                $("input[name='default_address']").prop("checked", $(this).data("default_address") == 1);

                $(".modal-title").text("Edit Address"); // Change modal title
                $(".filled").text("Update"); // Change button text
            });

            // Reset modal when closed
            $("#exampleModal").on("hidden.bs.modal", function () {
                $("#addressForm").trigger("reset");
                $(".modal-title").text("Add Address");
                $(".filled").text("Save");
                $("#addressForm").attr("action", "{{ route('address.store') }}");
            });
        });

        $(document).on("click", ".delete-btn", function () {
            let id = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('address/delete') }}/" + id,
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success",
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__faster'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                }
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                title: "Error!",
                                text: "Error deleting address.",
                                icon: "error",
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__faster'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                }
                            });
                        },
                    });
                }
            });
        });


        $(document).on("click", ".main-radio-select", function (e) {
            // Prevent triggering when clicking on buttons inside the div
            if ($(e.target).hasClass("edit-btn") || $(e.target).hasClass("delete-btn")) {
                return;
            }

            let radio = $(this).find("input[name='default_address_check']");
            let id = $(this).find(".delete-btn").data("id"); // Get the address ID

            if (!radio.is(":checked")) {
                radio.prop("checked", true);

                // Send AJAX request to update the default address
                $.ajax({
                    url: "{{ route('address.set-default') }}", // Change to your actual route
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function (response) {
                        if (response.success) {
                            $(".main-radio-select input[name='default_address_check']").prop("checked", false);
                            radio.prop("checked", true);

                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.message,
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__faster'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Failed to update default address.",
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__faster'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                }
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An error occurred while updating default address.",
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });
                    },
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Load states
            fetch("{{ route('states') }}")
                .then(response => response.json())
                .then(result => {
                    const states = result.data;
                    const dropdown = document.getElementById('state');
                    states.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state.id;
                        option.textContent = state.name;
                        dropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching states:', error));

            // When state changes, load cities
            document.getElementById('state').addEventListener('change', function () {
                const stateId = this.value;
                const cityDropdown = document.getElementById('city');
                cityDropdown.innerHTML = '<option value="">---Select City---</option>'; // reset

                if (stateId) {
                    fetch("{{ url('cities') }}/"+ stateId)
                        .then(response => response.json())
                        .then(result => {
                            const cities = result.data;
                            cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                option.setAttribute('data-shipping', city.shipping);
                                cityDropdown.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                }
            });
        });

    </script>
@endpush
