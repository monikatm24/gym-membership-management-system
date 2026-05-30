
<!DOCTYPE html>
<html>
<head>
    <title>QR Attendance Scanner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        <script src="https://unpkg.com/html5-qrcode"></script>
        body{
            background:#f4f6f9;
            font-family:Segoe UI;
        }

        .box{
            max-width:500px;
            margin:50px auto;
            background:white;
            padding:20px;
            border-radius:15px;
            box-shadow:0 6px 18px rgba(0,0,0,0.1);
            text-align:center;
        }

        #reader{
            width:100%;
        }
    </style>
</head>

<body>

<div class="box">

    <h4>📷 QR Attendance Scanner</h4>

    <div id="reader"></div>

    <p id="result" class="mt-3 text-primary"></p>

</div>

<script>
function onScanSuccess(decodedText) {

    document.getElementById("result").innerText = "Scanning...";

    fetch("mark.php?id=" + decodedText)
    .then(res => res.text())
    .then(data => {
        document.getElementById("result").innerText = data;
    });

}

let scanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
});

scanner.render(onScanSuccess);
</script>

</body>
</html>