// Load images from Local Storage on page load
function loadImagesFromLocalStorage() {
    const storedImages = localStorage.getItem('uploadedImages');
    if (storedImages) {
        const imagesArray = JSON.parse(storedImages);
        // Hide file upload section and show editing section if there is at least one image
        if (imagesArray.length > 0) {
            document.querySelector('.file-uploadSection').style.display = 'none';
            document.querySelector('.FrameDesignSection').style.display = 'block';
            renderSliderImages(imagesArray);
        }
    }
}

// Function to render images into the slider container
function renderSliderImages(imagesArray) {
    const swiperWrapper = document.querySelector('.Images-frame-slider .swiper-wrapper');
    // Clear existing slides
    swiperWrapper.innerHTML = '';

    imagesArray.forEach((imgSrc) => {
        const slide = document.createElement('div');
        slide.classList.add('swiper-slide');

        slide.innerHTML = `
        <div class="box">
          <div class="frame-main-wrap" style="
            padding: 10px;
            border: 10px solid black;
            max-width: 310px;
            margin: auto;
            height: 100%;
            width: 100%;
          ">
            <div class="frameborder">
              <div class="frameinner">
                <img alt="Frame" class="img-fluid" src="${imgSrc}">
              </div>
            </div>
          </div>
        </div>
      `;
        swiperWrapper.appendChild(slide);
    });

    // After rendering all slides, update the main preview with the first image (if available)
    if (imagesArray.length > 0) {
        document.getElementById('uploaded-image').src = imagesArray[0];
    }
}

document.addEventListener('DOMContentLoaded', loadImagesFromLocalStorage);

// Call the function on page load
const uploadPhotoElements = document.querySelectorAll('.upload-photo');

// Loop through each element and attach the event listener
uploadPhotoElements.forEach(element => {
    element.addEventListener('change', function (event) {
        const files = event.target.files;
        if (!files.length) return;

        let validImages = []; // Store valid images after checking blur

        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File',
                    text: 'Only image files are allowed!',
                });
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    if (img.width < 125 || img.height < 112) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Image Too Small',
                            text: 'One of the images must be at least 125px in width and 112px in height.',
                        });
                        return;
                    }

                    // Create an offscreen canvas for processing the image
                    const canvas = document.createElement("canvas");
                    const ctx = canvas.getContext("2d");
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0, img.width, img.height);

                    // Perform blur detection
                    if (!isImageBlurred(canvas)) {
                        validImages.push(e.target.result);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Blurry Image',
                            text: 'One of the images is too blurry. Please upload a clearer image.',
                        });
                    }

                    if (validImages.length === files.length) {
                        const existing = localStorage.getItem('uploadedImages');
                        const existingImages = existing ? JSON.parse(existing) : [];
                        const newImagesArray = existingImages.concat(validImages);

                        localStorage.setItem('uploadedImages', JSON.stringify(newImagesArray));

                        document.querySelector('.file-uploadSection').style.display = 'none';
                        document.querySelector('.FrameDesignSection').style.display = 'block';

                        renderSliderImages(newImagesArray);

                        Swal.fire({
                            icon: 'success',
                            title: 'Upload Successful',
                            text: 'Your images have been uploaded successfully!',
                        });
                    }
                };
            };
            reader.readAsDataURL(file);
        });
    });
});

// Function to check if an image is blurry using the Variance of Laplacian method
function isImageBlurred(canvas) {
    const ctx = canvas.getContext("2d");
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const pixels = imageData.data;

    let grayData = [];
    for (let i = 0; i < pixels.length; i += 4) {
        let gray = pixels[i] * 0.299 + pixels[i + 1] * 0.587 + pixels[i + 2] * 0.114;
        grayData.push(gray);
    }

    let laplacianSum = 0, laplacianSqSum = 0;
    const width = canvas.width;
    for (let y = 1; y < canvas.height - 1; y++) {
        for (let x = 1; x < canvas.width - 1; x++) {
            const idx = y * width + x;
            const laplacian =
                -4 * grayData[idx] +
                grayData[idx - 1] + grayData[idx + 1] +
                grayData[idx - width] + grayData[idx + width];

            laplacianSum += laplacian;
            laplacianSqSum += laplacian * laplacian;
        }
    }

    const variance = laplacianSqSum / (canvas.width * canvas.height);
    const threshold = 100; // Adjust based on required blur sensitivity
    return variance < threshold;
}


// Event listener for removing the images
document.getElementById('remove-image').addEventListener('click', function () {
    // Remove images from Local Storage
    localStorage.removeItem('uploadedImages');

    // Clear slider container
    const swiperWrapper = document.querySelector('.Images-frame-slider .swiper-wrapper');
    swiperWrapper.innerHTML = '';

    // Show file upload section and hide editing section
    document.querySelector('.file-uploadSection').style.display = 'flex';
    document.querySelector('.FrameDesignSection').style.display = 'none';

    // Reset file input value so files can be re-uploaded if needed
    document.getElementById('upload-photo').value = '';
});

var swiper = new Swiper('.Images-frame-slider', {
    // Swiper options...
    on: {
        slideChange: function () {
            const activeSlide = document.querySelector('.swiper-slide-active');
            if (activeSlide) {
                const img = activeSlide.querySelector('img');
                if (img) {
                    document.getElementById('uploaded-image').src = img.src;
                }
            }
        }
    }
});

var swiper = new Swiper(".Images-frame-slider", {
    slidesPerView: 'auto',
    spaceBetween: 10,
    centeredSlides: true,
    clickable: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    on: {
        slideChange: function () {
            updateActiveImage();
        }
    }
});

// Function to update the #uploaded-image based on the active slide
function updateActiveImage() {
    setTimeout(() => {
        const activeSlide = document.querySelector('.swiper-slide-active');
        if (activeSlide) {
            const img = activeSlide.querySelector('img');
            if (img) {
                document.getElementById('uploaded-image').src = img.src;
                $('.swiper-slide-active').find('.frame-main-wrap').trigger('click');
            }
        }
    }, 100);
}

// Initial call to set the image when the page loads
updateActiveImage();

// Add a click listener to the slider wrapper
document.querySelector('.Images-frame-slider .swiper-wrapper').addEventListener('click', function (e) {
    // Find the closest slide element (assumes your slide elements have the class 'swiper-slide')
    const slide = e.target.closest('.swiper-slide');
    if (!slide) return;

    // Remove 'active' class from all slides
    document.querySelectorAll('.Images-frame-slider .swiper-slide').forEach(function (s) {
        s.classList.remove('swiper-slide-active');
    });

    // Add 'active' class to the clicked slide
    slide.classList.add('swiper-slide-active');

    // Update the image source
    const img = slide.querySelector('img');
    if (img) {
        document.getElementById('uploaded-image').src = img.src;
    }
});




const designOptions = document.querySelectorAll('.frame-change.dropdown-item');

// Add click event listener to each item
designOptions.forEach(option => {
    option.addEventListener('click', function () {
        // Retrieve the design class from the data attribute
        const designClass = this.getAttribute('data-design');
        const displayText = this.getAttribute('data-text');

        // Select the container element
        const frameWrap = document.getElementById('frameWrap');

        // Remove existing design classes (you can list all possible ones if more than two exist)
        frameWrap.classList.remove('classic-card-design', 'bold-card-design');

        // Add the selected design class
        frameWrap.classList.add(designClass);

        // Update the text in the element with id "frame-show"
        const frameShow = document.getElementById('frame-show');
        frameShow.textContent = displayText;

        designOptions.forEach(item => item.classList.remove('li-border-color'));

        // Add the highlight class to the clicked item
        this.classList.add('li-border-color');
    });
});


// Function to update the frame's border image
function updateFrameBorderImage(imageUrl) {
    const frameWrap = document.getElementById('frameWrap');
    if (frameWrap) {
        // Set border-image property. Adjust slicing values as necessary.
        frameWrap.style.borderImageSource = `url(${imageUrl})`;
        frameWrap.style.borderImageSlice = '30'; // adjust this value as needed
        frameWrap.style.borderImageRepeat = 'stretch'; // or 'repeat' depending on your design
    }
}

// Attach click event listener to all property list items
document.querySelectorAll('.frame-color').forEach(item => {
    item.addEventListener('click', function () {
        const img_src = this.getAttribute('data-src');
        const color_name = this.getAttribute('data-color');
        // Get the image inside this item
        const img = this.querySelector('img.LeftSidebar');
        if (img && img.src) {
            updateFrameBorderImage(img_src);
            const colorShow = document.getElementById('color-show');
            colorShow.textContent = color_name;
        }
    });
});

// Select all size option list items
const sizeOptions = document.querySelectorAll('.frame-size');

// Add click event listener to each size option
sizeOptions.forEach(option => {
    option.addEventListener('click', function () {

        // Retrieve the width and height values from data attributes
        const width = this.getAttribute('data-width');
        const height = this.getAttribute('data-height');
        const max_width = this.getAttribute('data-max-width');
        const frame_price = this.getAttribute('data-price');
        const frameSizeText = this.querySelector('.propertyName').textContent.trim();

        // Select the frameWrap div
        const frameWrap = document.getElementById('frameWrap');

        // Apply new width and height
        if (frameWrap) {
            frameWrap.style.width = width;
            frameWrap.style.height = height;
            frameWrap.style.maxWidth = max_width;
        }

        // Optional: Highlight selected size option
        sizeOptions.forEach(item => item.classList.remove('selected-size'));
        this.classList.add('selected-size');

        const priceShow = document.getElementById('price-show');
        priceShow.textContent = '₹' + frame_price;

        const sizeShow = document.getElementById('size-show');
        sizeShow.textContent = frameSizeText;
    });
});


// Select all size option list items
const finishOptions = document.querySelectorAll('.frame-finish');

// Add click event listener to each size option
finishOptions.forEach(option => {
    option.addEventListener('click', function () {

        const finish_price = this.getAttribute('data-price');
        const frameFinishText = this.querySelector('.propertyName').textContent.trim();

        // Optional: Highlight selected size option
        // finishOptions.forEach(item => item.classList.remove('selected-size'));
        // this.classList.add('selected-size');

        const priceShow = document.getElementById('price-show');
        priceShow.textContent = '₹' + finish_price;

        const finishShow = document.getElementById('finish-show');
        finishShow.textContent = frameFinishText;
    });
});


// Select all size option list items
const hangOptions = document.querySelectorAll('.frame-hang');

// Add click event listener to each size option
hangOptions.forEach(option => {
    option.addEventListener('click', function () {

        const framehangText = this.querySelector('.propertyName').textContent.trim();

        // Optional: Highlight selected size option
        // hangOptions.forEach(item => item.classList.remove('selected-size'));
        // this.classList.add('selected-size');

        const hangShow = document.getElementById('hang-show');
        hangShow.textContent = framehangText;
    });
});



// crop js
// Start upload preview image
$(document).ready(function () {
    $(".gambar").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
    let $uploadCrop, rawImg;

    function readFile(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                rawImg = e.target.result;
                $('#uploaded-image').attr('src', rawImg); // Set the image preview
                $('#slider-image').attr('src', rawImg); // Set the image preview
                $('#cropImagePop').modal('show');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert("Sorry - your browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 300, // Increased width
            height: 250, // Increased height
        },
        enforceBoundary: false,
        enableExif: true
    });

    $('#cropImagePop').on('shown.bs.modal', function () {
        let src_img = $("#uploaded-image").attr("src");
        $uploadCrop.croppie('bind', {
            url: src_img
        }).then(function () {
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function () {
        readFile(this);
    });

    $('#cropImageBtn').on('click', function () {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: { width: 500, height: 435 }
        }).then(function (resp) {
            $('#uploaded-image').attr('src', resp);
            $('#slider-image').attr('src', resp);
            $('#cropImagePop').modal('hide');
        });
    });

    $('#openCropModal').on('click', function () {
        $('#cropImagePop').modal('show');
    });

    $('#cropImagePop').on('shown.bs.modal', function () {
        $('.LeftSidebar_designTool').addClass('blurred'); // You can add CSS class to blur or hide
    });

    $('#cropImagePop').on('hidden.bs.modal', function () {
        $('.LeftSidebar_designTool').removeClass('blurred'); // Remove when modal is closed
    });

});



// crop js
