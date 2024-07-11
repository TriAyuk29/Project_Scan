<!DOCTYPE html>
<html>

<head>
  <title>Scan QR Code</title>
  <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      background-color: #f8f9fa;
    }

    #scanner-container {
      text-align: center;
    }

    #start-scanning-btn {
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }

    #reader {
      width: 500px;
      margin: auto;
      display: none;
    }

    #result {
      margin-top: 20px;
      text-align: center;
    }

    .btn-container {
      margin-top: 20px;
      display: none;
    }

    .btn {
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div id="scanner-container">
    <img src="your-logo-url.png" alt="ScanApp Logo">
    <h1>Scan QR Code</h1>
    <button id="start-scanning-btn">Start Scanning</button>
    <div id="reader"></div>
    <div id="result"></div>
    <div class="btn-container">
      <button class="btn" onclick="stopScanning()">Stop Scanning</button>
    </div>
  </div>

  <script>
    let html5QrCode;

    document.getElementById('start-scanning-btn').addEventListener('click', function() {
      this.style.display = 'none'; // Hide the start scanning button
      document.getElementById('reader').style.display = 'block'; // Show the QR code reader
      document.querySelector('.btn-container').style.display = 'block'; // Show the stop scanning button
      startScanning();
    });

    function onScanSuccess(decodedText, decodedResult) {
      document.getElementById('result').innerText = `QR Code detected: ${decodedText}`;
      html5QrCode.stop().then(ignore => {
        console.log("QR Code scanning stopped.");
      }).catch(err => {
        console.error("Unable to stop scanning.", err);
      });
    }

    function onScanError(errorMessage) {
      console.error(`QR Code scan error: ${errorMessage}`);
    }

    function startScanning() {
      html5QrCode = new Html5Qrcode("reader");
      html5QrCode.start({
          facingMode: "environment"
        }, // setting to use back camera
        {
          fps: 10, // scanning speed
          qrbox: {
            width: 250,
            height: 250
          } // scanning box
        },
        onScanSuccess,
        onScanError
      ).catch(err => {
        console.error("Unable to start scanning.", err);
      });
    }

    function stopScanning() {
      html5QrCode.stop().then(ignore => {
        console.log("QR Code scanning stopped.");
        document.getElementById('start-scanning-btn').style.display = 'block'; // Show the start scanning button again
        document.getElementById('reader').style.display = 'none'; // Hide the QR code reader
        document.querySelector('.btn-container').style.display = 'none'; // Hide the stop scanning button
        document.getElementById('result').innerText = ''; // Clear the result text
      }).catch(err => {
        console.error("Unable to stop scanning.", err);
      });
    }
  </script>
</body>

</html>
