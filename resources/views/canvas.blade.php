<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rectangle Detection</title>
</head>
<body>

    <input type="file" id="uploadImage" accept="image/*">
    <canvas id="canvas"></canvas>
    <script async src="{{ asset('assets/js/opencv.js') }}" onload="cvReady()"></script>

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
            let ctx = canvas.getContext("2d");
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);

            // Load image as OpenCV Mat
            let src = cv.imread(canvas);
            let gray = new cv.Mat();
            cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY);

            // Apply Canny Edge Detection
            let edges = new cv.Mat();
            cv.Canny(gray, edges, 50, 150);

            // Find contours
            let contours = new cv.MatVector();
            let hierarchy = new cv.Mat();
            cv.findContours(edges, contours, hierarchy, cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE);

            let rectangles = [];

            for (let i = 0; i < contours.size(); i++) {
                let contour = contours.get(i);
                let approx = new cv.Mat();
                cv.approxPolyDP(contour, approx, 0.02 * cv.arcLength(contour, true), true);

                if (approx.rows === 4) { // Rectangle check (4 corners)
                    let rect = cv.boundingRect(approx);
                    let {x, y, width, height} = rect;
                    let x1 = x + width, y1 = y + height;
                    rectangles.push({x, y, x1, y1, width, height});
                    ctx.strokeStyle = "red";
                    ctx.lineWidth = 2;
                    ctx.strokeRect(x, y, width, height);
                }

                approx.delete();
            }

            console.log(rectangles);

            // Cleanup
            src.delete(); gray.delete(); edges.delete();
            contours.delete(); hierarchy.delete();
        }
    </script>

</body>
</html>
