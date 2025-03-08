<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draw & Select Rectangles</title>
    <style>
        #image-container {
            position: relative;
            display: inline-block;
            border: 2px solid black;
        }
        canvas {
            cursor: crosshair;
        }
        .rectangle {
            position: absolute;
            border: 2px dashed red;
            cursor: pointer;
        }
        .rectangle.selected {
            border: 2px solid green;
        }
        .add-btn {
            position: absolute;
            top: 5px;
            left: 5px;
            background: white;
            border: 1px solid black;
            cursor: pointer;
            padding: 2px 5px;
            font-size: 14px;
            display: none;
        }
        .filter-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            background: white;
            border: 1px solid black;
            cursor: pointer;
            padding: 5px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <input type="file" id="uploadImage" accept="image/*">
    <button class="filter-btn" onclick="filterSelectedRectangles()">Filter Selected</button>
    <div id="image-container">
        <canvas id="canvas"></canvas>
    </div>

    <script>
        let isDrawing = false;
        let startX, startY, currentX, currentY;
        let selectedRectangles = [];
        let img = new Image(); // Store uploaded image

        const canvas = document.getElementById("canvas");
        const container = document.getElementById("image-container");
        const ctx = canvas.getContext("2d");

        // Upload and display image
        document.getElementById("uploadImage").addEventListener("change", function (event) {
            let file = event.target.files[0];
            if (!file) return;

            img.src = URL.createObjectURL(file);
            img.onload = function () {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);
            };
        });

        // Start drawing
        canvas.addEventListener("mousedown", function (e) {
            isDrawing = true;
            startX = e.offsetX;
            startY = e.offsetY;
        });

        // Draw rectangle dynamically while dragging
        canvas.addEventListener("mousemove", function (e) {
            if (!isDrawing) return;

            currentX = e.offsetX;
            currentY = e.offsetY;

            // Clear canvas and redraw the image
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height); // Redraw image

            // Draw live rectangle
            let width = currentX - startX;
            let height = currentY - startY;
            ctx.strokeStyle = "red";
            ctx.lineWidth = 2;
            ctx.setLineDash([5, 5]);  // Dashed border
            ctx.strokeRect(startX, startY, width, height);
        });

        // Stop drawing and create a div rectangle
        canvas.addEventListener("mouseup", function (e) {
            if (!isDrawing) return;
            isDrawing = false;

            let width = e.offsetX - startX;
            let height = e.offsetY - startY;
            if (width > 10 && height > 10) {
                createRectangleElement(startX, startY, width, height);
            }

            // Clear canvas and redraw final image
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        });

        // Create rectangle div
        function createRectangleElement(x, y, width, height) {
            let rectDiv = document.createElement("div");
            rectDiv.className = "rectangle";
            rectDiv.style.left = `${x}px`;
            rectDiv.style.top = `${y}px`;
            rectDiv.style.width = `${width}px`;
            rectDiv.style.height = `${height}px`;

            // Toggle selection on click
            rectDiv.addEventListener("click", function () {
                if (rectDiv.classList.contains("selected")) {
                    rectDiv.classList.remove("selected");
                    selectedRectangles = selectedRectangles.filter(r => r !== rectDiv);
                } else {
                    rectDiv.classList.add("selected");
                    selectedRectangles.push(rectDiv);
                }
            });

            container.appendChild(rectDiv);
        }

        // Filter selected rectangles and show image upload button
        function filterSelectedRectangles() {
            document.querySelectorAll(".rectangle:not(.selected)").forEach(el => el.remove());
            selectedRectangles.forEach(rectDiv => {
                rectDiv.style.backgroundColor = "white";
                rectDiv.style.border = "2px solid black";

                if (!rectDiv.querySelector(".add-btn")) {
                    let addBtn = document.createElement("button");
                    addBtn.className = "add-btn";
                    addBtn.innerHTML = "+";
                    addBtn.onclick = function (event) {
                        event.stopPropagation();
                        uploadImageForRectangle(rectDiv);
                    };
                    rectDiv.appendChild(addBtn);
                }
                rectDiv.querySelector(".add-btn").style.display = "block";
            });
        }

        // Upload image inside selected rectangle
        function uploadImageForRectangle(rectDiv) {
            let input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.style.display = "none";

            input.onchange = function (event) {
                let file = event.target.files[0];
                if (!file) return;

                let imgURL = URL.createObjectURL(file);
                rectDiv.style.backgroundImage = `url(${imgURL})`;
                rectDiv.style.backgroundColor = "transparent";
                rectDiv.style.border = "none";

                // Ensure the image fits within the rectangle properly
                rectDiv.style.backgroundSize = "cover";
                rectDiv.style.backgroundPosition = "center";

                rectDiv.querySelector(".add-btn").remove();
            };

            document.body.appendChild(input);
            input.click();
            document.body.removeChild(input);
        }
    </script>
</body>
</html>
