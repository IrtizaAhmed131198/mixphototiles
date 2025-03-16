let item_price = $('#price-show').attr('data-val');
item_price = parseFloat(item_price);

let config_url = $('#url').val();
let upload_images_url = $('#upload_images').val();
let delete_images_url = $('#delete_images').val();
let add_to_cart_product = $('#add_to_cart_product').val();
let get_session_images = $('#get_session_images').val();
let upload_image = $('#upload_image').val();
let delete_session_image = $('#delete_session_image').val();
let get_frame_config = $('#get_frame_config').val();
let save_cropped_image = $('#save_cropped_image').val();
let get_grand_total = $('#get_grand_total').val();
let get_all_images = $('#get_all_images').val();
let add_to_cart = $('#add_to_cart').val();
let cart_page = $('#cart_page').val();

let allFrameConfigurations = {}; // This should be populated on each frame load

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const imageName = urlParams.get('image_name');

    if (imageName) {
        // Render single image directly from URL parameter
        const imageUrl = `/${imageName}`;  // Update this path if needed based on your folder structure

        document.querySelector('.file-uploadSection').style.display = 'none';
        document.querySelector('.FrameDesignSection').style.display = 'block';

        const imageObj = {
            file_url: imageUrl,
            filename: imageName,
            crop: 0 // Default, update this if you have crop data elsewhere
        };

        renderSliderImages([imageObj]);

        // Apply all initial functions with this single image object
        applyInitialFrameDesign(imageObj);
        applyInitialFrameColor(imageObj);
        applyInitialFrameSize(imageObj);
        applyInitialFrameFinish(imageObj);
        applyInitialFrameLED(imageObj);
        updateFramePrice(imageObj);

    } else {
        // No image_name, fetch session images instead
        fetchAndRenderSessionImages();
    }
});

function fetchAndRenderSessionImages() {
    fetch(get_session_images)
        .then(response => response.json())
        .then(images => {
            if (images.length > 0) {
                document.querySelector('.file-uploadSection').style.display = 'none';
                document.querySelector('.FrameDesignSection').style.display = 'block';
                renderSliderImages(images);
                applyInitialFrameDesign(images[0]);
                applyInitialFrameColor(images[0]);
                applyInitialFrameSize(images[0]);
                applyInitialFrameFinish(images[0]);
                applyInitialFrameLED(images[0]);
                updateFramePrice(images[0]);

                if (images[0].crop === 1) {
                    // Apply CSS to the inherit-design div
                    const inheritDesignDiv = document.querySelector('#frameWrap .inherit-design');
                    if (inheritDesignDiv) {
                        inheritDesignDiv.style.position = 'absolute';
                        inheritDesignDiv.style.zIndex = '-1';
                        inheritDesignDiv.style.padding = '15px';
                    }
                }
            }else{
                document.querySelector('.file-uploadSection').style.display = 'flex';
                document.querySelector('.FrameDesignSection').style.display = 'none';
            }
        })
        .catch(err => console.error('Failed to load session images:', err));
}

document.addEventListener('DOMContentLoaded', fetchAndRenderSessionImages);

function renderSliderImages(imagesArray) {
    const swiperWrapper = document.querySelector('.Images-frame-slider .swiper-wrapper');
    swiperWrapper.innerHTML = '';

    imagesArray.forEach((imageObj) => {
        const imgSrc = imageObj.file_url;

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
                            <img alt="Frame" class="img-fluid" src="${imgSrc}" data-frame-config='${imageObj.filename}'>
                        </div>
                    </div>
                </div>
            </div>
        `;

        swiperWrapper.appendChild(slide);
    });

    if (imagesArray.length > 0) {
        document.getElementById('uploaded-image').src = imagesArray[0].file_url;
        let set_active_config = JSON.stringify(imagesArray[0]);
        document.getElementById('active_config').value = set_active_config;
    }
}

function applyInitialFrameDesign(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) {
        return; // No frame configuration found
    }

    const frameConfig = JSON.parse(imageObj.frame_configuration);

    const initialDesignClass = frameConfig.design?.designClass || 'classic-card-design';
    const initialDisplayText = frameConfig.design?.displayText || 'Classic';

    // Update frame-show text
    document.getElementById('frame-show').textContent = initialDisplayText;

    const designOptions = document.querySelectorAll('.frame-change.dropdown-item');

    designOptions.forEach(item => {
        item.classList.remove('li-border-color');

        const itemDesignClass = item.getAttribute('data-design');
        if (itemDesignClass === initialDesignClass) {
            item.classList.add('li-border-color');
        }
    });

    const frameWrap = document.querySelector('.frame-main-wrap-main');
    if (!frameWrap) return;

    // Clear existing design and shadow classes
    frameWrap.classList.forEach(cls => {
        if (cls.endsWith('-design')) {
            frameWrap.classList.remove(cls);
        }
    });

    // Apply new design and shadow class
    frameWrap.classList.add(initialDesignClass);
}

function applyInitialFrameColor(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) {
        return; // No frame configuration found
    }

    const frameConfig = JSON.parse(imageObj.frame_configuration);

    const initialColor = frameConfig.color || {
        img_src: "assets/images/black-frame.png",
        color_name: "Black",
        shadowClass: "box-shadow-black"
    };

    // Update frame-show text (color name instead of design name)
    const frameShow = document.getElementById('frame-show');
    if (frameShow) {
        frameShow.textContent = initialColor.color_name;
    }

    const frameWrap = document.getElementById('frameWrap'); // Using frameWrap directly
    if (!frameWrap) return;

    // Clear existing shadow class
    frameWrap.classList.forEach(cls => {
        if (cls.startsWith('box-shadow-')) {
            frameWrap.classList.remove(cls);
        }
    });

    // Apply new shadow class
    if (initialColor.shadowClass) {
        frameWrap.classList.add(initialColor.shadowClass);
    }

    // Apply the frame border image using the existing function
    updateFrameBorderImage(initialColor.img_src);
}

function applyInitialFrameSize(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) {
        return; // No frame configuration found
    }

    const frameConfig = JSON.parse(imageObj.frame_configuration);

    const initialSize = frameConfig.size || {
        width: "309px",
        height: "318px",
        max_width: "500px",
        frame_price: 0,
        frameSizeText: '8" X 8"'
    };

    const frameWrap = document.getElementById('frameWrap'); // Ensure your frame container has this ID
    if (!frameWrap) return;

    // Apply size styles
    frameWrap.style.width = initialSize.width;
    frameWrap.style.height = initialSize.height;
    frameWrap.style.maxWidth = initialSize.max_width;

    // Optionally display the size text somewhere
    const frameSizeShow = document.getElementById('frame-size-show'); // Make sure you have an element for this
    if (frameSizeShow) {
        frameSizeShow.textContent = initialSize.frameSizeText;
    }

    // (Optional) If you want to log or display price somewhere
    const framePriceShow = document.getElementById('frame-price-show'); // Optional price display
    if (framePriceShow) {
        framePriceShow.textContent = initialSize.frame_price > 0 ? `$${initialSize.frame_price}` : 'Free';
    }
}

function applyInitialFrameFinish(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) {
        return; // No frame configuration found
    }

    const frameConfig = JSON.parse(imageObj.frame_configuration);

    const initialFinish = frameConfig.finish || {
        finish_price: 0,
        frameFinishText: 'Normal'
    };

    console.log()

    // Update finish text display
    const frameFinishShow = document.getElementById('finish-show');
    if (frameFinishShow) {
        frameFinishShow.textContent = initialFinish.frameFinishText;
    }

    // Optionally show finish price if needed
    // const frameFinishPriceShow = document.getElementById('frame-finish-price-show');
    // if (frameFinishPriceShow) {
    //     frameFinishPriceShow.textContent = initialFinish.finish_price > 0 ? `$${initialFinish.finish_price}` : 'Free';
    // }
}

function applyInitialFrameLED(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) {
        return; // No frame configuration found
    }

    const frameConfig = JSON.parse(imageObj.frame_configuration);

    const initialLED = frameConfig.led || {
        price: 0,
        value: "no",
        framehangText: "No"
    };

    // Update LED display text
    const frameLEDShow = document.getElementById('frame-led-show');
    if (frameLEDShow) {
        frameLEDShow.textContent = initialLED.framehangText;
    }

    // Optionally update LED price if needed
    // const frameLEDPriceShow = document.getElementById('frame-led-price-show');
    // if (frameLEDPriceShow) {
    //     frameLEDPriceShow.textContent = initialLED.price > 0 ? `$${initialLED.price}` : 'Free';
    // }

    // Enable/disable the "frame-finish-li" button based on LED value (yes/no)
    const liElement = document.getElementById('frame-finish-li');
    if (liElement) {
        const buttonElement = liElement.querySelector('button');
        if (buttonElement) {
            if (initialLED.value === "yes") {
                buttonElement.disabled = true;
            } else {
                buttonElement.disabled = false;
            }
        }
    }
}


function getDefaultFrameConfig() {
    return {
        design: { designClass: "classic-card-design", displayText: "Classic", design_price: 0 },
        color: { img_src: "assets/images/black-frame.png", color_name: "Black", shadowClass: "box-shadow-black", color_price: 0 },
        size: { width: "309px", height: "318px", max_width: "500px", frame_price: 0, frameSizeText: '8" X 8"' },
        finish: { finish_price: 0, frameFinishText: "Normal" },
        led: { price: 0, value: "no", framehangText: "No" },
    };
}

function updateGrandTotal() {
    fetch(get_grand_total) // Update this to match your route
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let grandTotal = 0;

                data.data.forEach(sessionImage => {
                    const frameConfig = sessionImage.frame_configuration;

                    const designPrice = parseFloat(frameConfig?.design?.design_price) || 0;
                    const colorPrice = parseFloat(frameConfig?.color?.color_price) || 0;
                    const sizePrice = parseFloat(frameConfig?.size?.frame_price) || 0;
                    const finishPrice = parseFloat(frameConfig?.finish?.finish_price) || 0;
                    const ledPrice = parseFloat(frameConfig?.led?.price) || 0;

                    let total = 0;

                    if (designPrice === 0 && colorPrice === 0 && sizePrice === 0 && finishPrice === 0 && ledPrice === 0) {
                        total = 399; // Default price when all options are free
                    } else {
                        total = designPrice + colorPrice + sizePrice + finishPrice + ledPrice;
                    }

                    grandTotal += total;
                });

                // Update the grand total in UI
                document.getElementById('grand-total').textContent = '₹' + grandTotal;
            } else {
                console.error('Failed to fetch frame configurations');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}


function updateFramePrice(frameConfig) {
    if (!frameConfig) return;
    let frame_config = JSON.parse(frameConfig.frame_configuration);

    // Get prices directly from the frame configuration
    const designPrice = parseFloat(frame_config.design?.design_price) || 0;
    const colorPrice = parseFloat(frame_config.color?.color_price) || 0;
    const sizePrice = parseFloat(frame_config.size?.frame_price) || 0;
    const finishPrice = parseFloat(frame_config.finish?.finish_price) || 0;
    const ledPrice = parseFloat(frame_config.led?.price) || 0;

    let total = 0;

    if (designPrice === 0 && colorPrice === 0 && sizePrice === 0 && finishPrice === 0 && ledPrice === 0) {
        total = 399; // Default price when all options are free
    } else {
        total = designPrice + colorPrice + sizePrice + finishPrice + ledPrice;
    }

    // Update the price on the UI
    document.getElementById('price-show').textContent = '₹' + total;

    // Optionally update the grand total if you are tracking all frames (for multiple frames setup)
    updateGrandTotal();
}


// Call the function on page load
const uploadPhotoElements = document.querySelectorAll('.upload-photo');

// Loop through each element and attach the event listener
uploadPhotoElements.forEach(element => {
    element.addEventListener('change', function (event) {
        processAndUploadImages(event.target.files);
    });
});

function uploadImageToServer(file, newFileName) {
    const formData = new FormData();
    formData.append('image', file, newFileName);

    const defaultConfig = getDefaultFrameConfig();
    formData.append('frame_configuration', JSON.stringify(defaultConfig));

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    return fetch(upload_image, {   // Laravel route
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            return {
                name: newFileName,
                url: data.file_url
            };
        } else {
            throw new Error('Image upload failed');
        }
    });
}

async function processAndUploadImages(files) {
    const uploadPromises = [];

    for (const file of files) {
        if (!file.type.startsWith('image/')) {
            await Swal.fire('Invalid File', 'Only image files are allowed!', 'error');
            continue;
        }

        const objectURL = URL.createObjectURL(file);
        const img = new Image();
        img.src = objectURL;

        // Use a promise to wait for the image to load
        await new Promise((resolve, reject) => {
            img.onload = resolve;
            img.onerror = reject;
        });

        if (img.width < 1500 || img.height < 1500) {
            await Swal.fire('Image Too Small', 'Your Image Quality is Low', 'warning');
            continue;
        }

        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0, img.width, img.height);

        if (!isImageBlurred(canvas)) {
            const originalName = file.name;
            const extension = originalName.split('.').pop();
            const baseName = originalName.substring(0, originalName.lastIndexOf('.'));
            const timestamp = new Date().toISOString().replace(/[:.-]/g, "");
            const newFileName = `${baseName}_${timestamp}.${extension}`;

            uploadPromises.push(uploadImageToServer(file, newFileName));
        } else {
            await Swal.fire('Blurry Image', 'Please upload a clearer image.', 'warning');
        }
    }

    // Now wait for all uploads to finish
    try {
        const images = await Promise.all(uploadPromises);

        if (images.length > 0) {
            document.querySelector('.file-uploadSection').style.display = 'none';
            document.querySelector('.FrameDesignSection').style.display = 'block';

            fetchAndRenderSessionImages();

            await Swal.fire('Upload Successful', 'Your images have been uploaded successfully!', 'success');
        }
    } catch (err) {
        console.error('Image upload failed', err);
        await Swal.fire('Upload Failed', 'There was a problem uploading images', 'error');
    }
}


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


async function deleteImageFromDatabase(imageName) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const response = await fetch(delete_session_image, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ image_name: imageName })
        });

        const result = await response.json();

        if (result.success) {
            // Successfully deleted, now refresh the session images
            await fetchAndRenderSessionImages();
            Swal.fire('Deleted', 'Image has been deleted successfully', 'success');
        } else {
            throw new Error(result.message || 'Failed to delete image');
        }
    } catch (error) {
        console.error('Error deleting image:', error);
        Swal.fire('Delete Failed', error.message || 'Failed to delete image', 'error');
    }
}

// Example: Hooking into a button click to trigger deletion
document.getElementById('remove-image').addEventListener('click', async function () {
    const activeSlide = document.querySelector('.swiper-slide-active');

    if (activeSlide) {
        const imgElement = activeSlide.querySelector('img');
        if (imgElement) {
            const imageSrc = imgElement.getAttribute('src');
            const imageName = imageSrc.split('/').pop(); // Extract filename from src

            // Confirm before deleting
            const confirmDelete = await Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this image?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            });

            if (confirmDelete.isConfirmed) {
                await deleteImageFromDatabase(imageName);
            }
        }
    } else {
        Swal.fire('No Image Selected', 'Please select an image to delete.', 'warning');
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

                // Fetch and apply frame configuration
                const filename = img.getAttribute('data-frame-config') || '';
                if (filename) {
                    fetch(get_frame_config, {
                        method: 'POST',
                        body: JSON.stringify({ filename: filename }),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Apply all initial frame configurations here
                            applyInitialFrameDesign(data.frame_configuration);
                            applyInitialFrameColor(data.frame_configuration);
                            applyInitialFrameSize(data.frame_configuration);
                            applyInitialFrameFinish(data.frame_configuration);
                            applyInitialFrameLED(data.frame_configuration);
                            updateFramePrice(data.frame_configuration);

                            if (data.frame_configuration.crop === 1) {
                                const inheritDesignDiv = document.querySelector('#frameWrap .inherit-design');
                                if (inheritDesignDiv) {
                                    inheritDesignDiv.style.position = 'absolute';
                                    inheritDesignDiv.style.zIndex = '-1';
                                    inheritDesignDiv.style.padding = '15px';
                                }
                            } else {
                                // Optionally reset styles if crop is not 1 (in case user switches images)
                                const inheritDesignDiv = document.querySelector('#frameWrap .inherit-design');
                                if (inheritDesignDiv) {
                                    inheritDesignDiv.style.position = '';
                                    inheritDesignDiv.style.zIndex = '';
                                    inheritDesignDiv.style.padding = '';
                                }
                            }

                        } else {
                            console.error('Failed to fetch frame configuration:', data.message);
                        }
                    })
                    .catch(err => console.error('Error fetching frame configuration:', err));
                }
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
        // applyFrameConfiguration(img.src);
        const filename = img.getAttribute('data-frame-config') || '';
        if(filename){
            fetch(get_frame_config, {
                method: 'POST',
                body: JSON.stringify({ filename: filename }),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'  // <- This is MISSING in your code
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    applyInitialFrameDesign(data.frame_configuration);
                    applyInitialFrameColor(data.frame_configuration);
                    applyInitialFrameSize(data.frame_configuration);
                    applyInitialFrameFinish(data.frame_configuration);
                    applyInitialFrameLED(data.frame_configuration);
                    updateFramePrice(data.frame_configuration);

                    if (data.frame_configuration.crop === 1) {
                        const inheritDesignDiv = document.querySelector('#frameWrap .inherit-design');
                        if (inheritDesignDiv) {
                            inheritDesignDiv.style.position = 'absolute';
                            inheritDesignDiv.style.zIndex = '-1';
                            inheritDesignDiv.style.padding = '15px';
                        }
                    } else {
                        // Optionally reset styles if crop is not 1 (in case user switches images)
                        const inheritDesignDiv = document.querySelector('#frameWrap .inherit-design');
                        if (inheritDesignDiv) {
                            inheritDesignDiv.style.position = '';
                            inheritDesignDiv.style.zIndex = '';
                            inheritDesignDiv.style.padding = '';
                        }
                    }

                } else {
                    console.error('Failed to fetch frame configuration:', data.message);
                }
            })
            .catch(err => console.error('Error fetching frame configuration:', err));

        }
    }
});




const designOptions = document.querySelectorAll('.frame-change.dropdown-item');

designOptions.forEach(option => {
    option.addEventListener('click', function () {
        const designClass = this.getAttribute('data-design');
        const displayText = this.getAttribute('data-text');
        const design_price = this.getAttribute('data-price');

        // Apply design change visually
        const frameWrap = document.getElementById('frameWrap');
        frameWrap.classList.remove('classic-card-design', 'bold-card-design');
        frameWrap.classList.add(designClass);

        document.getElementById('frame-show').textContent = displayText;

        designOptions.forEach(item => item.classList.remove('li-border-color'));
        this.classList.add('li-border-color');

        let get_active_config = JSON.parse($('#active_config').val());
        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.design.design_price = design_price;

        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $('#active_config').val(JSON.stringify(get_active_config));

        // Save the selected design into the session_images table for the active image
        saveFrameConfigToDatabase({
            designClass: designClass,
            displayText: displayText,
            design_price: design_price
        }, 'design');

        setTimeout(() => {
            updateFramePrice(get_active_config);
        }, 500);
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

const colorOptions = document.querySelectorAll('.frame-color.dropdown-item');

// Attach click event listener to all property list items
document.querySelectorAll('.frame-color').forEach(item => {
    item.addEventListener('click', function () {
        const img_src = this.getAttribute('data-src');
        const color_name = this.getAttribute('data-color');
        const shadowClass = this.getAttribute('data-shadow');
        const color_price = this.getAttribute('data-price');

        colorOptions.forEach(item => item.classList.remove('li-border-color'));
        this.classList.add('li-border-color');

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

        let get_active_config = JSON.parse($('#active_config').val());

        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.color.color_price = color_price;

        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $('#active_config').val(JSON.stringify(get_active_config));

        // Save the color selection for the active image
        saveFrameConfigToDatabase({
            img_src: img_src,
            color_name: color_name,
            shadowClass: shadowClass,
            color_price: color_price
        }, 'color');

        setTimeout(() => {
            updateFramePrice(get_active_config);
        }, 500);
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
        sizeOptions.forEach(item => item.classList.remove('li-border-color'));
        this.classList.add('li-border-color');

        // Update display text for size
        document.getElementById('size-show').textContent = frameSizeText;

        let get_active_config = JSON.parse($('#active_config').val());

        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.size.frame_price = frame_price;

        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $('#active_config').val(JSON.stringify(get_active_config));

        // Save the size selection for the active image
        saveFrameConfigToDatabase({
            width: width,
            height: height,
            max_width: max_width,
            frame_price: frame_price,
            frameSizeText: frameSizeText,
        }, 'size');

        setTimeout(() => {
            updateFramePrice(get_active_config);
        }, 500);
    });
});



// Select all size option list items
const finishOptions = document.querySelectorAll('.frame-finish');

finishOptions.forEach(option => {
    option.addEventListener('click', function () {
        const finish_price = parseFloat(this.getAttribute('data-price'));
        const frameFinishText = this.querySelector('.propertyName').textContent.trim();

        finishOptions.forEach(item => item.classList.remove('li-border-color'));
        this.classList.add('li-border-color');

        document.getElementById('finish-show').textContent = frameFinishText;

        let get_active_config = JSON.parse($('#active_config').val());

        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.finish.finish_price = finish_price;

        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $('#active_config').val(JSON.stringify(get_active_config));

        // Save the finish selection for the active image
        saveFrameConfigToDatabase({
            finish_price: finish_price,
            frameFinishText: frameFinishText
        }, 'finish');

        setTimeout(() => {
            updateFramePrice(get_active_config);
        }, 500);

    });
});



// Select all size option list items
const hangOptions = document.querySelectorAll('.frame-led');

hangOptions.forEach(option => {
    option.addEventListener('click', function () {
        const price = parseFloat(this.getAttribute('data-price'));
        const value = this.getAttribute('data-val');
        const framehangText = this.querySelector('.propertyName').textContent.trim();

        const liElement = document.getElementById('frame-finish-li');
        const buttonElement = liElement.querySelector('button'); // Assuming there's a button inside liElement

        if (value === "yes") {
            buttonElement.disabled = true;
        } else {
            buttonElement.disabled = false;
        }

        hangOptions.forEach(item => item.classList.remove('li-border-color'));
        this.classList.add('li-border-color');

        document.getElementById('led-show').textContent = framehangText;

        let get_active_config = JSON.parse($('#active_config').val());

        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.led.price = price;

        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $('#active_config').val(JSON.stringify(get_active_config));


        // Save the LED selection for the active image
        saveFrameConfigToDatabase({
            price: price,
            value: value,
            framehangText: framehangText
        }, 'led');

        setTimeout(() => {
            updateFramePrice(get_active_config);
        }, 500);
    });
});



// function saveFrameConfig(key, value) {
//     // Retrieve the current configuration object from local storage
//     let config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};

//     // Get the active swiper image
//     const activeSlide = document.querySelector('.swiper-slide-active');
//     if (activeSlide) {
//         const activeImg = activeSlide.querySelector('img');
//         if (activeImg) {
//             const activeSrc = activeImg.src;
//             // Ensure there is an object for this image
//             if (!config[activeSrc]) {
//                 config[activeSrc] = {};
//             }
//             // Update the property (e.g., design, color, etc.)
//             config[activeSrc][key] = value;

//             // Save the updated configuration back to local storage
//             localStorage.setItem('frameConfigurations', JSON.stringify(config));

//             // Console log the saved configuration
//             console.log("Saved frame configurations:", JSON.parse(localStorage.getItem('frameConfigurations')));

//             // Now save the configuration in the database
//             saveFrameConfigInDB(activeSrc);
//         }
//     }
// }

function saveFrameConfigToDatabase(frameConfig, type) {
    const activeSlide = document.querySelector('.swiper-slide-active');

    if (activeSlide) {
        const activeImg = activeSlide.querySelector('img');
        if (activeImg) {
            const activeSrc = activeImg.getAttribute('src'); // Example: "uploads/image.jpg"
            const imageName = activeSrc.split('/').pop();    // Just the file name (image.jpg)

            sendFrameConfigToServer(imageName, frameConfig, type);
        }
    }
}

async function sendFrameConfigToServer(imageName, frameConfig, type) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const response = await fetch(config_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            image_name: imageName,
            frame_config: frameConfig,
            type : type
        })
    });

    const result = await response.json();
    if (result.success) {
        console.log("Frame configuration saved to database for", imageName);
        document.getElementById('active_config').value = JSON.stringify(result.data);
    } else {
        console.error("Failed to save frame configuration:", result.message);
    }
}

function saveFrameConfigInDB(imageUrl) {
    const config = JSON.parse(localStorage.getItem('frameConfigurations')) || {};
    const frameConfig = config[imageUrl];
    if (!frameConfig) return;

    // Convert the blob URL to a Base64 Data URL.
    // This is necessary because blob URLs are not accessible by the server.
    fetch(imageUrl)
        .then(response => response.blob())
        .then(blob => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve(reader.result);
            reader.onerror = reject;
            reader.readAsDataURL(blob);
        }))
        .then(base64DataUrl => {
            // Now base64DataUrl is a string like "data:image/jpeg;base64,/9j/4AAQSk..."
            // Prepare FormData to send to the server.
            const formData = new FormData();
            formData.append('image', base64DataUrl); // Send the Base64 data URL.
            formData.append('config', JSON.stringify(frameConfig));

            fetch(config_url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    console.log("Configuration saved to database successfully");
                } else {
                    console.error("Error saving configuration to DB", data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        })
        .catch(error => console.error("Error converting blob URL to base64:", error));
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
            let imgElement = document.querySelector('.swiper-slide-active img');
            let filename = imgElement.getAttribute('data-frame-config');
            $('#uploaded-image').attr('src', resp);
            $('#slider-image').attr('src', resp);
            saveCroppedImageToServer(resp, filename);
            $('#cropImagePop').modal('hide');

        });
    });

    function saveCroppedImageToServer(base64Image, filename) {
        $.ajax({
            url: save_cropped_image, // Update with your backend URL
            type: 'POST',
            data: {
                cropped_image: base64Image,
                filename: filename,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Crop Image',
                        text: 'Image saved successfully!'
                    });
                    $('#frameWrap #uploaded-image').attr('src', response.file_url); // Update preview with saved image URL

                    $('#frameWrap .inherit-design').css({
                        'position': 'absolute',
                        'z-index': '-1',
                        'padding': '15px'
                    });

                    let imgElement = document.querySelector('.swiper-slide-active img');
                    if (imgElement) {
                        imgElement.src = response.file_url; // Replace with your new image path
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Crop Image',
                        text: 'Failed to save image.'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    $('#openCropModal').on('click', function () {
        let imgSrc = $('#frameWrap #uploaded-image').attr('src');

        $uploadCrop.croppie('bind', {
            url: imgSrc
        }).then(function () {
            console.log('Image loaded into croppie');
        });

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

document.getElementById('add-to-cart').addEventListener('click', function() {
    fetch(get_all_images) // Adjust URL if needed
        .then(response => response.json())
        .then(response => {
            if (!response.success) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'No images found.'
                });
                return;
            }

            // Call add_to_cart_product after getting all images
            fetch(add_to_cart, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(responseData => {
                if (responseData.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart',
                        text: responseData.message
                    }).then(() => {
                        // Redirect to cart page after success message
                        window.location.href = cart_page; // Update URL as needed
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: responseData.message || 'An error occurred.'
                    });
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add products to cart.'
                });
            });
        })
        .catch(error => {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to get images.'
            });
        });
});
