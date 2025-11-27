<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi PIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; max-width: 400px; margin: 100px auto; }
    </style>
</head>
<body>
    <div class="card shadow p-4">
        <h4 class="text-center mb-3">🔒 Verifikasi PIN</h4>

        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('pin') }}
            </div>
        @endif

        <form action="{{ route('verifikasi.pin.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="pin" class="form-label">Masukkan PIN Anda:</label>
                <input type="password" id="pin" name="pin" class="form-control" maxlength="6" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="text-decoration-none">⬅ Kembali</a>
        </div>
    </div>
</body>
</html>
