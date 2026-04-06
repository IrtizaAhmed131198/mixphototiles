@extends('components.layouts.app')

@section('title', 'Custom Sizes')

@section('css')
<style>
    button.btn.btn-sm.btn-primary.edit-sizes {
        background-color: #EB2371;
        border: 1px solid;
    }
    button.btn.btn-sm.btn-danger.delete-sizes {
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
                            <h1>Sizes List</h1>

                            <button class="btn design-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addSizesModal"> Add New</button>
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Label</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Width</th>
                                    <th>Height</th>
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

    <div class="modal fade sizes-modal" id="addSizesModal" tabindex="-1" aria-labelledby="addSizesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSizesLabel">Add Sizes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('size.store') }}" id="add-sizes" method="POST" enctype="multipart/form-data">
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
                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <label for="size_image">Upload Size Image</label>
                                        <input type="file" class="form-control" name="image" id="size_image" accept="image/*" required onchange="previewImage(event, 'size_image_preview')">
                                        @error('size_image') <span class="text-danger">{{ $message }}</span> @enderror
                                        <img id="size_image_preview" src="#" alt="Option Image Preview" class="img-thumbnail mt-2 d-none" style="max-width: 150px;">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="width" placeholder="Width" required>
                                        @error('width')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="height" placeholder="Height" required>
                                        @error('height')
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

    <div class="modal fade sizes-modal" id="editSizesModal" tabindex="-1" aria-labelledby="editSizesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSizesLabel">Edit Sizes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('size.update', ':id') }}" id="edit-sizes" method="POST" enctype="multipart/form-data">
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
                                        <input type="number" step="any" class="form-control" name="price" id="price" placeholder="Price" autocomplete="price" required>
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <label for="size_image">Upload Size Image</label>
                                        <input type="file" class="form-control" name="image" id="size_image" accept="image/*" onchange="previewImage(event, 'edit_size_image_preview')">
                                        @error('size_image') <span class="text-danger">{{ $message }}</span> @enderror
                                        <img id="edit_size_image_preview" src="#" alt="Image Preview" class="img-thumbnail mt-2 d-none" style="max-width: 150px;">
                                        <input type="hidden" name="existing_size_image" id="existing_size_image">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="width" id="width" placeholder="Width" required>
                                        @error('width')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="height" id="height" placeholder="Height" required>
                                        @error('height')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="status" id="status" class="form-control" required>
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
            ajax: '{{ route("size.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'label', name: 'label' },
                { data: 'price', name: 'price' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'width', name: 'width' },
                { data: 'height', name: 'height' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#add-sizes').on('submit', function (e) {
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
                            title: 'Size Added!',
                            text: 'The size has been added successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addSizesModal').modal('hide');
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
        $(document).on('click', '.edit-sizes', function () {
            let sizeId = $(this).data('id'); // Get the color ID from the button's data-id attribute
            $.ajax({
                url: "{{ url('size/edit') }}/" + sizeId, // Fetch existing data
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Populate form fields
                        $('#id').val(response.sizes.id);
                        $('#label').val(response.sizes.label);
                        $('#price').val(response.sizes.price);
                        $('#status').val(response.sizes.status);
                        $('#width').val(response.sizes.width);
                        $('#height').val(response.sizes.height);

                        // Set image values (for preview)
                        if (response.sizes.image) {
                            $('#existing_size_image').val(response.sizes.image);
                            $('#edit_size_image_preview').attr('src', "{{ url('/') }}/" + response.sizes.image).removeClass('d-none');
                        } else {
                            $('#edit_size_image_preview').addClass('d-none');
                        }

                        // Update the form action URL
                        $('#edit-sizes').attr('action', "{{ url('size/update') }}/" + response.sizes.id);

                        // Show the modal
                        $('#editSizesModal').modal('show');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not load size data.',
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
        $('#edit-sizes').on('submit', function(e) {
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
                            title: 'Size Updated!',
                            text: 'The size details have been updated successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__slow'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editSizesModal').modal('hide');
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

        $(document).on('click', '.delete-sizes', function() {
            var sizeId = $(this).data('id');

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
                        url: "{{ url('size/delete') }}/" + sizeId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The size has been deleted.',
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
                                    text: 'There was an issue deleting the size.',
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
                                text: 'There was an issue deleting the size.',
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
