let item_price = $('#price-show').attr('data-val');
item_price = parseFloat(item_price);

function updateGrandTotal() {
    const config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};
    let grandTotal = 0;

    for (const key in config) {
        if (config.hasOwnProperty(key)) {
            const frameConfig = config[key];
            const sizePrice = parseFloat(frameConfig.size ? frameConfig.size.frame_price : 0) || 0;
            const finishPrice = parseFloat(frameConfig.finish ? frameConfig.finish.finish_price : 0) || 0;
            const ledPrice = parseFloat(frameConfig.led ? frameConfig.led.price : 0) || 0;

            // Total for this frame
            let total = 0;
            if(sizePrice == 0 && finishPrice == 0 && ledPrice == 0){
                total = 399;
            }else{
                // Calculate the total price
                total = sizePrice + finishPrice + ledPrice;
            }
            grandTotal += total;
        }
    }

    // Update the UI with the grand total (make sure you have an element with id "grand-total")
    document.getElementById('grand-total').textContent = '₹' + grandTotal;
}


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

    imagesArray.forEach((imgObj, index) => {
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
                    <img alt="${imgObj.name}" data-val="${imgObj.name}" class="img-fluid" src="${imgObj.url}">
                  </div>
                </div>
              </div>
            </div>
        `;
        swiperWrapper.appendChild(slide);
    });

    // After rendering all slides, update the main preview with the first image (if available)
    if (imagesArray.length > 0) {
        document.getElementById('uploaded-image').src = imagesArray[0].url;
    }
}

document.addEventListener('DOMContentLoaded', loadImagesFromLocalStorage);

function initializeDefaultConfig(imageUrl) {
    let config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};
    if (!config[imageUrl]) {
        // Set your default configuration values as needed.
        config[imageUrl] = {
            design: { designClass: "classic-card-design", displayText: "Classic" },
            color: { img_src: "assets/images/black-frame.png", color_name: "Black", shadowClass: "box-shadow-black" },
            size: { width: "309px", height: "318px", max_width: "500px", frame_price: 0, frameSizeText: '8" X 8"' },
            finish: { finish_price: 0, frameFinishText: "Normal" },
            led: { price: 0, value: "no", framehangText: "No" },
        };
        localStorage.setItem('frameConfigurations', JSON.stringify(config));
        console.log("Default configuration saved for image:", imageUrl, config[imageUrl]);
    }
}

function updateFramePrice(imageUrl) {
    const config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};
    const frameConfig = config[imageUrl];
    if (!frameConfig) return;

    // Get prices from the configuration, defaulting to 0 if not provided
    const sizePrice = parseFloat(frameConfig.size.frame_price) || 0;
    const finishPrice = parseFloat(frameConfig.finish.finish_price) || 0;
    const ledPrice = parseFloat(frameConfig.led.price) || 0;

    let total = 0;
    if(sizePrice == 0 && finishPrice == 0 && ledPrice == 0){
        total = 399;
    }else{
        // Calculate the total price
        total = sizePrice + finishPrice + ledPrice;
    }


    // Update the element with id "price-show"
    document.getElementById('price-show').textContent = '₹' + total;

    updateGrandTotal();
}


function applyFrameConfiguration(imageUrl) {
    console.log(imageUrl);
    const config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};
    const frameConfig = config[imageUrl];
    if (!frameConfig) return; // No configuration saved for this image

    const frameWrap = document.getElementById('frameWrap');

    // Apply design configuration
    if (frameConfig.design) {
        if (frameWrap) {
            // Remove any design classes (add others if needed)
            frameWrap.classList.remove('classic-card-design', 'bold-card-design');
            // Add the configured design class
            frameWrap.classList.add(frameConfig.design.designClass);
        }
        // Update the design display text
        const frameShow = document.getElementById('frame-show');
        if (frameShow) {
            frameShow.textContent = frameConfig.design.displayText;
        }
    }

    // Apply color configuration
    if (frameConfig.color) {
        // Update border image
        updateFrameBorderImage(frameConfig.color.img_src);
        // Update color display
        const colorShow = document.getElementById('color-show');
        if (colorShow) {
            colorShow.textContent = frameConfig.color.color_name;
        }
        if (frameWrap) {
            // Remove existing box-shadow classes (assumes they start with "box-shadow-")
            frameWrap.classList.forEach(cls => {
                if (cls.startsWith('box-shadow-')) {
                    frameWrap.classList.remove(cls);
                }
            });
            if (frameConfig.color.shadowClass) {
                frameWrap.classList.add(frameConfig.color.shadowClass);
            }
        }

        // Now update the price display
        updateFramePrice(imageUrl);
    }

    // Apply size configuration
    if (frameConfig.size) {
        if (frameWrap) {
            frameWrap.style.width = frameConfig.size.width;
            frameWrap.style.height = frameConfig.size.height;
            frameWrap.style.maxWidth = frameConfig.size.max_width;
        }
        const sizeShow = document.getElementById('size-show');
        if (sizeShow) {
            sizeShow.textContent = frameConfig.size.frameSizeText;
        }
        // Optionally update pricing based on size here
    }

    // Apply finish configuration
    if (frameConfig.finish) {
        const finishShow = document.getElementById('finish-show');
        if (finishShow) {
            finishShow.textContent = frameConfig.finish.frameFinishText;
        }
        // Optionally update pricing based on finish here
    }

    // Apply LED configuration
    if (frameConfig.led) {
        const ledShow = document.getElementById('led-show');
        if (ledShow) {
            ledShow.textContent = frameConfig.led.framehangText;
        }
        const liElement = document.getElementById('frame-finish-li');
        if (liElement) {
            liElement.style.display = (frameConfig.led.value === "yes") ? 'none' : 'block';
        }
        // Optionally update pricing based on LED option here
    }
}

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

            // Use an object URL for a short src URL
            const objectURL = URL.createObjectURL(file);
            const img = new Image();
            img.src = objectURL;

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
                    // Generate a new file name using the original file name with date/timestamp
                    const originalName = file.name;
                    const extension = originalName.split('.').pop();
                    const baseName = originalName.substring(0, originalName.lastIndexOf('.'));
                    const timestamp = new Date().toISOString().replace(/[:.-]/g, "");
                    const newFileName = `${baseName}_${timestamp}.${extension}`;

                    validImages.push({
                        name: newFileName,
                        url: objectURL
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Blurry Image',
                        text: 'One of the images is too blurry. Please upload a clearer image.',
                    });
                }

                // Check if all files have been processed
                if (validImages.length === files.length) {
                    const existing = localStorage.getItem('uploadedImages');
                    const existingImages = existing ? JSON.parse(existing) : [];
                    const newImagesArray = existingImages.concat(validImages);

                    localStorage.setItem('uploadedImages', JSON.stringify(newImagesArray));

                    // Initialize default configuration for each newly uploaded image
                    validImages.forEach(imageObj => {
                        initializeDefaultConfig(imageObj.url);
                    });

                    document.querySelector('.file-uploadSection').style.display = 'none';
                    document.querySelector('.FrameDesignSection').style.display = 'block';

                    renderSliderImages(newImagesArray);

                    // Ensure the first slide is marked active
                    const firstSlide = document.querySelector('.Images-frame-slider .swiper-slide');
                    if (firstSlide) {
                        firstSlide.classList.add('swiper-slide-active');
                    }

                    // Update the main preview image to the first image
                    if (newImagesArray.length > 0) {
                        document.getElementById('uploaded-image').src = newImagesArray[0].url;
                    }

                    // Update the price for the active image and the grand total
                    updateFramePrice(newImagesArray[0].url);
                    updateGrandTotal();

                    Swal.fire({
                        icon: 'success',
                        title: 'Upload Successful',
                        text: 'Your images have been uploaded successfully!',
                    });
                }
            };
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
    // Retrieve the stored images array
    const storedImages = localStorage.getItem('uploadedImages');
    if (storedImages) {
        let imagesArray = JSON.parse(storedImages);

        // Find the currently active slide and its image src attribute
        const activeSlide = document.querySelector('.swiper-slide-active');
        if (activeSlide) {
            const activeImg = activeSlide.querySelector('img');
            if (activeImg) {
                const activeSrc = activeImg.src;

                // Use findIndex to locate the image object whose url matches the activeSrc
                const indexToRemove = imagesArray.findIndex(item => item.url === activeSrc);
                if (indexToRemove > -1) {
                    // Remove that image object from the array
                    imagesArray.splice(indexToRemove, 1);

                    // Update localStorage with the new images array
                    localStorage.setItem('uploadedImages', JSON.stringify(imagesArray));

                    // Also remove the saved configuration for this image, if it exists
                    let config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};
                    if (config[activeSrc]) {
                        delete config[activeSrc];
                        localStorage.setItem('frameConfigurations', JSON.stringify(config));
                    }

                    // Re-render the slider with the updated array
                    renderSliderImages(imagesArray);

                    // If no images remain, reload the page
                    if (imagesArray.length === 0) {
                        location.reload();
                        return;
                    } else {
                        // Update the main preview image if images remain
                        document.getElementById('uploaded-image').src = imagesArray[0].url;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Image Removed',
                        text: 'The selected image has been removed.',
                    });

                    // Log the updated configurations to the console
                    console.log("Updated frame configurations:", JSON.parse(localStorage.getItem('frameConfigurations')));
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Not Found',
                        text: 'Active image was not found in storage.',
                    });
                }
            }
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No Active Image',
                text: 'Please select an image before removing.',
            });
        }
    }
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
                const activeSrc = img.src;
                document.getElementById('uploaded-image').src = activeSrc;
                // Apply the stored configuration for this image
                applyFrameConfiguration(activeSrc);
                // Optionally trigger any other events on the active slide if needed
                $('.swiper-slide-active').find('.frame-main-wrap').trigger('click');
            }
        }
    }, 100);
}

// Initial call to set the image when the page loads
updateActiveImage();

// Also, keep your click listener for manual slide selection:
document.querySelector('.Images-frame-slider .swiper-wrapper').addEventListener('click', function (e) {
    const slide = e.target.closest('.swiper-slide');
    if (!slide) return;
    document.querySelectorAll('.Images-frame-slider .swiper-slide').forEach(function (s) {
        s.classList.remove('swiper-slide-active');
    });
    slide.classList.add('swiper-slide-active');
    const img = slide.querySelector('img');
    if (img) {
        document.getElementById('uploaded-image').src = img.src;
        applyFrameConfiguration(img.src);
    }
});




const designOptions = document.querySelectorAll('.frame-change.dropdown-item');

designOptions.forEach(option => {
    option.addEventListener('click', function () {
        // Retrieve the design class and display text from data attributes
        const designClass = this.getAttribute('data-design');
        const displayText = this.getAttribute('data-text');

        // Update the frame design
        const frameWrap = document.getElementById('frameWrap');
        frameWrap.classList.remove('classic-card-design', 'bold-card-design');
        frameWrap.classList.add(designClass);

        // Update the display text for design
        document.getElementById('frame-show').textContent = displayText;

        // Remove highlight from all and add to the clicked option
        designOptions.forEach(item => item.classList.remove('li-border-color'));
        this.classList.add('li-border-color');

        // Save the design selection for the active image
        saveFrameConfig('design', { designClass, displayText });
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
        const shadowClass = this.getAttribute('data-shadow');

        // Update the border image and color display
        const img = this.querySelector('img.LeftSidebar');
        if (img && img.src) {
            updateFrameBorderImage(img_src);
            document.getElementById('color-show').textContent = color_name;
        }

        // Update the shadow class on frameWrap
        const frameWrap = document.getElementById('frameWrap');
        if (frameWrap) {
            frameWrap.classList.forEach(cls => {
                if (cls.startsWith('box-shadow-')) {
                    frameWrap.classList.remove(cls);
                }
            });
            if (shadowClass) {
                frameWrap.classList.add(shadowClass);
            }
        }

        // Save the color selection for the active image
        saveFrameConfig('color', { img_src, color_name, shadowClass });
    });
});


// Select all size option list items
const sizeOptions = document.querySelectorAll('.frame-size');

sizeOptions.forEach(option => {
    option.addEventListener('click', function () {
        const width = this.getAttribute('data-width');
        const height = this.getAttribute('data-height');
        const max_width = this.getAttribute('data-max-width');
        const frame_price = parseFloat(this.getAttribute('data-price'));
        const frameSizeText = this.querySelector('.propertyName').textContent.trim();

        // Update frame dimensions
        const frameWrap = document.getElementById('frameWrap');
        if (frameWrap) {
            frameWrap.style.width = width;
            frameWrap.style.height = height;
            frameWrap.style.maxWidth = max_width;
        }

        // Update selection highlight
        sizeOptions.forEach(item => item.classList.remove('selected-size'));
        this.classList.add('selected-size');

        // Update pricing (assuming 'item_price' is defined globally)
        // const priceShow = document.getElementById('price-show');
        // let final = frame_price + item_price;
        // priceShow.textContent = '₹' + final;
        // updateGrandTotal(final);

        // Update display text for size
        document.getElementById('size-show').textContent = frameSizeText;

        // Save the size selection for the active image
        saveFrameConfig('size', { width, height, max_width, frame_price, frameSizeText });

        const activeImg = document.querySelector('.swiper-slide-active img');
        if (activeImg) {
            updateFramePrice(activeImg.src);
        }
    });
});



// Select all size option list items
const finishOptions = document.querySelectorAll('.frame-finish');

finishOptions.forEach(option => {
    option.addEventListener('click', function () {
        const finish_price = parseFloat(this.getAttribute('data-price'));
        const frameFinishText = this.querySelector('.propertyName').textContent.trim();

        // Update pricing and finish display
        // const priceShow = document.getElementById('price-show');
        // let final = finish_price + item_price;
        // priceShow.textContent = '₹' + final;
        // updateGrandTotal(final);

        document.getElementById('finish-show').textContent = frameFinishText;

        // Save the finish selection for the active image
        saveFrameConfig('finish', { finish_price, frameFinishText });

        const activeImg = document.querySelector('.swiper-slide-active img');
        if (activeImg) {
            updateFramePrice(activeImg.src);
        }
    });
});



// Select all size option list items
const hangOptions = document.querySelectorAll('.frame-led');

hangOptions.forEach(option => {
    option.addEventListener('click', function () {
        const price = parseFloat(this.getAttribute('data-price'));
        const value = this.getAttribute('data-val');
        const framehangText = this.querySelector('.propertyName').textContent.trim();

        // Show or hide related options based on the value
        const liElement = document.getElementById('frame-finish-li');
        liElement.style.display = (value === "yes") ? 'none' : 'block';

        // Update pricing and LED display
        // const priceShow = document.getElementById('price-show');
        // let final = price + item_price;
        // priceShow.textContent = '₹' + final;
        // updateGrandTotal(final);

        document.getElementById('led-show').textContent = framehangText;

        // Save the LED selection for the active image
        saveFrameConfig('led', { price, value, framehangText });

        const activeImg = document.querySelector('.swiper-slide-active img');
        if (activeImg) {
            updateFramePrice(activeImg.src);
        }
    });
});



function saveFrameConfig(key, value) {
    // Retrieve the current configuration object from local storage
    let config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};

    // Get the active swiper image
    const activeSlide = document.querySelector('.swiper-slide-active');
    if (activeSlide) {
        const activeImg = activeSlide.querySelector('img');
        if (activeImg) {
            const activeSrc = activeImg.src;
            // Ensure there is an object for this image
            if (!config[activeSrc]) {
                config[activeSrc] = {};
            }
            // Update the property (e.g., design, color, etc.)
            config[activeSrc][key] = value;

            // Save the updated configuration back to local storage
            localStorage.setItem('frameConfigurations', JSON.stringify(config));

            // Console log the saved configuration
            console.log("Saved frame configurations:", JSON.parse(localStorage.getItem('frameConfigurations')));
        }
    }
}

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
            // Update the preview images with the cropped result
            $('#uploaded-image').attr('src', resp);
            $('#slider-image').attr('src', resp);
            $('#cropImagePop').modal('hide');

            // Initialize a default configuration for the cropped image
            initializeDefaultConfig(resp);

            // Apply the configuration (update frameWrap, price, etc.)
            applyFrameConfiguration(resp);
            updateFramePrice(resp);
            updateGrandTotal();
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


