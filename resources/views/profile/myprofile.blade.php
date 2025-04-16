@extends('components.layouts.app')

@section('title', 'My Profile')

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
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                        <label>Email</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}" required>
                                        <label>Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                        <label>Full Name</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group birth-label">
                                        <input type="date" class="form-control" name="dob" value="{{ Auth::user()->dob }}" required>
                                        <label>Date of Birth</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="gender-label">
                                        <p>Gender:</p>
                                        <div class="input-toggle-click">
                                            <input type="radio" class="form-check-input" name="gender" value="male" {{ Auth::user()->gender == 'male' ? 'checked' : '' }}>
                                            <label for="male" class="focusimg">Male</label>
                                        </div>
                                        <div class="input-toggle-click">
                                            <input type="radio" class="form-check-input" name="gender" value="female" {{ Auth::user()->gender == 'female' ? 'checked' : '' }}>
                                            <label for="female" class="focusimg">Female</label>
                                        </div>
                                        <div class="input-toggle-click">
                                            <input type="radio" class="form-check-input" name="gender" value="other" {{ Auth::user()->gender == 'other' ? 'checked' : '' }}>
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
            // Handling input focus, blur, and input events to toggle 'active' class
            $('.form-group input').on('focus blur input', function() {
                if ($(this).val() !== '' || $(this).is(':focus')) {
                    $(this).parent().addClass('active');
                } else {
                    $(this).parent().removeClass('active');
                }
            });

            // Manually trigger 'active' class if the input already has a value
            $('.form-group input').each(function() {
                if ($(this).val() !== '') {
                    $(this).parent().addClass('active');
                }
            });

            // Handling radio button toggle clicks
            $('.input-toggle-click').click(function() {
                $(this).find('input').prop('checked', true);
            });

            // Ensure the active state of radio buttons based on pre-selected gender
            $('input[name="gender"]').each(function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.input-toggle-click').addClass('active');
                }
            });
        });
    </script>
@endpush
