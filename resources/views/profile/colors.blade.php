@extends('components.layouts.app')

@section('title', 'Custom Color')

@section('css')
<style>
    button.btn.btn-sm.btn-primary.edit-color {
        background-color: #ff0168;
        border: 1px solid;
    }
    button.btn.btn-sm.btn-danger.delete-color {
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
                            <h1>Custom Color List</h1>

                            <button class="btn custom-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addColorModal"> Add New</button>
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Option Image</th>
                                    <th>Frame Image</th>
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

    <div class="modal fade color-modal" id="addColorModal" tabindex="-1" aria-labelledby="addColorLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addColorLabel">Add Custom Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('color.store') }}" id="add-color" method="POST" enctype="multipart/form-data">
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
                                        <input type="number" step="any" class="form-control" name="price" placeholder="Price" autocomplete="price" required>
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Option Image Upload with Preview -->
                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <label for="option_img">Upload Option Image</label>
                                        <input type="file" class="form-control" name="option_img" id="option_img" accept="image/*" required onchange="previewImage(event, 'option_img_preview')">
                                        @error('option_img') <span class="text-danger">{{ $message }}</span> @enderror
                                        <img id="option_img_preview" src="#" alt="Option Image Preview" class="img-thumbnail mt-2 d-none" style="max-width: 150px;">
                                    </div>
                                </div>

                                <!-- Frame Image Upload with Preview -->
                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <label for="frame_img">Upload Frame Image</label>
                                        <input type="file" class="form-control" name="frame_img" id="frame_img" accept="image/*" required onchange="previewImage(event, 'frame_img_preview')">
                                        @error('frame_img') <span class="text-danger">{{ $message }}</span> @enderror
                                        <img id="frame_img_preview" src="#" alt="Frame Image Preview" class="img-thumbnail mt-2 d-none" style="max-width: 150px;">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <label for="before_color_code">Pick a Frame Color</label>
                                        <input type="color" class="form-control form-control-color" name="before_color_code" id="before_color_code" value="#000000" title="Choose your color">
                                        @error('before_color_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <label for="after_color_code">Pick a Shadow Color</label>
                                        <input type="color" class="form-control form-control-color" name="after_color_code" id="after_color_code" value="#000000" title="Choose your color">
                                        @error('after_color_code')
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

    <div class="modal fade color-modal" id="editColorModal" tabindex="-1" aria-labelledby="editColorLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editColorLabel">Edit Custom Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('color.update', ':id') }}" id="edit-color" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" id="id">
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
                                        <input type="number" step="any" class="form-control" name="price" id="price" placeholder="Price" required>
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Option Image Upload with Preview -->
                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <label for="option_img">Upload Option Image</label>
                                        <input type="file" class="form-control" name="option_img" id="option_img" accept="image/*" onchange="previewImage(event, 'edit_option_img_preview')">
                                        <img id="edit_option_img_preview" src="#" alt="Option Image Preview" class="img-thumbnail mt-2 d-none" style="max-width: 150px;">
                                        <input type="hidden" name="existing_option_img" id="existing_option_img">
                                    </div>
                                </div>

                                <!-- Frame Image Upload with Preview -->
                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <label for="frame_img">Upload Frame Image</label>
                                        <input type="file" class="form-control" name="frame_img" id="frame_img" accept="image/*" onchange="previewImage(event, 'edit_frame_img_preview')">
                                        <img id="edit_frame_img_preview" src="#" alt="Frame Image Preview" class="img-thumbnail mt-2 d-none" style="max-width: 150px;">
                                        <input type="hidden" name="existing_frame_img" id="existing_frame_img">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <label for="edit_before_color_code">Pick a Frame Color</label>
                                        <input type="color" class="form-control form-control-color" name="before_color_code" id="edit_before_color_code" value="" title="Choose your color">
                                        @error('edit_before_color_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <label for="edit_after_color_code">Pick a Shadow Color</label>
                                        <input type="color" class="form-control form-control-color" name="after_color_code" id="edit_after_color_code" value="" title="Choose your color">
                                        @error('edit_after_color_code')
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
            ajax: '{{ route("color.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'price', name: 'price' },
                { data: 'option_img', name: 'option_img', orderable: false, searchable: false },
                { data: 'frame_img', name: 'frame_img', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#add-color').on('submit', function (e) {
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
                            title: 'Color Added!',
                            text: 'The color has been added successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addColorModal').modal('hide');
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
                                popup: 'animate__animated animate__fadeIn animate__faster'
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
                            popup: 'animate__animated animate__fadeIn animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    });
                }
            });
        });

        // Open Edit Modal and load data
        $(document).on('click', '.edit-color', function () {
            let colorId = $(this).data('id'); // Get the color ID from the button's data-id attribute
            $.ajax({
                url: "{{ url('color/edit') }}/" + colorId, // Fetch existing data
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Populate form fields
                        $('#id').val(response.color.id);
                        $('#name').val(response.color.name);
                        $('#price').val(response.color.price);
                        $('#status').val(response.color.status);

                        // Set color code (new addition)
                        if (response.color.before_color_code) {
                            $('#edit_before_color_code').val(response.color.before_color_code);
                        } else {
                            $('#edit_before_color_code').val('#000000'); // default if not set
                        }

                        if (response.color.after_color_code) {
                            $('#edit_after_color_code').val(response.color.after_color_code);
                        } else {
                            $('#edit_after_color_code').val('#000000'); // default if not set
                        }

                        // Set image values (for preview)
                        if (response.color.option_img) {
                            $('#existing_option_img').val(response.color.option_img);
                            $('#edit_option_img_preview').attr('src', "{{ url('/') }}/" + response.color.option_img).removeClass('d-none');
                        } else {
                            $('#edit_option_img_preview').addClass('d-none');
                        }

                        if (response.color.frame_img) {
                            $('#existing_frame_img').val(response.color.frame_img);
                            $('#edit_frame_img_preview').attr('src', "{{ url('/') }}/" + response.color.frame_img).removeClass('d-none');
                        } else {
                            $('#edit_frame_img_preview').addClass('d-none');
                        }

                        // Update the form action URL
                        $('#edit-color').attr('action', "{{ url('color/update') }}/" + response.color.id);

                        // Show the modal
                        $('#editColorModal').modal('show');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not load color data.',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    });
                }
            });
        });

        // Submit the edit form
        $('#edit-color').on('submit', function(e) {
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
                            title: 'Color Updated!',
                            text: 'The color details have been updated successfully.',
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editColorModal').modal('hide');
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
                                    popup: 'animate__animated animate__fadeIn animate__faster'
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
                            popup: 'animate__animated animate__fadeIn animate__faster'
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

        $(document).on('click', '.delete-color', function() {
            var colorId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('color/delete') }}/" + colorId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The color has been deleted.',
                                    icon: 'success',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__faster'
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
                                    text: 'There was an issue deleting the color.',
                                    icon: 'error',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__faster'
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
                                text: 'There was an issue deleting the color.',
                                icon: 'error',
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn animate__faster'
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
