let item_price = parseFloat($("#item_price").val()) || 0;

let config_url = $("#url").val();
let upload_images_url = $("#upload_images").val();
let delete_images_url = $("#delete_images").val();
let add_to_cart_product = $("#add_to_cart_product").val();
let get_session_images = $("#get_session_images").val();
let upload_image = $("#upload_image").val();
let delete_session_image = $("#delete_session_image").val();
let get_frame_config = $("#get_frame_config").val();
let save_cropped_image = $("#save_cropped_image").val();
let get_grand_total = $("#get_grand_total").val();
let get_all_images = $("#get_all_images").val();
let add_to_cart = $("#add_to_cart").val();
let cart_page = $("#cart_page").val();
let reset_cropped_image = $("#reset_cropped_image").val();
let getFrameDefaults = $("#getFrameDefaults").val();
let delivery_cost = parseFloat($("#delivery_cost").val()) || 0;
let average_cost  = parseFloat($("#average_cost").val())  || 0;
let base_margin   = parseFloat($("#base_margin").val())   || 0;

// ============================================================
// NEW PRICING CONSTANTS (from Pricing_Calculator_final.pdf)
// ============================================================
const FLOOR_PRICE = parseFloat($("#floor_price").val()) || 599;
const D_STEP      = (parseFloat($("#d_step").val()) || 5)  / 100;  // convert % to decimal
const D_MAX       = (parseFloat($("#d_max").val())  || 20) / 100;  // convert % to decimal

/**
 * NEW Bundle Pricing Formula
 *
 * BundleTotal = MAX(
 *     N × F,
 *     Subtotal × (1 − MIN(Dmax, Dstep × (N − 1)))
 * )
 *
 * @param {number} subtotal  - sum of individual frame prices
 * @param {number} n         - total number of frames
 * @returns {object}         - { bundleTotal, perFrame, saving, discount }
 */
function calculateBundlePrice(subtotal, n) {
    if (n <= 0 || subtotal <= 0) {
        return { bundleTotal: 0, perFrame: 0, saving: 0, discount: 0 };
    }

    if (n === 1) {
        // Single frame — show price directly, no discount
        return {
            bundleTotal: subtotal,
            perFrame: subtotal,
            saving: 0,
            discount: 0
        };
    }

    // Step 1: calculate discount
    const discount    = Math.min(D_MAX, D_STEP * (n - 1));

    // Step 2: apply discount to subtotal
    const discounted  = subtotal * (1 - discount);

    // Step 3: floor check — never go below FLOOR_PRICE × N
    const floorCheck  = n * FLOOR_PRICE;

    // Step 4: final bundle total
    const bundleTotal = Math.max(floorCheck, discounted);

    const perFrame = Math.round(bundleTotal / n);
    const saving   = Math.round(subtotal - bundleTotal);

    return { bundleTotal, perFrame, saving, discount };
}

let allFrameConfigurations = {};

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const imageName = urlParams.get("image_name");

    if (imageName) {
        const imageUrl = `/${imageName}`;

        document.querySelector(".file-uploadSection").style.display = "none";
        document.querySelector(".FrameDesignSection").style.display = "block";

        const imageObj = {
            file_url: imageUrl,
            filename: imageName,
            crop: 0,
        };

        renderSliderImages([imageObj]);
        applyInitialFrameDesign(imageObj);
        applyInitialFrameColor(imageObj);
        applyInitialFrameSize(imageObj);
        applyInitialFrameFinish(imageObj);
        applyInitialFrameLED(imageObj);
        updateFramePrice(imageObj);
    } else {
        fetchAndRenderSessionImages();
    }
});

function fetchAndRenderSessionImages() {
    fetch(get_session_images)
        .then((response) => response.json())
        .then((images) => {
            if (images.length > 0) {
                renderSliderImages(images);
                applyInitialFrameDesign(images[0]);
                applyInitialFrameColor(images[0]);
                applyInitialFrameSize(images[0]);
                applyInitialFrameFinish(images[0]);
                applyInitialFrameLED(images[0]);
                updateFramePrice(images[0]);
            } else {
                document.querySelector(".file-uploadSection").style.display = "flex";
                document.querySelector(".FrameDesignSection").style.display = "none";
            }
        })
        .catch((err) => console.error("Failed to load session images:", err));
}

document.addEventListener("DOMContentLoaded", fetchAndRenderSessionImages);

function renderSliderImages(imagesArray) {
    const swiperWrapper = document.querySelector(".Images-frame-slider .swiper-wrapper");
    swiperWrapper.innerHTML = "";

    imagesArray.forEach((imageObj) => {
        const imgSrc = imageObj.file_url;
        const slide = document.createElement("div");
        slide.classList.add("swiper-slide");

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
        document.getElementById("uploaded-image").src = imagesArray[0].file_url;
        let set_active_config = JSON.stringify(imagesArray[0]);
        document.getElementById("active_config").value = set_active_config;
    }
}

function applyInitialFrameDesign(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) return;

    const frameConfig = JSON.parse(imageObj.frame_configuration);
    const initialDesignClass = frameConfig.design?.designClass || "classic-card-design";
    const initialDisplayText = frameConfig.design?.displayText || "Border";

    document.getElementById("frame-show").textContent = initialDisplayText;

    const designOptions = document.querySelectorAll(".frame-change.dropdown-item");
    designOptions.forEach((item) => {
        item.classList.remove("li-border-color");
        if (item.getAttribute("data-design") === initialDesignClass) {
            item.classList.add("li-border-color");
        }
    });

    const frameWrap = document.querySelector(".frame-main-wrap-main");
    if (!frameWrap) return;

    frameWrap.classList.forEach((cls) => {
        if (cls.endsWith("-design")) frameWrap.classList.remove(cls);
    });
    frameWrap.classList.add(initialDesignClass);

    const frameWrapChild = document.getElementById("frameWrapChild");
    if (initialDesignClass === "frameless-card-design") {
        frameWrapChild.classList.remove("no-border-design");
        frameWrapChild.classList.add("frameless-design");
    } else if (initialDesignClass === "bold-card-design") {
        frameWrapChild.classList.remove("frameless-design");
        frameWrapChild.classList.add("no-border-design");
    } else {
        frameWrapChild.classList.remove("frameless-design");
        frameWrapChild.classList.remove("no-border-design");
    }

    const colorOptionsTemp = document.querySelectorAll(".frame-color");
    if (initialDesignClass === "frameless-card-design") {
        colorOptionsTemp.forEach((colorOption, index) => {
            colorOption.style.display = index === 0 ? "flex" : "none";
        });
    } else {
        colorOptionsTemp.forEach((colorOption) => { colorOption.style.display = "flex"; });
    }

    const sizeOptionsTemp = document.querySelectorAll(".frame-size");
    if (initialDesignClass === "frameless-card-design") {
        sizeOptionsTemp.forEach((sizeOption) => {
            const sizeText = sizeOption.querySelector(".propertyName").textContent.trim();
            sizeOption.style.display = sizeText === '8" X 8"' ? "flex" : "none";
        });
    } else {
        sizeOptionsTemp.forEach((sizeOption) => { sizeOption.style.display = "flex"; });
    }
}

function applyInitialFrameColor(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) return;

    const frameConfig = JSON.parse(imageObj.frame_configuration);
    const colorText = frameConfig.color?.color_name || "Black";
    const initialColor = frameConfig.color || {
        img_src: "assets/images/black-frame.png",
        color_name: "Black",
        shadowClass: "box-shadow-black",
    };

    document.querySelectorAll(".frame-color.dropdown-item").forEach((item) => {
        item.classList.remove("li-border-color");
        if (item.getAttribute("data-color") === colorText) item.classList.add("li-border-color");
    });

    const frameShow = document.getElementById("color-show");
    if (frameShow) frameShow.textContent = initialColor.color_name;

    const frameWrap = document.getElementById("frameWrap");
    if (!frameWrap) return;

    frameWrap.classList.forEach((cls) => {
        if (cls.startsWith("box-shadow-")) frameWrap.classList.remove(cls);
    });
    if (initialColor.shadowClass) frameWrap.classList.add(initialColor.shadowClass);

    updateFrameBorderImage(initialColor.img_src);
}

function applyInitialFrameSize(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) return;

    const frameConfig = JSON.parse(imageObj.frame_configuration);
    const initialSize = frameConfig.size || {
        width: "309px", height: "318px", max_width: "500px",
        frame_price: 0, frameSizeText: '8" X 8"',
    };
    const sizeText = frameConfig.size?.frameSizeText || '8" X 8"';

    document.querySelectorAll(".frame-size.dropdown-item").forEach((item) => {
        item.classList.remove("li-border-color");
        if (item.getAttribute("data-val") === sizeText) item.classList.add("li-border-color");
    });

    const frameWrap = document.getElementById("frameWrap");
    if (frameWrap) {
        frameWrap.style.width    = initialSize.width;
        frameWrap.style.height   = initialSize.height;
        frameWrap.style.maxWidth = initialSize.max_width;
    }

    const frameBox = document.querySelector(".frame-box");
    if (frameBox) {
        frameBox.style.width  = initialSize.width;
        frameBox.style.height = initialSize.height;
    }

    const frameSizeShow = document.getElementById("size-show");
    if (frameSizeShow) frameSizeShow.textContent = initialSize.frameSizeText;
}

function applyInitialFrameFinish(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) return;

    const frameConfig   = JSON.parse(imageObj.frame_configuration);
    const initialFinish = frameConfig.finish || { finish_price: 0, frameFinishText: "Normal" };
    const finishText    = frameConfig.finish?.frameFinishText || "no";

    document.querySelectorAll(".frame-finish.dropdown-item").forEach((item) => {
        item.classList.remove("li-border-color");
        if (item.getAttribute("data-val") === finishText) item.classList.add("li-border-color");
    });

    const frameFinishShow = document.getElementById("finish-show");
    if (frameFinishShow) frameFinishShow.textContent = initialFinish.frameFinishText;
}

function applyInitialFrameLED(imageObj) {
    if (!imageObj || !imageObj.frame_configuration) return;

    const frameConfig = JSON.parse(imageObj.frame_configuration);
    const initialLED  = frameConfig.led || { price: 0, value: "no", framehangText: "No" };

    const frameLEDShow = document.getElementById("frame-led-show");
    if (frameLEDShow) frameLEDShow.textContent = initialLED.framehangText;

    const liElement = document.getElementById("frame-finish-li");
    if (liElement) {
        const buttonElement = liElement.querySelector("button");
        if (buttonElement) {
            buttonElement.disabled = initialLED.value === "yes";
        }
    }
}

function getDefaultFrameConfig() {
    return fetch(getFrameDefaults)
        .then((response) => response.json())
        .then((data) => {
            return {
                design: {
                    designClass:  data.design.designClass,
                    displayText:  data.design.displayText,
                    design_price: Number(data.design.design_price) || 0,
                },
                color: {
                    img_src:     data.color.img_src,
                    color_name:  data.color.color_name,
                    shadowClass: data.color.shadowClass,
                    color_price: Number(data.color.color_price) || 0,
                },
                size: {
                    width:         data.size.width + "px",
                    height:        data.size.height + "px",
                    max_width:     data.size.max_width,
                    frame_price:   Number(data.size.frame_price) || 0,
                    frameSizeText: data.size.frameSizeText,
                },
                finish: {
                    finish_price:    Number(data.finish.finish_price) || 0,
                    frameFinishText: data.finish.frameFinishText,
                },
                led: {
                    price:        Number(data.led.price) || 0,
                    value:        data.led.value.toLowerCase(),
                    framehangText: data.led.framehangText,
                },
            };
        })
        .catch((error) => {
            console.error("Failed to load frame defaults:", error);
            return {};
        });
}

// ============================================================
// UPDATED updateGrandTotal — uses new bundle pricing formula
// ============================================================
function updateGrandTotal() {
    fetch(get_grand_total)
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const sessionImages = data.data;
                const n = sessionImages.length; // total number of frames

                // Build subtotal: sum of each frame's individual price
                let subtotal = 0;
                sessionImages.forEach((sessionImage) => {
                    const frameConfig  = sessionImage.frame_configuration;
                    const sizePrice    = parseFloat(frameConfig?.size?.frame_price) || 0;
                    const finishPrice  = parseFloat(frameConfig?.finish?.finish_price) || 0;
                    const ledPrice     = parseFloat(frameConfig?.led?.price) || 0;

                    // Per-frame price: use size price as base (client requirement)
                    // finish & led are addons on top of size price
                    const frameUnitPrice = sizePrice > 0
                        ? sizePrice + finishPrice + ledPrice
                        : item_price + finishPrice + ledPrice;

                    subtotal += frameUnitPrice;
                });

                // Apply new bundle formula
                // console.log(subtotal, n);
                const result = calculateBundlePrice(subtotal, n);

                // Update quantity hidden input
                document.getElementById("quantity").value = n;

                // Update per-frame price display
                // console.log(result.perFrame);
                document.getElementById("price-show").textContent = "₹" + result.perFrame;
                document.getElementById("price-show").setAttribute("data-val", result.perFrame);
                // console.log("2nd frame price updated to: ₹" + result.perFrame);

                // Update grand total display
                const grandTotal = Math.round(result.bundleTotal + delivery_cost);
                document.getElementById("grand-total-1").textContent = "₹" + grandTotal;
                document.getElementById("grand-total-2").textContent = "₹" + grandTotal;
                document.getElementById("grand-total-1").setAttribute("data-val", grandTotal);
                document.getElementById("grand-total-2").setAttribute("data-val", grandTotal);
                // Bundle total
                document.getElementById("bundle-total-1").textContent = "₹" + Math.round(result.bundleTotal);
                document.getElementById("bundle-total-2").textContent = "₹" + Math.round(result.bundleTotal);

                // Show saving message if applicable
                updateSavingMessage(result.saving, result.discount);

                // console.log("=== Bundle Pricing ===");
                // console.log("N (frames)    :", n);
                // console.log("Subtotal      : ₹" + subtotal);
                // console.log("Discount      :", (result.discount * 100).toFixed(0) + "%");
                // console.log("Bundle Total  : ₹" + result.bundleTotal);
                // console.log("Delivery      : ₹" + delivery_cost);
                // console.log("Grand Total   : ₹" + grandTotal);
                // console.log("Saving        : ₹" + result.saving);
                // console.log("======================");

            } else {
                console.error("Failed to fetch frame configurations");
            }
        })
        .catch((error) => console.error("Error fetching data:", error));
}

/**
 * Show saving message on the UI if user is saving money
 */
function updateSavingMessage(saving) {
    document.querySelectorAll(".saving-message").forEach((el) => {
        if (saving > 0) {
            el.textContent = "You are saving ₹" + Math.round(saving) + " on this order!";
            el.style.display = "block";
        } else {
            el.style.display = "none";
        }
    });
}

// ============================================================
// UPDATED updateFramePrice — uses size price as base (1 frame)
// ============================================================
function updateFramePrice(frameConfig) {
    if (!frameConfig) return;

    let frame_config = JSON.parse(frameConfig.frame_configuration);

    const sizePrice   = parseFloat(frame_config.size?.frame_price)     || 0;
    const finishPrice = parseFloat(frame_config.finish?.finish_price)   || 0;
    const ledPrice    = parseFloat(frame_config.led?.price)             || 0;
    // Use size price as base; fallback to item_price if size not set
    let unitPrice = sizePrice > 0
        ? sizePrice + finishPrice + ledPrice
        : item_price + finishPrice + ledPrice;

    unitPrice = parseFloat(Math.round(unitPrice));

    // console.log(unitPrice);
    document.getElementById("price-show").textContent = "₹" + unitPrice;
    document.getElementById("price-show").setAttribute("data-val", unitPrice);
    // console.log("1st frame price updated to: ₹" + unitPrice);

    updateGrandTotal();
}

// ============================================================
// The old calculateFrameCost is kept but NO LONGER USED
// for pricing. It remains only if needed elsewhere.
// ============================================================
function calculateFrameCost_legacy(quantity = 1) {
    let frame_cost     = quantity * average_cost;
    let profit_margin  = (base_margin / Math.pow(quantity, 0.2)) / 100;
    let profit_per_sale = Math.floor(frame_cost * profit_margin);
    let selling_price  = Math.floor(frame_cost + profit_per_sale) + delivery_cost;
    return selling_price;
}

// ============================================================
// Everything below is unchanged from original
// ============================================================

const uploadPhotoElements = document.querySelectorAll(".upload-photo");
uploadPhotoElements.forEach((element) => {
    element.addEventListener("change", function (event) {
        const mainLoader = document.querySelector(".loadermain");
        if (mainLoader) mainLoader.style.display = "flex";
        setTimeout(async () => {
            await processAndUploadImages(event.target.files, mainLoader);
        }, 50);
    });
});

function uploadImageToServer(file, newFileName) {
    return getDefaultFrameConfig().then((defaultConfig) => {
        const formData = new FormData();
        formData.append("image", file, newFileName);
        formData.append("frame_configuration", JSON.stringify(defaultConfig));

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        return fetch(upload_image, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrfToken },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    return { name: newFileName, url: data.file_url };
                } else {
                    throw new Error("Image upload failed");
                }
            });
    });
}

async function processAndUploadImages(files, mainLoader) {
    const uploadPromises = [];
    const uploadInput = document.querySelector(".upload-photo");
    const progressBarContainer = document.querySelector(".progress-bar-container");
    const progressBar = document.querySelector(".progress-bar");

    uploadInput.disabled = true;
    progressBarContainer.style.display = "block";
    progressBar.style.width = "0%";

    let uploadedCount = 0;

    for (const file of files) {
        if (!file.type.startsWith("image/")) {
            await Swal.fire({
                title: "Invalid File", text: "Only image files are allowed!", icon: "error",
                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
            });
            continue;
        }

        const originalName = file.name;
        const extension = originalName.split(".").pop();
        const baseName = originalName.substring(0, originalName.lastIndexOf("."));
        const timestamp = new Date().toISOString().replace(/[:.-]/g, "");
        const newFileName = `${baseName}_${timestamp}.${extension}`;

        uploadPromises.push(
            uploadImageToServer(file, newFileName).then(() => {
                uploadedCount++;
                progressBar.style.width = `${(uploadedCount / files.length) * 100}%`;
            })
        );
    }

    try {
        await Promise.all(uploadPromises);
        if (uploadPromises.length > 0) {
            progressBar.style.width = "100%";
            document.querySelector(".file-uploadSection").style.display = "none";
            document.querySelector(".FrameDesignSection").style.display = "block";
            fetchAndRenderSessionImages();

            setTimeout(() => {
                progressBarContainer.style.display = "none";
                uploadInput.disabled = false;
            }, 500);

            if (mainLoader) mainLoader.style.display = "none";

            await Swal.fire({
                title: "Upload Successful", text: "Your images have been uploaded successfully!", icon: "success",
                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
            });
        }
    } catch (err) {
        console.error("Image upload failed", err);
        await Swal.fire({
            title: "Upload Failed", text: "There was a problem uploading images", icon: "error",
            showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
            hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
        });
        progressBarContainer.style.display = "none";
        uploadInput.disabled = false;
    }
}

function isImageBlurred(canvas) {
    // Create a temporary canvas for downscaling
    const tempCanvas = document.createElement("canvas");
    const tempCtx = tempCanvas.getContext("2d");

    // Downscale the image to a maximum dimension of 400px (keeps aspect ratio)
    const maxDimension = 400;
    let width = canvas.width;
    let height = canvas.height;

    if (width > maxDimension || height > maxDimension) {
        if (width > height) {
            height = Math.round((height * maxDimension) / width);
            width = maxDimension;
        } else {
            width = Math.round((width * maxDimension) / height);
            height = maxDimension;
        }
    }

    tempCanvas.width = width;
    tempCanvas.height = height;
    tempCtx.drawImage(canvas, 0, 0, width, height);

    const imageData = tempCtx.getImageData(0, 0, width, height);
    const pixels = imageData.data;

    let grayData = [];
    for (let i = 0; i < pixels.length; i += 4) {
        let gray = pixels[i] * 0.299 + pixels[i + 1] * 0.587 + pixels[i + 2] * 0.114;
        grayData.push(gray);
    }

    let laplacianSqSum = 0;
    for (let y = 1; y < height - 1; y++) {
        for (let x = 1; x < width - 1; x++) {
            const idx = y * width + x;
            const laplacian = -4 * grayData[idx] + grayData[idx - 1] + grayData[idx + 1] + grayData[idx - width] + grayData[idx + width];
            laplacianSqSum += laplacian * laplacian;
        }
    }

    const variance = laplacianSqSum / (width * height);
    return variance < 100;
}

document.getElementById("remove-image").addEventListener("click", async function () {
    const activeSlide = document.querySelector(".swiper-slide-active");
    const removeButton = document.getElementById("remove-image");
    const uploadInput = document.querySelector(".upload-photo");
    const progressBarContainer = document.querySelector(".progress-bar-container");
    const progressBar = document.querySelector(".progress-bar");

    if (activeSlide) {
        const imgElement = activeSlide.querySelector("img");
        if (imgElement) {
            const imageSrc = imgElement.getAttribute("src");
            const imageNameWithExt = imageSrc.split("/").pop();
            const imageName = imageNameWithExt.split(".").slice(0, -1).join(".");

            const confirmDelete = await Swal.fire({
                title: "Are you sure?", text: "Do you want to delete this image?", icon: "warning",
                showCancelButton: true, confirmButtonText: "Yes, delete it!", cancelButtonText: "Cancel",
                customClass: { confirmButton: "swal-image-confirm-button", cancelButton: "swal-image-cancel-button" },
                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
            });

            if (confirmDelete.isConfirmed) {
                const totalSlides = document.querySelectorAll(".swiper-slide img").length;
                removeButton.disabled = true;
                uploadInput.disabled = true;
                progressBarContainer.style.display = "block";
                progressBar.style.width = "0%";

                await deleteImageFromDatabase(imageName, imageSrc);

                progressBar.style.width = "100%";
                setTimeout(() => {
                    progressBarContainer.style.display = "none";
                    removeButton.disabled = false;
                    uploadInput.disabled = false;
                    if (totalSlides === 1) location.reload();
                }, 500);
            }
        }
    } else {
        await Swal.fire({
            title: "No Image Selected", text: "Please select an image to delete.", icon: "warning",
            showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
            hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
        });
    }
});

async function deleteImageFromDatabase(imageName, imageSrc) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    try {
        const response = await fetch(delete_session_image, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify({ image_name: imageName, image_src: imageSrc }),
        });

        const result = await response.json();

        if (result.success) {
            await fetchAndRenderSessionImages();
            await Swal.fire({
                title: "Deleted", text: "Image has been deleted successfully", icon: "success",
                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
            });
        } else {
            throw new Error(result.message || "Failed to delete image");
        }
    } catch (error) {
        console.error("Error deleting image:", error);
        await Swal.fire({
            title: "Delete Failed", text: error.message || "Failed to delete image", icon: "error",
            showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
            hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
        });
    }
}

document.getElementById("reset-image").addEventListener("click", async function () {
    const activeSlide = document.querySelector(".swiper-slide-active");
    const resetButton = document.getElementById("reset-image");
    const uploadInput = document.querySelector(".upload-photo");
    const progressBarContainer = document.querySelector(".progress-bar-container");
    const progressBar = document.querySelector(".progress-bar");

    if (activeSlide) {
        const imgElement = activeSlide.querySelector("img");
        if (imgElement) {
            const filename = imgElement.getAttribute("data-frame-config");

            const confirmReset = await Swal.fire({
                title: "Reset Image?", text: "This will remove cropping and restore the original image.",
                icon: "question", showCancelButton: true,
                confirmButtonText: "Yes, reset it!", cancelButtonText: "Cancel",
                customClass: { confirmButton: "swal-image-confirm-button", cancelButton: "swal-image-cancel-button" },
                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
            });

            if (confirmReset.isConfirmed) {
                const totalSlides = document.querySelectorAll(".swiper-slide img").length;
                resetButton.disabled = true;
                uploadInput.disabled = true;
                progressBarContainer.style.display = "block";
                progressBar.style.width = "0%";

                await resetImageToOriginal(filename);

                progressBar.style.width = "100%";
                setTimeout(() => {
                    progressBarContainer.style.display = "none";
                    resetButton.disabled = false;
                    uploadInput.disabled = false;
                    if (totalSlides === 1) location.reload();
                }, 500);
            }
        }
    } else {
        await Swal.fire({
            title: "No Image Selected", text: "Please select an image to reset.", icon: "warning",
            showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
            hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
        });
    }
});

async function resetImageToOriginal(filename) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    try {
        const response = await fetch(reset_cropped_image, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify({ filename: filename }),
        });

        const result = await response.json();

        if (result.success) {
            await fetchAndRenderSessionImages();
            await Swal.fire({
                title: "Reset Successful", text: "Image has been restored to original.", icon: "success",
                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
            });
        } else {
            throw new Error(result.message || "Reset failed");
        }
    } catch (error) {
        console.error("Reset error:", error);
        await Swal.fire({
            title: "Reset Failed", text: error.message || "Something went wrong.", icon: "error",
            showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
            hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
        });
    }
}

var swiper = new Swiper(".Images-frame-slider", {
    slidesPerView: "auto",
    spaceBetween: 10,
    centeredSlides: true,
    clickable: true,
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    on: { slideChange: function () { updateActiveImage(); } },
});

function updateActiveImage() {
    setTimeout(() => {
        const activeSlide = document.querySelector(".swiper-slide-active");
        if (activeSlide) {
            const img = activeSlide.querySelector("img");
            if (img) {
                const activeSrc = img.src;
                const filename = img.getAttribute("data-frame-config") || "";
                if (filename) {
                    fetch(get_frame_config, {
                        method: "POST",
                        body: JSON.stringify({ filename: filename }),
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Content-Type": "application/json",
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                applyInitialFrameDesign(data.frame_configuration);
                                applyInitialFrameColor(data.frame_configuration);
                                applyInitialFrameSize(data.frame_configuration);
                                applyInitialFrameFinish(data.frame_configuration);
                                applyInitialFrameLED(data.frame_configuration);
                                document.getElementById("uploaded-image").src = activeSrc;
                                updateFramePrice(data.frame_configuration);
                            }
                        })
                        .catch((err) => console.error("Error fetching frame configuration:", err));
                }
            }
        }
    }, 100);
}

updateActiveImage();

document.querySelector(".Images-frame-slider .swiper-wrapper").addEventListener("click", function (e) {
    const slide = e.target.closest(".swiper-slide");
    if (!slide) return;

    document.querySelectorAll(".Images-frame-slider .swiper-slide").forEach(function (s) {
        s.classList.remove("swiper-slide-active");
    });
    slide.classList.add("swiper-slide-active");

    const img = slide.querySelector("img");
    if (img) {
        const filename = img.getAttribute("data-frame-config") || "";
        if (filename) {
            fetch(get_frame_config, {
                method: "POST",
                body: JSON.stringify({ filename: filename }),
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        applyInitialFrameDesign(data.frame_configuration);
                        applyInitialFrameColor(data.frame_configuration);
                        applyInitialFrameSize(data.frame_configuration);
                        applyInitialFrameFinish(data.frame_configuration);
                        applyInitialFrameLED(data.frame_configuration);
                        document.getElementById("uploaded-image").src = img.src;
                        updateFramePrice(data.frame_configuration);
                    }
                })
                .catch((err) => console.error("Error fetching frame configuration:", err));
        }
    }
});

const designOptions = document.querySelectorAll(".frame-change.dropdown-item");
designOptions.forEach((option) => {
    option.addEventListener("click", function () {
        const designClass  = this.getAttribute("data-design");
        const displayText  = this.getAttribute("data-text");
        const design_price = this.getAttribute("data-price");

        const frameWrap = document.getElementById("frameWrap");
        frameWrap.classList.remove("classic-card-design", "bold-card-design");
        frameWrap.classList.add(designClass);

        const frameWrapChild = document.getElementById("frameWrapChild");
        if (designClass === "frameless-card-design") {
            frameWrapChild.classList.remove("no-border-design");
            frameWrapChild.classList.add("frameless-design");
        } else if (designClass === "bold-card-design") {
            frameWrapChild.classList.remove("frameless-design");
            frameWrapChild.classList.add("no-border-design");
        } else {
            frameWrapChild.classList.remove("frameless-design");
            frameWrapChild.classList.remove("no-border-design");
        }

        document.getElementById("frame-show").textContent = displayText;
        designOptions.forEach((item) => item.classList.remove("li-border-color"));
        this.classList.add("li-border-color");

        let get_active_config = JSON.parse($("#active_config").val());
        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.design.design_price = design_price;
        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $("#active_config").val(JSON.stringify(get_active_config));

        saveFrameConfigToDatabase({ designClass, displayText, design_price }, "design");

        const colorOptionsTemp = document.querySelectorAll(".frame-color");
        if (designClass === "frameless-card-design") {
            colorOptionsTemp.forEach((colorOption, index) => {
                colorOption.style.display = index === 0 ? "flex" : "none";
            });
        } else {
            colorOptionsTemp.forEach((colorOption) => { colorOption.style.display = "flex"; });
        }

        const sizeOptionsTemp = document.querySelectorAll(".frame-size");
        if (designClass === "frameless-card-design") {
            sizeOptionsTemp.forEach((sizeOption) => {
                const sizeText = sizeOption.querySelector(".propertyName").textContent.trim();
                sizeOption.style.display = sizeText === '8" X 8"' ? "flex" : "none";
            });

            const eightByEight = Array.from(sizeOptionsTemp).find(
                (s) => s.querySelector(".propertyName").textContent.trim() === '8" X 8"'
            );
            if (eightByEight) eightByEight.click();

        } else {
            sizeOptionsTemp.forEach((sizeOption) => { sizeOption.style.display = "flex"; });
        }

        setTimeout(() => { updateFramePrice(get_active_config); }, 500);
    });
});

function updateFrameBorderImage(imageUrl) {
    const frameWrap = document.getElementById("frameWrap");
    if (frameWrap) {
        frameWrap.style.borderImageSource = `url(${imageUrl})`;
        frameWrap.style.borderImageSlice  = "30";
        frameWrap.style.borderImageRepeat = "stretch";
    }
}

const colorOptions = document.querySelectorAll(".frame-color.dropdown-item");
document.querySelectorAll(".frame-color").forEach((item) => {
    item.addEventListener("click", function () {
        const img_src     = this.getAttribute("data-src");
        const color_name  = this.getAttribute("data-color");
        const shadowClass = this.getAttribute("data-shadow");
        const color_price = this.getAttribute("data-price");

        colorOptions.forEach((item) => item.classList.remove("li-border-color"));
        this.classList.add("li-border-color");

        const img = this.querySelector("img.LeftSidebar");
        if (img && img.src) {
            updateFrameBorderImage(img_src);
            document.getElementById("color-show").textContent = color_name;
        }

        const frameWrap = document.getElementById("frameWrap");
        if (frameWrap) {
            frameWrap.classList.forEach((cls) => {
                if (cls.startsWith("box-shadow-")) frameWrap.classList.remove(cls);
            });
            if (shadowClass) frameWrap.classList.add(shadowClass);
        }

        let get_active_config = JSON.parse($("#active_config").val());
        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.color.color_price = color_price;
        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $("#active_config").val(JSON.stringify(get_active_config));

        saveFrameConfigToDatabase({ img_src, color_name, shadowClass, color_price }, "color");
        setTimeout(() => { updateFramePrice(get_active_config); }, 500);
    });
});

const sizeOptions = document.querySelectorAll(".frame-size");
sizeOptions.forEach((option) => {
    option.addEventListener("click", function () {
        const width         = this.getAttribute("data-width");
        const height        = this.getAttribute("data-height");
        const max_width     = this.getAttribute("data-max-width");
        const frame_price   = parseFloat(this.getAttribute("data-price"));
        const frameSizeText = this.querySelector(".propertyName").textContent.trim();

        const frameWrap = document.getElementById("frameWrap");
        if (frameWrap) {
            frameWrap.style.width    = width;
            frameWrap.style.height   = height;
            frameWrap.style.maxWidth = max_width;
        }

        const frameBox = document.querySelector(".frame-box");
        if (frameBox) {
            frameBox.style.width  = width;
            frameBox.style.height = height;
        }

        sizeOptions.forEach((item) => item.classList.remove("li-border-color"));
        this.classList.add("li-border-color");
        document.getElementById("size-show").textContent = frameSizeText;

        let get_active_config = JSON.parse($("#active_config").val());
        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.size = {
            width: width,
            height: height,
            max_width: max_width,
            frame_price: frame_price,
            frameSizeText: frameSizeText,
        };
        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $("#active_config").val(JSON.stringify(get_active_config));

        saveFrameConfigToDatabase({ width, height, max_width, frame_price, frameSizeText }, "size");
        setTimeout(() => { updateFramePrice(get_active_config); }, 500);
    });
});

const finishOptions = document.querySelectorAll(".frame-finish");
finishOptions.forEach((option) => {
    option.addEventListener("click", function () {
        const finish_price    = parseFloat(this.getAttribute("data-price"));
        const frameFinishText = this.querySelector(".propertyName").textContent.trim();

        finishOptions.forEach((item) => item.classList.remove("li-border-color"));
        this.classList.add("li-border-color");
        document.getElementById("finish-show").textContent = frameFinishText;

        let get_active_config = JSON.parse($("#active_config").val());
        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.finish.finish_price = finish_price;
        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $("#active_config").val(JSON.stringify(get_active_config));

        saveFrameConfigToDatabase({ finish_price, frameFinishText }, "finish");
        setTimeout(() => { updateFramePrice(get_active_config); }, 500);
    });
});

const hangOptions = document.querySelectorAll(".frame-led");
hangOptions.forEach((option) => {
    option.addEventListener("click", function () {
        const price         = parseFloat(this.getAttribute("data-price"));
        const value         = this.getAttribute("data-val");
        const framehangText = this.querySelector(".propertyName").textContent.trim();

        const liElement     = document.getElementById("frame-finish-li");
        const buttonElement = liElement.querySelector("button");
        if (buttonElement) buttonElement.disabled = value === "yes";

        hangOptions.forEach((item) => item.classList.remove("li-border-color"));
        this.classList.add("li-border-color");
        document.getElementById("led-show").textContent = framehangText;

        let get_active_config = JSON.parse($("#active_config").val());
        let frameConfig = JSON.parse(get_active_config.frame_configuration);
        frameConfig.led.price = price;
        get_active_config.frame_configuration = JSON.stringify(frameConfig);
        $("#active_config").val(JSON.stringify(get_active_config));

        saveFrameConfigToDatabase({ price, value, framehangText }, "led");
        setTimeout(() => { updateFramePrice(get_active_config); }, 500);
    });
});

function saveFrameConfigToDatabase(frameConfig, type) {
    const activeSlide = document.querySelector(".swiper-slide-active");
    if (activeSlide) {
        const activeImg = activeSlide.querySelector("img");
        if (activeImg) {
            const activeSrc = activeImg.getAttribute("src");
            const imageName = activeSrc.split("/").pop().split(".").slice(0, -1).join(".");
            sendFrameConfigToServer(imageName, frameConfig, type);
        }
    }
}

async function sendFrameConfigToServer(imageName, frameConfig, type) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    const response = await fetch(config_url, {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
        body: JSON.stringify({ image_name: imageName, frame_config: frameConfig, type: type }),
    });

    const result = await response.json();
    if (result.success) {
        document.getElementById("active_config").value = JSON.stringify(result.data);
    } else {
        console.error("Failed to save frame configuration:", result.message);
    }
}

function getActiveFrameDimensions() {
    // 1. Check selected frame-size dropdown item
    const selectedSizeOption = document.querySelector(".frame-size.li-border-color");
    if (selectedSizeOption) {
        const w = parseFloat(selectedSizeOption.getAttribute("data-width"));
        const h = parseFloat(selectedSizeOption.getAttribute("data-height"));
        if (w > 0 && h > 0) return { width: w, height: h };
    }

    // 2. Check active config
    const activeConfigInput = document.getElementById("active_config");
    if (activeConfigInput && activeConfigInput.value) {
        try {
            const activeConfig = JSON.parse(activeConfigInput.value);
            const frameConfig = typeof activeConfig.frame_configuration === "string"
                ? JSON.parse(activeConfig.frame_configuration)
                : activeConfig.frame_configuration;
            const size = frameConfig?.size;
            if (size) {
                const w = parseFloat(size.width);
                const h = parseFloat(size.height);
                if (w > 0 && h > 0) return { width: w, height: h };
            }
        } catch (e) {
            console.error("Error reading active config size:", e);
        }
    }

    // 3. Fallback to frameWrap dimensions
    const frameWrap = document.getElementById("frameWrap");
    if (frameWrap) {
        const styleW = parseFloat(frameWrap.style.width);
        const styleH = parseFloat(frameWrap.style.height);
        if (styleW > 0 && styleH > 0) return { width: styleW, height: styleH };
        if (frameWrap.offsetWidth > 0 && frameWrap.offsetHeight > 0) {
            return { width: frameWrap.offsetWidth, height: frameWrap.offsetHeight };
        }
    }

    return { width: 309, height: 318 };
}

function getActiveOriginalImageSrc() {
    const uploadedImg = document.getElementById("uploaded-image");
    const currentSrc = uploadedImg ? uploadedImg.src : "";

    const activeConfigInput = document.getElementById("active_config");
    if (activeConfigInput && activeConfigInput.value) {
        try {
            const activeConfig = JSON.parse(activeConfigInput.value);
            const origPath = activeConfig.original_file_url;
            if (origPath) {
                if (origPath.startsWith("http://") || origPath.startsWith("https://")) {
                    return origPath;
                }
                if (currentSrc) {
                    const basePath = currentSrc.substring(0, currentSrc.lastIndexOf("/") + 1);
                    const cleanOrig = origPath.replace(/^(\/)?uploads\//, "");
                    return basePath + cleanOrig;
                }
            }
        } catch (e) {
            console.error("Error reading active config original image:", e);
        }
    }

    return currentSrc;
}

$(document).ready(function () {
    let $uploadCrop = null;

    function initializeCroppie(targetWidth, targetHeight) {
        if ($uploadCrop) {
            try {
                $uploadCrop.croppie("destroy");
            } catch (e) {}
            $uploadCrop = null;
        }

        // Available bounding dimensions in the modal
        const maxModalWidth = Math.min($(window).width() * 0.85, 380);
        const maxModalHeight = Math.min($(window).height() * 0.50, 380);

        // Calculate uniform scale factor to strictly preserve targetWidth : targetHeight aspect ratio
        const scale = Math.min(maxModalWidth / targetWidth, maxModalHeight / targetHeight);

        const viewportWidth = Math.max(100, Math.round(targetWidth * scale * 0.85));
        const viewportHeight = Math.max(100, Math.round(targetHeight * scale * 0.85));

        const boundaryWidth = Math.min($(window).width() * 0.9, Math.round(viewportWidth + 40));
        const boundaryHeight = Math.round(viewportHeight + 40);

        $uploadCrop = $("#upload-demo").croppie({
            viewport: { width: viewportWidth, height: viewportHeight, type: "square" },
            boundary: { width: boundaryWidth, height: boundaryHeight },
            enforceBoundary: true,
            enableExif: true,
            showZoomer: true,
            mouseWheelZoom: false,
        });
    }

    $("#openCropModal").on("click", function () {
        const rawSrc = getActiveOriginalImageSrc();
        if (!rawSrc) return;

        const dims = getActiveFrameDimensions();
        initializeCroppie(dims.width, dims.height);

        $("#cropImagePop").modal("show");
    });

    $("#cropImagePop").on("shown.bs.modal", function () {
        $(".LeftSidebar_designTool").addClass("blurred");
        const rawSrc = getActiveOriginalImageSrc();
        if (!rawSrc || !$uploadCrop) return;

        $uploadCrop.croppie("bind", { url: rawSrc }).then(function () {
            setTimeout(() => {
                let minZoom = $(".cr-slider").attr("min");
                if (minZoom) {
                    $(".cr-slider").val(minZoom).trigger("input");
                }
            }, 100);
        });
    });

    $("#cropImagePop").on("hidden.bs.modal", function () {
        $(".LeftSidebar_designTool").removeClass("blurred");
    });

    $("#cropImageBtn").on("click", function () {
        if (!$uploadCrop) return;

        const dims = getActiveFrameDimensions();
        // High-resolution export maintaining the exact same aspect ratio
        const exportScale = Math.max(1, Math.min(3, 800 / dims.width));
        const exportWidth = Math.round(dims.width * exportScale);
        const exportHeight = Math.round(dims.height * exportScale);

        $uploadCrop.croppie("result", {
            type: "base64",
            format: "jpeg",
            size: { width: exportWidth, height: exportHeight }
        }).then(function (resp) {
            const imgElement = document.querySelector(".swiper-slide-active img");
            const filename = imgElement ? imgElement.getAttribute("data-frame-config") : "default.jpg";
            $("#uploaded-image").attr("src", resp);
            $("#slider-image").attr("src", resp);
            saveCroppedImageToServer(resp, filename);
            $("#cropImagePop").modal("hide");
        });
    });

    function saveCroppedImageToServer(base64Image, filename) {
        $.ajax({
            url: save_cropped_image,
            type: "POST",
            data: { cropped_image: base64Image, filename: filename, _token: $('meta[name="csrf-token"]').attr("content") },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Crop Image",
                        text: "Image saved successfully!",
                        showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                        hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
                    });
                    $("#frameWrap #uploaded-image").attr("src", response.file_url);

                    let imgElement = document.querySelector(".swiper-slide-active img");
                    if (imgElement) {
                        imgElement.src = response.file_url;
                        imgElement.setAttribute("data-frame-config", response.filename);
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Crop Image",
                        text: "Failed to save image.",
                        showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                        hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
                    });
                }
            },
            error: function (xhr, status, error) { console.error("Error:", error); },
        });
    }
});

["add-to-cart-1", "add-to-cart-2"].forEach(function (id) {
    document.getElementById(id).addEventListener("click", function () {
        fetch(get_all_images)
            .then((response) => response.json())
            .then((response) => {
                if (!response.success) {
                    Swal.fire({
                        icon: "error", title: "Error", text: response.message || "No images found.",
                        showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                        hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
                    });
                    return;
                }

                let quantity_of_item = parseFloat($('#quantity').val()) || 1;

                fetch(add_to_cart, {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ quantity: quantity_of_item }),
                })
                    .then((response) => response.json())
                    .then((responseData) => {
                        if (responseData.success) {
                            Swal.fire({
                                icon: "success", title: "Added to Cart", text: responseData.message,
                                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
                            }).then(() => { window.location.href = cart_page; });
                        } else {
                            Swal.fire({
                                icon: "error", title: "Error", text: responseData.message || "An error occurred.",
                                showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                                hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
                            });
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                        Swal.fire({
                            icon: "error", title: "Error", text: "Failed to add products to cart.",
                            showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                            hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
                        });
                    });
            })
            .catch((error) => {
                console.error(error);
                Swal.fire({
                    icon: "error", title: "Error", text: "Failed to get images.",
                    showClass: { popup: "animate__animated animate__fadeIn animate__slow" },
                    hideClass: { popup: "animate__animated animate__fadeOut animate__faster" },
                });
            });
    });
});
