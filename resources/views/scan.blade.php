<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  <!-- Styles -->
  <style>
    /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */
    *,
    ::after,
    ::before {
      box-sizing: border-box;
      border-width: 0;
      border-style: solid;
      border-color: #e5e7eb;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f9fafb;
    }

    .scanner {
      display: flex;
      flex-direction: column;
      align-items: center;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .scanner canvas {
      margin-bottom: 20px;
      border: 1px solid #0c090955;
    }

    .scanner button {
      padding: 10px 20px;
      background-color: #3b82f6;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .scanner button:hover {
      background-color: #2563eb;
    }

    .scanner p {
      font-size: 1rem;
      color: #374151;
    }

    .scanner .focus-frame {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 200px;
      height: 200px;
      margin-top: -100px;
      /* Half of height */
      margin-left: -100px;
      /* Half of width */
      border: 4px solid #00ff00;
      box-sizing: border-box;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="scanner">
      <canvas id="canvas" width="640" height="480"></canvas>
      <div class="focus-frame"></div>
      <button id="btn-scan-qr">Scan QR Code / Barcode</button>
      <p id="qr-result">Hasil Scan: <span id="outputData"></span></p>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qr-scanner/1.3.0/qr-scanner.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.12.0/JsBarcode.all.min.js"></script>
  <script>
    const video = document.createElement('video');
    const canvasElement = document.getElementById('canvas');
    const canvas = canvasElement.getContext('2d');
    const qrResult = document.getElementById('qr-result');
    const outputData = document.getElementById('outputData');
    const btnScanQR = document.getElementById('btn-scan-qr');
    let scanning = false;

    qrResult.hidden = true;

    async function setupScanner() {
      const qrScanner = new QrScanner(video, result => {
        outputData.innerText = result;
        qrResult.hidden = false;
        qrScanner.stop();
        scanning = false;
      }, {
        // Tentukan bahwa kita mendukung QR Code dan Barcode
        highlightScanRegion: true,
        highlightCodeOutline: true
      });

      btnScanQR.addEventListener('click', () => {
        if (scanning) {
          qrScanner.stop();
          scanning = false;
        } else {
          navigator.mediaDevices.getUserMedia({
              video: {
                facingMode: "environment", // Gunakan kamera belakang
                focusMode: "continuous" // Fokus otomatis untuk video
              }
            })
            .then(stream => {
              video.srcObject = stream;
              video.setAttribute('playsinline', true); // required to tell iOS safari we don't want fullscreen
              video.play();
              qrScanner.start();
              scanning = true;
              drawToCanvas();
            })
            .catch(err => {
              console.error("Error accessing the camera: " + err);
            });
        }
      });

      function drawToCanvas() {
        if (scanning) {
          canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
          requestAnimationFrame(drawToCanvas);
        }
      }
    }

    setupScanner();

    // Support scanning for QR codes and Barcodes
    QrScanner.WORKER_PATH = 'https://cdnjs.cloudflare.com/ajax/libs/qr-scanner/1.3.0/qr-scanner-worker.min.js';
  </script>
</body>

</html>
