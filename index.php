<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script async src="lib/opencv.js" onload="openCvReady();"></script>
    <script src="lib/utils.js"></script>
    <script src="lib/main.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/main.css">
    <title>Tracking by nxhdev2002</title>
</head>
<body>
    <div class="container app">
        <center> 
        <!-- <form> -->
            <input type="text" placeholder="Nhập id google form" id="idggform"> 
            <input type="number" placeholder="Nhập thời gian (số s)" id="time">
            <input type="submit" value="Tạo bài làm" id="submit">
        <!-- </form> -->
        <div>Thời gian còn lại để làm bài <span id="counttime">05:00</span> minutes!</div>
        <div class="bailam" style="display: none;">
            <iframe width="640" height="418" frameborder="0" marginheight="0" marginwidth="0" id="googleform">Đang tải…</iframe>
        </div>




<div>
    <video id="cam_input" height="480" width="640"></video>
    <canvas id="canvas_output"></canvas>
</div>
<script>
    function openCvReady() {
  cv['onRuntimeInitialized']=()=>{
    let video = document.getElementById("cam_input"); // video is the id of video tag
    navigator.mediaDevices.getUserMedia({ video: true, audio: false })
    .then(function(stream) {
        video.srcObject = stream;
        video.play();
    })
    .catch(function(err) {
        console.log("An error occurred! " + err);
    });
    let src = new cv.Mat(video.height, video.width, cv.CV_8UC4);
    let dst = new cv.Mat(video.height, video.width, cv.CV_8UC1);
    let gray = new cv.Mat();
    let cap = new cv.VideoCapture(cam_input);
    let faces = new cv.RectVector();
    let classifier = new cv.CascadeClassifier();
    let utils = new Utils('errorMessage');
    let count = 0;
    let faceCascadeFile = 'haarcascade_frontalface_default.xml'; // path to xml
    utils.createFileFromUrl(faceCascadeFile, faceCascadeFile, () => {
    classifier.load(faceCascadeFile); // in the callback, load the cascade from file 
});
    const FPS = 24;
    function processVideo() {
        let begin = Date.now();
        cap.read(src);
        src.copyTo(dst);
        cv.cvtColor(dst, gray, cv.COLOR_RGBA2GRAY, 0);
        try{
            classifier.detectMultiScale(gray, faces, 1.1, 3, 0);
            console.log(faces.size());
            if (faces.size() >= 2) {
                count++;
                $("#warning-multi-faces").removeAttr("style")
                $("#notify-faces").text("Đã phát hiện " + faces.size() + "khuôn mặt")
            } else {
                $("#warning-multi-faces").attr("style", "display:none")
                $("#notify-faces").text("")
            }
        }catch(err){
            console.log(err);
        }
        for (let i = 0; i < faces.size(); ++i) {
            let face = faces.get(i);
            let point1 = new cv.Point(face.x, face.y);
            let point2 = new cv.Point(face.x + face.width, face.y + face.height);
            cv.rectangle(dst, point1, point2, [255, 0, 0, 255]);
        }
        cv.imshow("canvas_output", dst);
        // schedule next one.
        let delay = 1000/FPS - (Date.now() - begin);
        setTimeout(processVideo, delay);
}
// schedule first one.
setTimeout(processVideo, 0);
  };
}
</script>



    <div id="warning-tabs" style="display: none">
            <span style="color: rgb(158, 34, 34);"><b>Cảnh báo</b></span>
            <span id="notify"></span>
        </div>
    </div>
    <div id="warning-multi-faces" style="display: none">
        <span style="color: rgb(158, 34, 34);"><b>Cảnh báo</b></span>
        <span id="notify-faces"></span>
    </div>
    </div>
        </center>



</body>
</html>