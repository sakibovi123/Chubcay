<!DOCTYPE html>
<html>
<head>
    <title>QR Code PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .qr-image {
            text-align: center;
            margin: 20px 0;
        }
        .details {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="details">
        <img src="{{ public_path('images/logo.png') }}" alt="">
        <p>Name: {{ $name }}</p>
        <p>Package name: {{ $title }}</p>
        <p>Price: ${{ $price }}</p>
        <p>Plan: {{ $duration_title }}</p>
        <p>Duration: {{ $duration }} days</p>
    </div>
    <div class="qr-image">
        {{-- <img src="{{ public_path('images/' . $qrImage) }}" alt="QR Code"> --}}
        <img src="{{ storage_path('app/public/' . $qrImage) }}" alt="QR Code">
    </div>
</body>
</html>
