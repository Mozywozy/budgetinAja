<!DOCTYPE html>
<html>
<head>
    <title>Saran Baru</title>
</head>
<body>
    <h2>Saran Baru dari {{ $data['name'] }}</h2>
    <p><strong>Nama:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Saran:</strong></p>
    <p>{{ $data['suggestion'] }}</p>
</body>
</html>