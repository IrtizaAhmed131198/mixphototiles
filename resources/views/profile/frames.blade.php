@extends('components.layouts.app')

@section('title', 'Order Summary')

@section('css')
<style>
    #image-container {
        position: relative;
        display: inline-block;
    }
    canvas {
        cursor: crosshair;
        border: 1px solid black;
    }
    .rectangle {
        position: absolute;
        border: 2px dashed red;
        cursor: pointer;
    }
    .rectangle.selected {
        border: 2px solid green;
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
                            <h1>Collections</h1>

                            <button class="btn design-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#frames"> Add New</button>
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Image</th>
                                    <th>Coordinates</th>
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


    <div class="modal fade address-modal" id="frames" tabindex="-1" aria-labelledby="framesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="framesLabel">Add Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('frames.store') }}" id="add-frames" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Validation Error Messages -->
                            @if ($errors->any())
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var modal = new bootstrap.Modal(document.getElementById('frames'));
                                        modal.show();
                                    });
                                </script>
                            @endif
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" placeholder="Name" required value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="slug" placeholder="Slug (Unique)" required value="{{ old('slug') }}">
                                        @error('slug')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <textarea name="description" class="form-control" id="descriptionEditor" placeholder="Description" rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="price" placeholder="Price" required value="{{ old('price') }}">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="discount" placeholder="Discount" value="{{ old('discount') }}">
                                        @error('discount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="frame_note" placeholder="Frame Note (e.g. Each frame @rs485)" value="{{ old('frame_note') }}">
                                        @error('frame_note')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Main Image Upload with Error -->
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="main_image" id="mainImageInput">
                                        <span>Main Thumbnail Frame</span>
                                        <div id="mainImagePreview" style="margin-top: 10px;"></div>
                                        @error('main_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="no_coordinates_image" id="noCordImageInput">
                                        <span>No Coordinates Frame</span>
                                        <div id="noCordmagePreview" style="margin-top: 10px;"></div>
                                        @error('no_coordinates_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="coordinates_image" id="cordImageInput">
                                        <span>Coordinates Frame</span>
                                        <div id="cordmagePreview" style="margin-top: 10px;"></div>
                                        @error('coordinates_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="save-btn">
                                        <button class="btn design-btn" type="button">Cancel</button>
                                        <button class="btn design-btn filled" type="submit">Save Product</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade address-modal" id="framesModal" tabindex="-1" aria-labelledby="framesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="framesModalLabel">Add Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form id="framesForm" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="_method" id="formMethod" value="POST">
                            <input type="hidden" name="product_id" id="product_id">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="name" placeholder="Name" required>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="slug" placeholder="Slug (Unique)" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <textarea name="description" class="form-control" id="descriptionEditor2" placeholder="Description" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="price" placeholder="Price" required>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" class="form-control" name="discount" placeholder="Discount">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group label-hover">
                                        <input type="text" class="form-control" name="frame_note" placeholder="Frame Note (e.g. Each frame @rs485)">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="main_image" id="editMainImageInput">
                                        <span>Main Thumbnail Frame</span>
                                        <div id="editMainImagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="no_coordinates_image" id="editNoCordImageInput">
                                        <span>No Cordinates Frame</span>
                                        <div id="editNoCordmagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="coordinates_image" id="editCordImageInput">
                                        <span>Cordinates Frame</span>
                                        <div id="editCordmagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                {{-- <div class="col-6">
                                    <div class="form-group label-hover">
                                        <label for="additionalImages">Additional Frames (You can select multiple)</label>
                                        <input type="file" class="form-control" name="additional_images[]" id="additionalImagesInput" multiple>
                                        <div id="existingImagesPreview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>
                                    </div>
                                </div> --}}

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="status" class="form-control" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="save-btn">
                                        <button type="button" class="btn design-btn" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn design-btn filled" type="submit">Save Product</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade address-modal" id="coordinates" tabindex="-1" aria-labelledby="coordinatesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered set-coordinates-modal">
            <div class="modal-content" style="height: auto;">
                <div class="modal-header">
                    <h5 class="modal-title" id="coordinatesLabel">Set Coordinates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="image-container">
                        <canvas id="canvas"></canvas>
                    </div>
                    <button class="btn btn-brand-dark mt-3" id="get-selected">Get Selected Rectangles</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script defer src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('descriptionEditor');
    CKEDITOR.replace('descriptionEditor2');
    // tinymce.init({
    //     selector: '#descriptionEditor, #descriptionEditor2', // Target both textareas
    //     plugins: 'code', // Include the source code plugin
    //     toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | code', // Add 'code' button
    // });

    // function setDescriptionEditor2Data(content) {
    //     tinymce.get('descriptionEditor2').setContent(content);
    // }
</script>
<script>
    function setupImagePreview(inputId, previewId) {
        document.getElementById(inputId).addEventListener('change', function(event) {
            const previewContainer = document.getElementById(previewId);
            previewContainer.innerHTML = ''; // Clear existing preview

            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.cursor = 'pointer';

                    // Add remove functionality
                    img.onclick = () => {
                        document.getElementById(inputId).value = '';
                        previewContainer.innerHTML = '';
                    };

                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Initialize the previews for different image inputs
    setupImagePreview('mainImageInput', 'mainImagePreview');
    setupImagePreview('noCordImageInput', 'noCordmagePreview');
    setupImagePreview('cordImageInput', 'cordmagePreview');

    setupImagePreview('editMainImageInput', 'editMainImagePreview');
    setupImagePreview('editNoCordImageInput', 'editNoCordmagePreview');
    setupImagePreview('editCordImageInput', 'editCordmagePreview');


    $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("frames.data") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'price', name: 'price' },
                { data: 'discount', name: 'discount' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'coordinates', name: 'coordinates' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.edit-frame', function () {
            var productId = $(this).data('id');
            let url = '{{ url("frames") }}/' + productId + '/edit';

            $.get(url, function (data) {
                $('#framesModalLabel').text('Edit Collection');
                $('#product_id').val(data.id);
                $('[name="name"]').val(data.name);
                $('[name="slug"]').val(data.slug);
                $('[name="description"]').text(data.description);
                $('[name="price"]').val(data.price);
                $('[name="frame_note"]').val(data.frame_note || '');
                $('[name="discount"]').val(data.discount);
                $('[name="status"]').val(data.status);

                if (data.main_image) {
                    $('#editMainImagePreview').html('<img src="' + data.main_image + '" alt="Main Image" width="100">');
                } else {
                    $('#editMainImagePreview').html('');
                }

                if (data.no_coordinates_image) {
                    $('#editNoCordmagePreview').html('<img src="' + data.no_coordinates_image + '" alt="No Coordinates Image" width="100">');
                } else {
                    $('#editNoCordmagePreview').html('');
                }

                if (data.coordinates_image) {
                    $('#editCordmagePreview').html('<img src="' + data.coordinates_image + '" alt="Coordinates Image" width="100">');
                } else {
                    $('#editCordmagePreview').html('');
                }

                // setDescriptionEditor2Data(data.description);
                if (CKEDITOR.instances['descriptionEditor2']) {
                    CKEDITOR.instances['descriptionEditor2'].setData(data.description);
                }

                let editUrl = "{{ url('frames') }}/" + data.id;
                $('#framesForm').attr('action', editUrl);
                $('#formMethod').val('POST'); // Laravel method spoofing

                $('#framesModal').modal('show');
            });
        });

        // **Validation Before Form Submission**
        $('#framesForm').submit(function (e) {
            let isValid = true;
            $('.error-message').remove(); // Remove previous error messages

            // Validate Name
            if ($('[name="name"]').val().trim() === '') {
                isValid = false;
                $('[name="name"]').after('<span class="error-message text-danger">Name is required</span>');
            }

            // Validate Slug (Only alphanumeric and dashes)
            let slugPattern = /^[a-zA-Z0-9-]+$/;
            // if (!slugPattern.test($('[name="slug"]').val())) {
            //     isValid = false;
            //     $('[name="slug"]').after('<span class="error-message text-danger">Invalid slug format</span>');
            // }

            // Validate Price (Positive number)
            let price = parseFloat($('[name="price"]').val());
            if (isNaN(price) || price <= 0) {
                isValid = false;
                $('[name="price"]').after('<span class="error-message text-danger">Price must be a positive number</span>');
            }

            // Validate Discount (Should not be negative)
            let discount = parseFloat($('[name="discount"]').val());
            if (!isNaN(discount) && discount < 0) {
                isValid = false;
                $('[name="discount"]').after('<span class="error-message text-danger">Discount cannot be negative</span>');
            }

            // Validate Images (Optional but must be valid format if provided)
            let validImageFormats = ['image/jpeg', 'image/png', 'image/webp'];
            function validateImage(input, errorMessage) {
                if (input.files.length > 0 && !validImageFormats.includes(input.files[0].type)) {
                    isValid = false;
                    $(input).after(`<span class="error-message text-danger">${errorMessage}</span>`);
                }
            }

            validateImage($('#editMainImageInput')[0], 'Invalid main image format. Allowed: JPG, PNG, WebP');
            validateImage($('#editNoCordImageInput')[0], 'Invalid no coordinates image format. Allowed: JPG, PNG, WebP');
            validateImage($('#editCordImageInput')[0], 'Invalid coordinates image format. Allowed: JPG, PNG, WebP');

            // If any validation fails, prevent form submission
            if (!isValid) {
                e.preventDefault();
            }
        });


        $('#framesModal').on('hidden.bs.modal', function () {
            $('#add-frames')[0].reset(); // Reset form fields
            $('#editMainImagePreview').html('');
            $('#editNoCordmagePreview').html('');
            $('#editCordmagePreview').html('');

            if (CKEDITOR.instances['descriptionEditor2']) {
                CKEDITOR.instances['descriptionEditor2'].setData('');
            }
            // setDescriptionEditor2Data('');
        });

        $(document).on('click', '.remove-additional-image', function () {
            var imageId = $(this).data('id');
            var imageElement = $(this).closest('.additional-image-item');

            Swal.fire({
                title: "Are you sure?",
                text: "This image will be permanently deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__slow'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("frames") }}/' + imageId + '/delete-image',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                imageElement.remove();  // Remove image from the DOM
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success",
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.message,
                                    icon: "error",
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: "Error!",
                                text: "Unable to delete the image.",
                                icon: "error",
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


        $(document).on('click', '.delete-product', function () {
            var productId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This frame and all associated images will be deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__slow'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("frames") }}/' + productId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success",
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                });
                                $('#example').DataTable().ajax.reload();  // Reload DataTable after deletion
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.message,
                                    icon: "error",
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__slow'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOut animate__faster'
                                    }
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: "Error!",
                                text: "Unable to delete the product.",
                                icon: "error",
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

        let isDrawing = false;
        let startX, startY, currentX, currentY;
        let rectangles = [];
        let img = new Image();
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        let productId;

        // Load image when modal opens
        $(document).on("click", ".set-coordinates", function () {
            productId = $(this).data("id");
            rectangles = [];

            $.ajax({
                url: "{{ route('frames.getProductImage') }}",
                type: "GET",
                data: { id: productId },
                success: function (response) {
                    if (response.success) {
                        img.src = response.image_url;
                        img.onload = function () {
                            const fixedWidth = 746;
                            const fixedHeight = 744;

                            canvas.width = fixedWidth;
                            canvas.height = fixedHeight;

                            ctx.clearRect(0, 0, canvas.width, canvas.height);

                            // Maintain aspect ratio
                            let scale = Math.min(fixedWidth / img.width, fixedHeight / img.height);
                            let newWidth = img.width * scale;
                            let newHeight = img.height * scale;

                            let offsetX = (fixedWidth - newWidth) / 2;
                            let offsetY = (fixedHeight - newHeight) / 2;

                            ctx.drawImage(img, offsetX, offsetY, newWidth, newHeight);
                        };
                    } else {
                        $("#coordinates .modal-body").html('<p class="text-danger">Image not found.</p>');
                    }
                },
                error: function () {
                    $("#coordinates .modal-body").html('<p class="text-danger">Error loading image.</p>');
                }
            });
        });


        // Start Drawing
        canvas.addEventListener("mousedown", function (e) {
            isDrawing = true;
            startX = e.offsetX;
            startY = e.offsetY;
        });

        // Draw Live Rectangle
        canvas.addEventListener("mousemove", function (e) {
            if (!isDrawing) return;

            // Clear and redraw image
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            // Redraw previous rectangles
            rectangles.forEach(rect => {
                ctx.strokeStyle = rect.selected ? "green" : "red";
                ctx.lineWidth = 2;
                ctx.setLineDash([]);
                ctx.strokeRect(rect.x, rect.y, rect.width, rect.height);
            });

            // Draw new rectangle
            currentX = e.offsetX;
            currentY = e.offsetY;
            let width = currentX - startX;
            let height = currentY - startY;
            ctx.strokeStyle = "red";
            ctx.lineWidth = 2;
            ctx.setLineDash([5, 5]); // Dashed outline
            ctx.strokeRect(startX, startY, width, height);
        });

        // Stop drawing and save rectangle
        canvas.addEventListener("mouseup", function (e) {
            if (!isDrawing) return;
            isDrawing = false;

            let width = e.offsetX - startX;
            let height = e.offsetY - startY;

            if (width > 10 && height > 10) {
                let rect = {
                    id: rectangles.length + 1,
                    x: startX,
                    y: startY,
                    width: width,
                    height: height,
                    selected: false
                };
                rectangles.push(rect);
            }

            redrawCanvas();
        });

        // Redraw all rectangles
        function redrawCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            rectangles.forEach(rect => {
                ctx.strokeStyle = rect.selected ? "green" : "red";
                ctx.lineWidth = 2;
                ctx.setLineDash([]);
                ctx.strokeRect(rect.x, rect.y, rect.width, rect.height);
            });
        }

        // Click to select/unselect rectangles
        canvas.addEventListener("click", function (e) {
            let x = e.offsetX;
            let y = e.offsetY;

            rectangles.forEach(rect => {
                if (
                    x >= rect.x &&
                    x <= rect.x + rect.width &&
                    y >= rect.y &&
                    y <= rect.y + rect.height
                ) {
                    rect.selected = !rect.selected;
                }
            });

            redrawCanvas();
        });

        // Get Selected Rectangles
        function getSelectedRectangles() {
            let selectedRects = rectangles.filter(rect => rect.selected);

            if (selectedRects.length === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "No Selection",
                    text: "Please select at least one rectangle!",
                    confirmButtonColor: "#3085d6",
                    showClass: {
                        popup: 'animate__animated animate__fadeIn animate__slow'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut animate__faster'
                    }
                });
                return;
            }

            // ✅ Convert pixels to % relative to canvas size
            const convertedRects = selectedRects.map(r => ({
                id: r.id,
                x: (r.x / canvas.width) * 100,
                y: (r.y / canvas.height) * 100,
                width: (r.width / canvas.width) * 100,
                height: (r.height / canvas.height) * 100
            }));


            console.log("Selected Coordinates:", convertedRects); // Debugging

            // Send selected rectangles to the backend
            $.ajax({
                url: "{{ route('frames.post_coordinates') }}", // Adjust route
                type: "GET",
                data: {
                    id: productId,
                    coordinates: JSON.stringify(convertedRects), // Convert to JSON
                    _token: "{{ csrf_token() }}" // Laravel CSRF token for security
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: "Coordinates saved successfully!",
                        confirmButtonColor: "#28a745",
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__slow'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    }).then(() => {
                        console.log(response);
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Failed to save coordinates. Please try again.",
                        confirmButtonColor: "#d33",
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__slow'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut animate__faster'
                        }
                    });
                    console.error("Error saving coordinates:", xhr.responseText);
                }
            });
        }

        // Event Listener for Button
        document.getElementById("get-selected").addEventListener("click", getSelectedRectangles);
    });
</script>
@endpush
