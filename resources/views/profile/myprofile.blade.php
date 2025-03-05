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
                        <h1>Account Information</h1>
                        <form action="">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="email" required>
                                        <label>Email</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="phone" required>
                                        <label>Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" required>
                                        <label>Full Name</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="date" class="form-control" name="date" required>
                                        <label>Date of Birth</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="gender-label">
                                        <p>Gender:</p>
                                        <div class="input-toggle-click">
                                            <input type="radio" class="form-check-input" name="gender">
                                            <label for="male" class="focusimg">Male</label>
                                        </div>
                                        <div class="input-toggle-click">
                                            <input type="radio" class="form-check-input" name="gender">
                                            <label for="female" class="focusimg">Female</label>
                                        </div>
                                        <div class="input-toggle-click">
                                            <input type="radio" class="form-check-input" name="gender">
                                            <label for="other" class="focusimg">Other</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="frm-btn">
                                    <button type="submit" class="btn custom-btn filled mt-5">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.form-group input').on('focus blur input', function() {
                if ($(this).val() !== '' || $(this).is(':focus')) {
                    $(this).parent().addClass('active');
                } else {
                    $(this).parent().removeClass('active');
                }
            });
        });

        $(document).ready(function() {
            $('.input-toggle-click').click(function() {
                $(this).find('input').prop('checked', true);
            });
        });
    </script>
@endpush
