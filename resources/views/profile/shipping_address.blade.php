@extends('components.layouts.app')

@section('title', 'Shipping Address')

@section('css')
<style>
    button.btn.btn-sm.btn-primary.edit-address {
        background-color: #ff0168;
        border: 1px solid;
    }
    button.btn.btn-sm.btn-danger.delete-address {
        background-color: #ab0749;
    }
</style>
@endsection

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9">
                    <div class="account-information">
                        <div class="frames-main">
                            <h1>Shipping Address List</h1>

                            {{-- <button class="btn custom-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addFinishModal"> Add New</button> --}}
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Pin Code</th>
                                    {{-- <th>Address</th> --}}
                                    <th>State</th>
                                    <th>City</th>
                                    <th>User</th>
                                    <th>Action</th>
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

    <div class="modal fade address-modal" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAddressLabel">Edit Shipping Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('addresses.update', ':id') }}" id="edit-address" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" id="id">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Full Name" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Mobile Number" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="phone" id="phone"
                                            placeholder="Mobile Number" required>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="pin_code" id="pin_code"
                                            placeholder="Pin Code" required>
                                        @error('pin_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <textarea name="address1" class="form-control" id="address1" placeholder="Address Line 1" rows="3" required></textarea>
                                        @error('address1')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <textarea name="address2" class="form-control" id="address2" placeholder="Address Line 2" rows="3"></textarea>
                                        @error('address2')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="state" id="state" class="form-control" required>
                                            <option value="" disabled selected>---Select State---</option>
                                        </select>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="city" id="city"
                                            placeholder="City" required>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="alt_phone" id="alt_phone"
                                            placeholder="Alternative Phone Number">
                                        @error('alt_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="save-btn">
                                    <button class="btn custom-btn" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn custom-btn filled" type="submit">Save</button>
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
     $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("addresses.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'recipient_name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'pin_code', name: 'pin_code' },
                // { data: 'address', name: 'address' },
                { data: 'state', name: 'state' },
                { data: 'city', name: 'city' },
                { data: 'user.name', name: 'user_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Open Edit Modal and load data
        $(document).on('click', '.edit-address', function () {
            let addressId = $(this).data('id'); // Get the color ID from the button's data-id attribute
            $.ajax({
                url: "{{ url('addresses/edit') }}/" + addressId, // Fetch existing data
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Populate form fields
                        $('#id').val(response.address.id);
                        $('#name').val(response.address.recipient_name);
                        $('#email').val(response.address.email);
                        $('#phone').val(response.address.phone);
                        $('#pin_code').val(response.address.pin_code);
                        $('#address1').val(response.address.address_line1);
                        $('#address2').val(response.address.address_line2);
                        $('#state').val(response.address.state);
                        $('#city').val(response.address.city);
                        $('#alt_phone').val(response.address.alt_phone);

                        // Update the form action URL
                        $('#edit-address').attr('action', "{{ url('addresses/update') }}/" + response.address.id);

                        // Show the modal
                        $('#editAddressModal').modal('show');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not load address data.',
                    });
                }
            });
        });

        // Submit the edit form
        $('#edit-address').on('submit', function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false, // Important!
                processData: false, // Important!
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Address Updated!',
                            text: 'The address details have been updated successfully.',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editAddressModal').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        if (response.errors) {
                            for (const field in response.errors) {
                                $(`[name="${field}"]`).next('.text-danger').remove();
                                $(`[name="${field}"]`).after('<span class="text-danger">' + response.errors[field][0] + '</span>');
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong',
                                text: 'There was an issue with the server. Please try again.',
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        text: 'There was an issue with the server (500). Please try again.',
                    });
                }
            });
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.delete-address', function() {
            var addressId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('addresses/delete') }}/" + addressId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The address has been deleted.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#example').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an issue deleting the address.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the address.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        fetch("{{ url('states') }}")
            .then(response => response.json())
            .then(states => {
                const dropdown = document.getElementById('state');
                states.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state;
                    option.textContent = state;
                    dropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching states:', error));
    });
</script>
@endpush
