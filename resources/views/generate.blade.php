<!DOCTYPE html>
<html>

<head>
  <title>Generate QR Code</title>
</head>

<body>
  <h1>Generate QR Code</h1>
  <form action="/generate" method="POST">
    @csrf
    <input type="text" name="data" placeholder="Enter data to encode" required>
    <button type="submit">Generate QR Code</button>
  </form>
  @if (isset($qrcode))
    <div>
      {!! $qrcode !!}
    </div>
  @endif
</body>

</html>
