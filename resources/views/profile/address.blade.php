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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="nmae" placeholder="Full Name"
                                            required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="phone"
                                            placeholder="Mobile Number" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="email" placeholder="Email"
                                            required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="date" class="form-control" name="pin" placeholder="Pin Code"
                                            required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <textarea name="address1" id="textarea1" class="form-control"
                                            placeholder="Address Line 1 (Flat/House Number, Building/Community)" rows="6" required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <textarea name="address2" id="textarea2" class="form-control" placeholder="Address Line 2 (Street, Locality, City)"
                                            rows="6" required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <select name="" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="">Assam</option>
                                            <option value="">Bihar</option>
                                            <option value="">Chandigarh</option>
                                            <option value="">Delhi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="text" class="form-control" name="city" placeholder="City"
                                            required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="text" class="form-control" name="phn"
                                            placeholder="Alternative Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="gender-label">
                                        <div class="input-toggle-click mt-3 mb-3">
                                            <input type="radio" class="form-check-input" name="gender">
                                            <label for="male" class="focusimg">Use this as default address</label>
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
@endpush
