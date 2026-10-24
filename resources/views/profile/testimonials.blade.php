@extends('components.layouts.app')

@section('title', 'Testimonials Management')

@section('css')
<style>
    button.btn.btn-sm.btn-brand-dark.edit-testimonial {
        background-color: #EB2371;
        color: #fff;
        border: 1px solid #EB2371;
    }
    button.btn.btn-sm.btn-brand-dark.delete-testimonial {
        background-color: #ab0749;
        color: #fff;
        border: 1px solid #ab0749;
    }
    .star-rating-select {
        color: #f59e0b;
        font-size: 20px;
        cursor: pointer;
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
                        <div class="frames-main d-flex justify-content-between align-items-center mb-3">
                            <h1 class="h3 mb-0">Customer Reviews &amp; Testimonials</h1>
                            <button class="btn design-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#addTestimonialModal">Add New Testimonial</button>
                        </div>
                        <div class="table-responsive">
                            <table id="testimonialsTable" class="table table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Type</th>
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
        </div>
    </section>

    <!-- Add Testimonial Modal -->
    <div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-labelledby="addTestimonialLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTestimonialLabel">Add Testimonial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('testimonial.store') }}" id="add-testimonial-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="e.g. Sarah K." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Designation / Badge</label>
                                <input type="text" class="form-control" name="designation" placeholder="e.g. Verified Buyer" value="Verified Buyer">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Rating (Stars) <span class="text-danger">*</span></label>
                                <select class="form-select" name="rating" required>
                                    <option value="5" selected>★★★★★ (5 Stars)</option>
                                    <option value="4">★★★★☆ (4 Stars)</option>
                                    <option value="3">★★★☆☆ (3 Stars)</option>
                                    <option value="2">★★☆☆☆ (2 Stars)</option>
                                    <option value="1">★☆☆☆☆ (1 Star)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Display Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="is_featured" required>
                                    <option value="0" selected>Standard Review (Right Column)</option>
                                    <option value="1">Featured Review (Left Big Card)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Review Content <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="review" rows="3" placeholder="Enter customer's review quote..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Customer Avatar Image</label>
                                <input type="file" class="form-control" name="avatar" accept="image/*" onchange="previewImage(event, 'add_avatar_preview')">
                                <div class="mt-2">
                                    <img id="add_avatar_preview" src="#" alt="Avatar Preview" class="img-thumbnail d-none" style="max-width: 80px; max-height: 80px; border-radius: 50%;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Product / Frame Lifestyle Image (For Featured Card)</label>
                                <input type="file" class="form-control" name="product_image" accept="image/*" onchange="previewImage(event, 'add_product_preview')">
                                <div class="mt-2">
                                    <img id="add_product_preview" src="#" alt="Product Preview" class="img-thumbnail d-none" style="max-width: 120px; max-height: 120px; border-radius: 10px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" placeholder="0" value="0">
                            </div>
                        </div>
                        <div class="modal-footer px-0 pb-0 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-brand-dark" style="background:#EB2371; border-color:#EB2371; color:#fff;">Save Testimonial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Testimonial Modal -->
    <div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-labelledby="editTestimonialLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTestimonialLabel">Edit Testimonial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="edit-testimonial-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_testimonial_id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="edit_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Designation / Badge</label>
                                <input type="text" class="form-control" name="designation" id="edit_designation">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Rating (Stars) <span class="text-danger">*</span></label>
                                <select class="form-select" name="rating" id="edit_rating" required>
                                    <option value="5">★★★★★ (5 Stars)</option>
                                    <option value="4">★★★★☆ (4 Stars)</option>
                                    <option value="3">★★★☆☆ (3 Stars)</option>
                                    <option value="2">★★☆☆☆ (2 Stars)</option>
                                    <option value="1">★☆☆☆☆ (1 Star)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Display Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="is_featured" id="edit_is_featured" required>
                                    <option value="0">Standard Review (Right Column)</option>
                                    <option value="1">Featured Review (Left Big Card)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="edit_status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Review Content <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="review" id="edit_review" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Customer Avatar Image</label>
                                <input type="file" class="form-control" name="avatar" accept="image/*" onchange="previewImage(event, 'edit_avatar_preview')">
                                <div class="mt-2">
                                    <img id="edit_avatar_preview" src="#" alt="Avatar Preview" class="img-thumbnail d-none" style="max-width: 80px; max-height: 80px; border-radius: 50%;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Product / Frame Lifestyle Image</label>
                                <input type="file" class="form-control" name="product_image" accept="image/*" onchange="previewImage(event, 'edit_product_preview')">
                                <div class="mt-2">
                                    <img id="edit_product_preview" src="#" alt="Product Preview" class="img-thumbnail d-none" style="max-width: 120px; max-height: 120px; border-radius: 10px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" id="edit_sort_order">
                            </div>
                        </div>
                        <div class="modal-footer px-0 pb-0 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-brand-dark" style="background:#EB2371; border-color:#EB2371; color:#fff;">Update Testimonial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(event, previewId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(previewId);
            output.src = reader.result;
            output.classList.remove('d-none');
        };
        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    $(document).ready(function() {
        var table = $('#testimonialsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('testimonial.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'rating', name: 'rating' },
                { data: 'review', name: 'review' },
                { data: 'is_featured', name: 'is_featured' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Add Testimonial Ajax
        $('#add-testimonial-form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        }).then(() => {
                            $('#addTestimonialModal').modal('hide');
                            $('#add-testimonial-form')[0].reset();
                            $('#add_avatar_preview').addClass('d-none');
                            $('#add_product_preview').addClass('d-none');
                            table.ajax.reload();
                        });
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                    var msg = 'Failed to save testimonial.';
                    if (errors) {
                        msg = Object.values(errors).flat().join('<br>');
                    }
                    Swal.fire({ icon: 'error', title: 'Error', html: msg });
                }
            });
        });

        // Edit Testimonial Click
        $(document).on('click', '.edit-testimonial', function() {
            var id = $(this).data('id');
            var url = "{{ url('/admin/testimonials/edit') }}/" + id;

            $.ajax({
                type: 'GET',
                url: url,
                success: function(res) {
                    if (res.success) {
                        var t = res.testimonial;
                        $('#edit_testimonial_id').val(t.id);
                        $('#edit_name').val(t.name);
                        $('#edit_designation').val(t.designation);
                        $('#edit_rating').val(t.rating);
                        $('#edit_is_featured').val(t.is_featured ? '1' : '0');
                        $('#edit_status').val(t.status ? '1' : '0');
                        $('#edit_review').val(t.review);
                        $('#edit_sort_order').val(t.sort_order);

                        if (res.avatar_url) {
                            $('#edit_avatar_preview').attr('src', res.avatar_url).removeClass('d-none');
                        } else {
                            $('#edit_avatar_preview').addClass('d-none');
                        }

                        if (res.product_image_url) {
                            $('#edit_product_preview').attr('src', res.product_image_url).removeClass('d-none');
                        } else {
                            $('#edit_product_preview').addClass('d-none');
                        }

                        $('#edit-testimonial-form').attr('action', "{{ url('/admin/testimonials/update') }}/" + t.id);
                        $('#editTestimonialModal').modal('show');
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Could not fetch testimonial data.' });
                }
            });
        });

        // Update Testimonial Ajax
        $('#edit-testimonial-form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message,
                        }).then(() => {
                            $('#editTestimonialModal').modal('hide');
                            table.ajax.reload();
                        });
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                    var msg = 'Failed to update testimonial.';
                    if (errors) {
                        msg = Object.values(errors).flat().join('<br>');
                    }
                    Swal.fire({ icon: 'error', title: 'Error', html: msg });
                }
            });
        });

        // Delete Testimonial
        $(document).on('click', '.delete-testimonial', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ab0749',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('testimonial.delete') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('Deleted!', res.message, 'success');
                                table.ajax.reload();
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Could not delete testimonial.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

