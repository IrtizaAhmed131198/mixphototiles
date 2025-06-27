@extends('components.layouts.app')

@section('title', $title)

@section('css')
    <style>
        button.btn.btn-sm.btn-primary.edit-contact {
            background-color: #ff0168;
            border: 1px solid;
        }

        button.btn.btn-sm.btn-danger.delete-contact {
            background-color: #ab0749;
        }
    </style>
@endsection

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9 col-md-9 col-12">
                    <div class="account-information admininfo">
                        <div class="frames-main">
                            <h1>{{ $title }} List</h1>

                            {{-- <button class="btn custom-btn" type="button" data-bs-toggle="modal"
                                data-bs-target="#addContactModal"> Add New</button> --}}
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('contact.get') }}', // make sure this route now returns Contact data
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'message', name: 'message' },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // }
                ]
            });
        });
    </script>
@endpush
