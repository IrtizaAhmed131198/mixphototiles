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
                            <h1>Frames</h1>

                            <button class="btn custom-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
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
                    <h5 class="modal-title" id="framesLabel">Add Frames</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('frames.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                        <textarea name="description" class="form-control" id="descriptionEditor" placeholder="Description" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" step="0.01" class="form-control" name="price" placeholder="Price" required>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" step="0.01" class="form-control" name="discount" placeholder="Discount">
                                    </div>
                                </div>

                                <!-- Main Image Upload with Preview -->
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="main_image" id="mainImageInput">
                                        <span>Main Thumbnail Frame</span>
                                        <div id="mainImagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="no_coordinates_image" id="noCordImageInput">
                                        <span>No Cordinates Frame</span>
                                        <div id="noCordmagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="coordinates_image" id="cordImageInput">
                                        <span>Cordinates Frame</span>
                                        <div id="cordmagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <!-- Multiple Images Upload with Preview -->
                                {{-- <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="additional_images[]" id="additionalImagesInput" multiple>
                                        <span>Additional Frame (You can select multiple)</span>
                                        <div id="additionalImagesPreview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>
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
                                        <button class="btn custom-btn" type="button">Cancel</button>
                                        <button class="btn custom-btn filled" type="submit">Save Product</button>
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
                    <h5 class="modal-title" id="framesModalLabel">Add Frame</h5>
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
                                        <input type="number" step="0.01" class="form-control" name="price" placeholder="Price" required>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" step="0.01" class="form-control" name="discount" placeholder="Discount">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="main_image" id="mainImageInput">
                                        <span>Main Thumbnail Frame</span>
                                        <div id="editMainImagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="no_coordinates_image" id="noCordImageInput">
                                        <span>No Cordinates Frame</span>
                                        <div id="editNoCordmagePreview" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="file" class="form-control" name="coordinates_image" id="cordImageInput">
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
                                        <button type="button" class="btn custom-btn" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn custom-btn filled" type="submit">Save Product</button>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
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
                    <button class="btn btn-primary mt-3" id="get-selected">Get Selected Rectangles</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    CKEDITOR.replace('descriptionEditor');
    CKEDITOR.replace('descriptionEditor2');
</script>
<script>
    document.getElementById('mainImageInput').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('mainImagePreview');
        previewContainer.innerHTML = ''; // Clear existing preview

        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '150px';
                img.style.cursor = 'pointer';

                // Add remove functionality
                img.onclick = () => {
                    document.getElementById('mainImageInput').value = '';
                    previewContainer.innerHTML = '';
                };

                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('noCordImageInput').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('noCordImagePreview');
        previewContainer.innerHTML = ''; // Clear existing preview

        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '150px';
                img.style.cursor = 'pointer';

                // Add remove functionality
                img.onclick = () => {
                    document.getElementById('noCordImageInput').value = '';
                    previewContainer.innerHTML = '';
                };

                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('cordImageInput').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('cordImagePreview');
        previewContainer.innerHTML = ''; // Clear existing preview

        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '150px';
                img.style.cursor = 'pointer';

                // Add remove functionality
                img.onclick = () => {
                    document.getElementById('cordImageInput').value = '';
                    previewContainer.innerHTML = '';
                };

                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // Preview and Remove for Multiple Images
    // document.getElementById('additionalImagesInput').addEventListener('change', function(event) {
    //     const previewContainer = document.getElementById('additionalImagesPreview');
    //     previewContainer.innerHTML = ''; // Clear existing preview

    //     Array.from(event.target.files).forEach((file, index) => {
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             const imageWrapper = document.createElement('div');
    //             imageWrapper.style.position = 'relative';
    //             imageWrapper.style.display = 'inline-block';

    //             const img = document.createElement('img');
    //             img.src = e.target.result;
    //             img.style.maxWidth = '100px';
    //             img.style.height = '100px';
    //             img.style.objectFit = 'cover';
    //             img.style.border = '1px solid #ddd';

    //             const removeButton = document.createElement('span');
    //             removeButton.innerHTML = '&times;';
    //             removeButton.style.position = 'absolute';
    //             removeButton.style.top = '0';
    //             removeButton.style.right = '0';
    //             removeButton.style.backgroundColor = 'red';
    //             removeButton.style.color = 'white';
    //             removeButton.style.cursor = 'pointer';
    //             removeButton.style.padding = '2px 5px';
    //             removeButton.style.fontSize = '12px';

    //             removeButton.onclick = () => {
    //                 const filesArray = Array.from(document.getElementById('additionalImagesInput').files);
    //                 filesArray.splice(index, 1); // Remove the selected file
    //                 const dataTransfer = new DataTransfer();
    //                 filesArray.forEach(file => dataTransfer.items.add(file));
    //                 document.getElementById('additionalImagesInput').files = dataTransfer.files;
    //                 imageWrapper.remove();
    //             };

    //             imageWrapper.appendChild(img);
    //             imageWrapper.appendChild(removeButton);
    //             previewContainer.appendChild(imageWrapper);
    //         };
    //         reader.readAsDataURL(file);
    //     });
    // });

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
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.edit-frame', function () {
            var productId = $(this).data('id');
            let url = '{{ url("frames") }}/' + productId + '/edit';

            $.get(url, function (data) {
                $('#framesModalLabel').text('Edit Frame');
                $('#product_id').val(data.id);
                $('[name="name"]').val(data.name);
                $('[name="slug"]').val(data.slug);
                $('[name="description"]').text(data.description);
                $('[name="price"]').val(data.price);
                $('[name="discount"]').val(data.discount);
                $('[name="status"]').val(data.status);

                if (data.main_image) {
                    $('#editMainImagePreview').html('<img src="' + data.main_image + '" alt="Main Image" width="100">');
                } else {
                    $('#editMainImagePreview').html('');
                }

                if (data.no_coordinates_image) {
                    $('#editNoCordmagePreview').html('<img src="' + data.no_coordinates_image + '" alt="Main Image" width="100">');
                } else {
                    $('#editNoCordmagePreview').html('');
                }

                if (data.coordinates_image) {
                    $('#editCordmagePreview').html('<img src="' + data.coordinates_image + '" alt="Main Image" width="100">');
                } else {
                    $('#editCordmagePreview').html('');
                }

                if (CKEDITOR.instances['descriptionEditor2']) {
                    CKEDITOR.instances['descriptionEditor2'].setData(data.description);
                }

                // Load additional images preview
                // $('#existingImagesPreview').html('');
                // if (data.additional_images.length > 0) {
                //     data.additional_images.forEach(function (image) {
                //         $('#existingImagesPreview').append(`
                //             <div class="additional-image-item" data-id="${image.id}" style="position: relative;">
                //                 <img src="${image.url}" alt="Additional Image" width="100">
                //                 <button type="button" class="btn btn-sm btn-danger remove-additional-image" data-id="${image.id}" style="position: absolute; top: 0; right: 0;">&times;</button>
                //             </div>
                //         `);
                //     });
                // }

                let editUrl = "{{ url('frames') }}/" + data.id;

                $('#framesForm').attr('action', editUrl);
                $('#formMethod').val('POST'); // Laravel method spoofing

                $('#framesModal').modal('show');
            });
        });


        $(document).on('click', '.remove-additional-image', function () {
            var imageId = $(this).data('id');
            var imageElement = $(this).closest('.additional-image-item');

            Swal.fire({
                title: "Are you sure?",
                text: "This image will be permanently deleted.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
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
                                Swal.fire("Deleted!", response.message, "success");
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error!", "Unable to delete the image.", "error");
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
                confirmButtonText: "Yes, delete it!"
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
                                Swal.fire("Deleted!", response.message, "success");
                                $('#example').DataTable().ajax.reload();  // Reload DataTable after deletion
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function () {
                            Swal.fire("Error!", "Unable to delete the product.", "error");
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
                            canvas.width = img.width;
                            canvas.height = img.height;
                            ctx.drawImage(img, 0, 0, img.width, img.height);
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
                });
                return;
            }

            console.log("Selected Coordinates:", selectedRects); // Debugging

            // Send selected rectangles to the backend
            $.ajax({
                url: "{{ route('frames.post_coordinates') }}", // Adjust route
                type: "GET",
                data: {
                    id: productId,
                    coordinates: JSON.stringify(selectedRects), // Convert to JSON
                    _token: "{{ csrf_token() }}" // Laravel CSRF token for security
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: "Coordinates saved successfully!",
                        confirmButtonColor: "#28a745",
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
