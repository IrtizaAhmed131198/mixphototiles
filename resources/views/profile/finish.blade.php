@extends('components.layouts.app')

@section('title', 'Custom Finish')

@section('css')
<style>
    button.btn.btn-sm.btn-primary.edit-finish {
        background-color: #EB2371;
        border: 1px solid;
    }
    button.btn.btn-sm.btn-danger.delete-finish {
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
                            <h1>Finish List</h1>

                            <button class="btn design-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addFinishModal"> Add New</button>
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Label</th>
                                    <th>Price</th>
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

    <div class="modal fade finish-modal" id="addFinishModal" tabindex="-1" aria-labelledby="addFinishLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFinishLabel">Add Finish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('finish.store') }}" id="add-finish" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="label" placeholder="Label" required>
                                        @error('label')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" step="any" class="form-control" name="price" placeholder="Price" autocomplete="price" required>
                                        @error('price')
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
                                    <button class="btn design-btn" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn design-btn filled" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade finish-modal" id="editFinishModal" tabindex="-1" aria-labelledby="editFinishLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFinishLabel">Edit Finish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('finish.update', ':id') }}" id="edit-finish" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" id="id">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="label" id="label" placeholder="Label" required>
                                        @error('label')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" step="any" class="form-control" name="price" id="price" placeholder="Price" required>
                                        @error('price')
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
                                    <button class="btn design-btn" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn design-btn filled" type="submit">Save</button>
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
            ajax: '{{ route("finish.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'label', name: 'label' },
                { data: 'price', name: 'price' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#add-finish').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Create a FormData object from the form
            var form = $(this);
            var formData = new FormData(form[0]); // Create FormData from the form

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                contentType: false, // Prevent jQuery from setting content type
                processData: false, // Prevent jQuery from processing the data
                success: function(response) {
                    if (response.success) {
                        // On success, show a SweetAlert success message and close the modal
                        Swal.fire({
                            icon: 'success',
                            title: 'Finish Added!',
                            text: 'The finish has been added successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addFinishModal').modal('hide');
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
        $(document).on('click', '.edit-finish', function () {
            let finishId = $(this).data('id'); // Get the color ID from the button's data-id attribute
            $.ajax({
                url: "{{ url('finish/edit') }}/" + finishId, // Fetch existing data
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Populate form fields
                        $('#id').val(response.finish.id);
                        $('#label').val(response.finish.label);
                        $('#price').val(response.finish.price);
                        $('#status').val(response.finish.status);

                        // Update the form action URL
                        $('#edit-finish').attr('action', "{{ url('finish/update') }}/" + response.finish.id);

                        // Show the modal
                        $('#editFinishModal').modal('show');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not load finish data.',
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
        $('#edit-finish').on('submit', function(e) {
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
                            title: 'Finish Updated!',
                            text: 'The finish details have been updated successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editFinishModal').modal('hide');
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
                        text: 'There was an issue with the server (500). Please try again.',
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

        $(document).on('click', '.delete-finish', function() {
            var finishId = $(this).data('id');

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
                        url: "{{ url('finish/delete') }}/" + finishId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The finish has been deleted.',
                                    icon: 'success',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                }).then((result) => {
                                    // Since it's just an "OK" alert, we use result.isConfirmed
                                    if (result.isConfirmed) {
                                        $('#example').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'There was an issue deleting the finish.',
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
                                text: 'There was an issue deleting the finish.',
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

    function previewImage(event, previewId) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById(previewId);
            preview.src = reader.result;
            preview.classList.remove('d-none'); // Show the image preview
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
