@extends('components.layouts.app')

@section('title', 'Reset Password')

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9">
                    <div class="account-information">
                        <h1>Reset Password</h1>
                        <form id="resetPasswordForm" action="{{ route('profile.reset-password') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <label>Password</label>
                                        <span id="passwordError" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                                        <label>Confirm Password</label>
                                        <span id="confirmPasswordError" class="text-danger"></span>
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

        document.getElementById("resetPasswordForm").addEventListener("submit", function(event) {
            let isValid = true;

            document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');

            // Validate Password
            let password = document.getElementById("password");
            if (password.value.trim() === "") {
                document.getElementById("passwordError").innerText = "Password is required.";
                isValid = false;
            } else if (password.value.length < 6) {
                document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
                isValid = false;
            }

            // Validate Confirm Password
            let confirmPassword = document.getElementById("confirmPassword");
            if (confirmPassword.value.trim() === "") {
                document.getElementById("confirmPasswordError").innerText = "Confirm Password is required.";
                isValid = false;
            } else if (password.value !== confirmPassword.value) {
                document.getElementById("confirmPasswordError").innerText = "Passwords do not match.";
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
@endpush
