@extends('components.layouts.app')

@section('noindex', true)

@section('title', 'Settings')

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9">
                    <div class="account-information">
                        <h1>Settings</h1>
                        <form id="settingsForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach ($settings as $val)
                                    <div class="col-6 {{ $val->type == 'file' ? 'mb-4' : '' }}">
                                        <div class="form-group label-hover">
                                            @if($val->type == 'file')
                                                <input type="file" class="form-control" id="{{ $val->name }}" name="{{ $val->name }}" title="{{ $val->description }}">
                                                @if($val->value)
                                                    <img src="{{ asset('storage/' . $val->value) }}" width="200px" height="50px">
                                                @endif
                                            @else
                                                <input type="{{ $val->type }}" class="form-control"
                                                       id="{{ $val->name }}" name="{{ $val->name }}"
                                                       value="{{ old($val->name, $val->value) }}"
                                                       title="{{ $val->description }}">
                                            @endif
                                            <label>{{ $val->label }}</label>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="frm-btn">
                                    <button type="submit" class="btn design-btn filled mt-5">Save Changes</button>
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
            $('.form-group input').each(function() {
                if ($(this).val() !== '') {
                    $(this).parent().addClass('active'); // Ensure the label remains active if value is pre-filled
                }
            });

            $('.form-group input').on('focus blur input', function() {
                if ($(this).val() !== '' || $(this).is(':focus')) {
                    $(this).parent().addClass('active');
                } else {
                    $(this).parent().removeClass('active');
                }
            });

            $('.input-toggle-click').click(function() {
                $(this).find('input').prop('checked', true);
            });
        });

    </script>
@endpush
