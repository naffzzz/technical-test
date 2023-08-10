<!DOCTYPE html>
<html>
<head>
    <title>Event Qr Code</title>
</head>
<body>
    <center>
        <h3>Your Event Code</h3><br>
        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </center>
</body>
</html>
