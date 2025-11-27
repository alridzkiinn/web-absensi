<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; }
        .password-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .password-box input { flex: 1; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h4 class="mb-3 text-center">🔐 Lihat Password Anda</h4>
            <hr>

            <div class="mb-3">
                <label class="form-label"><strong>Username:</strong></label>
                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Password:</strong></label>
                <div class="password-box">
                    <input type="password" id="passwordField" class="form-control" value="{{ $decryptedPassword }}" readonly>
                    <button class="btn btn-outline-primary" onclick="togglePassword()">👁️</button>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-secondary">⬅ Kembali</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const field = document.getElementById('passwordField');
            const btn = event.target;
            if (field.type === 'password') {
                field.type = 'text';
                btn.textContent = '🙈';
            } else {
                field.type = 'password';
                btn.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
