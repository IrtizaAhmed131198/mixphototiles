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
                        <h1>Reset Password</h1>
                        <form action="">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="password" class="form-control" name="password" required>
                                        <label>Password</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="password" class="form-control" name="confirm-password" required>
                                        <label>Confirm password</label>
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
