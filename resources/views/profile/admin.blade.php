@extends('components.layouts.app')

@section('title', $title)

@section('css')
<style>
    button.btn.btn-sm.btn-primary.edit-user {
        background-color: #ff0168;
        border: 1px solid;
    }
    button.btn.btn-sm.btn-danger.delete-user {
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
                            <h1>{{ $title }} List</h1>

                            <button class="btn custom-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addAdminModal"> Add New</button>
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
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

    <div class="modal fade admin-modal" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminLabel">Add {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('admin.store') }}" id="add-admin" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" placeholder="Name" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="email" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="new-password" required>
                                        {{-- <button type="button" class="position-absolute top-0 end-0 rounded-pill PasswordInput_showButton btn btn-text toggle-password"
                                            style=" top: 92px !important; right: 223px !important; ">
                                            <i class="fa fa-eye"></i>
                                        </button> --}}
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="phone" placeholder="Phone Number" required>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="role" class="form-control" required>
                                            @if(Auth::user()->role == 'super_admin')
                                                <option value="admin">Admin</option>
                                            @endif
                                            <option value="user">User</option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="status" class="form-control" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('status')
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

    <div class="modal fade admin-modal" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminLabel">Edit {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('admin.update', ':id') }}" id="edit-admin" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user_id" id="user_id">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="password" class="form-control" name="password" id="password" autocomplete="new-password" placeholder="Password">
                                        {{-- <button type="button" class="position-absolute top-0 end-0 rounded-pill PasswordInput_showButton btn btn-text toggle-password"
                                            style=" top: 92px !important; right: 223px !important; ">
                                            <i class="fa fa-eye"></i>
                                        </button> --}}
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" required>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="role" class="form-control" id="role" required>
                                            @if(Auth::user()->role == 'super_admin')
                                                <option value="admin">Admin</option>
                                            @endif
                                            <option value="user">User</option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="status" class="form-control" id="status" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('status')
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
            ajax: '{{ route("admin.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#add-admin').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Perform validation manually or let the backend handle it
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        // On success, show a SweetAlert success message and close the modal
                        Swal.fire({
                            icon: 'success',
                            title: 'User Added!',
                            text: 'The user has been added successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addAdminModal').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        // Display error messages without closing the modal
                        for (const field in response.errors) {
                            $(`[name="${field}"]`).next('.text-danger').remove();
                            $(`[name="${field}"]`).after('<span class="text-danger">' + response.errors[field][0] + '</span>');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please fix the errors in the form.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error (if necessary)
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        text: 'There was an issue with the server. Please try again.',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__slow'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    });
                }
            });
        });

         // Open Edit Modal and load data
         $(document).on('click', '.edit-user', function () {
            let userId = $(this).data('id'); // Get the user ID from the button's data-id attribute
            $.ajax({
                url: "{{ url('admin/edit') }}/"+userId, // Adjust your URL
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Fill the modal with user data
                        $('#user_id').val(response.user.id);
                        $('#name').val(response.user.name);
                        $('#email').val(response.user.email);
                        $('#phone').val(response.user.phone);
                        $('#role').val(response.user.role);
                        $('#status').val(response.user.status);

                        // Update the form action URL
                        $('#edit-admin').attr('action', "{{ url('admin/update') }}/" + response.user.id);

                        // Show the modal
                        $('#editAdminModal').modal('show');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not load user data.',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__slow'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    });
                }
            });
        });

        // Submit the edit form
        $('#edit-admin').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    console.log(response.success);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'User Updated!',
                            text: 'The user details have been updated successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editAdminModal').modal('hide');
                                // Optionally, refresh the page or the user list
                            }
                        });
                    } else {
                        // Check for validation errors
                        if (response.errors) {
                            for (const field in response.errors) {
                                $(`[name="${field}"]`).next('.text-danger').remove();
                                $(`[name="${field}"]`).after('<span class="text-danger">' + response.errors[field][0] + '</span>');
                            }
                            // Swal.fire({
                            //     icon: 'error',
                            //     title: 'Oops...',
                            //     text: 'Please fix the errors in the form.',
                            // });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong',
                                text: 'There was an issue with the server. Please try again.',
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__slow'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                }
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        text: 'There was an issue with the server 500. Please try again.',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__slow'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    });
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.delete-user', function() {
            var userId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__slow'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/delete') }}/" + userId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The user has been deleted.',
                                    icon: 'success',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#example').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'There was an issue deleting the user.',
                                    icon: 'error',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an issue deleting the user.',
                                icon: 'error',
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__slow'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut animate__faster'
                                }
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
