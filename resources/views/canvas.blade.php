<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Rectangle Detection</title>
    <style>
        #image-container {
            position: relative;
            display: inline-block;
        }
        .rectangle {
            position: absolute;
            border: 2px dashed red;
        }
        .add-btn {
            position: absolute;
            background: white;
            border: 1px solid black;
            cursor: pointer;
            padding: 5px;
            font-size: 16px;
            font-weight: bold;
        }
        .upload-box {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
    </style>
</head>
<body>

    <input type="file" id="uploadImage" accept="image/*">
    <div id="image-container">
        <canvas id="canvas"></canvas>
    </div>

    <script async src="opencv.js" type="text/javascript"></script>

    <script>
        function cvReady() {
            console.log("OpenCV.js Loaded!");
        }

        document.getElementById("uploadImage").addEventListener("change", function (event) {
            let file = event.target.files[0];
            if (!file) return;

            let img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = function () {
                detectRectangles(img);
            };
        });

        function detectRectangles(img) {
            let canvas = document.getElementById("canvas");
            let container = document.getElementById("image-container");
            let ctx = canvas.getContext("2d");

            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);

            // Load image into OpenCV Mat
            let src = cv.imread(canvas);
            let gray = new cv.Mat();
            cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY);

            // Apply Edge Detection
            let edges = new cv.Mat();
            cv.Canny(gray, edges, 50, 150);

            // Find contours
            let contours = new cv.MatVector();
            let hierarchy = new cv.Mat();
            cv.findContours(edges, contours, hierarchy, cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE);

            // Clear previous rectangles
            document.querySelectorAll('.rectangle').forEach(el => el.remove());

            for (let i = 0; i < contours.size(); i++) {
                let contour = contours.get(i);
                let approx = new cv.Mat();
                cv.approxPolyDP(contour, approx, 0.02 * cv.arcLength(contour, true), true);

                if (approx.rows === 4) { // Rectangle check (4 corners)
                    let rect = cv.boundingRect(approx);
                    createRectangleElement(rect, container);
                }

                approx.delete();
            }

            // Cleanup
            src.delete(); gray.delete(); edges.delete();
            contours.delete(); hierarchy.delete();
        }

        function createRectangleElement(rect, container) {
            let { x, y, width, height } = rect;

            // Create a div for the rectangle
            let rectDiv = document.createElement("div");
            rectDiv.className = "rectangle";
            rectDiv.style.left = `${x}px`;
            rectDiv.style.top = `${y}px`;
            rectDiv.style.width = `${width}px`;
            rectDiv.style.height = `${height}px`;

            // Create an "Add (+)" button inside the rectangle
            let addBtn = document.createElement("button");
            addBtn.className = "add-btn";
            addBtn.style.left = `${width / 2 - 15}px`;
            addBtn.style.top = `${height / 2 - 15}px`;
            addBtn.innerHTML = "+";
            addBtn.onclick = function () {
                uploadImageForRectangle(rectDiv);
            };

            // Create an image preview inside the rectangle
            let imgPreview = document.createElement("img");
            imgPreview.className = "upload-box";

            rectDiv.appendChild(imgPreview);
            rectDiv.appendChild(addBtn);
            container.appendChild(rectDiv);
        }

        function uploadImageForRectangle(rectDiv) {
            let input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.style.display = "none";

            input.onchange = function (event) {
                let file = event.target.files[0];
                if (!file) return;

                let imgURL = URL.createObjectURL(file);
                let imgPreview = rectDiv.querySelector(".upload-box");
                imgPreview.src = imgURL;
                imgPreview.style.display = "block";
            };

            document.body.appendChild(input);
            input.click();
            document.body.removeChild(input);
        }
    </script>

</body>
</html>
{{-- https://chatgpt.com/share/67cb868a-34a0-8012-aaff-960c8c98311f --}}
