<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SIGAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sigap-blue-dark: #1e3a8a;
            --sigap-blue: #2563eb;
            --sigap-blue-light: #3b5bdb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
        }

        .sigap-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ===== Panel kiri ===== */
        .sigap-brand {
            flex: 0 0 38%;
            background: linear-gradient(160deg, var(--sigap-blue-dark), var(--sigap-blue-light));
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .sigap-brand-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
        }

        .sigap-brand h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 0.4rem;
        }

        .sigap-brand p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.75);
            max-width: 220px;
            margin: 0;
        }

        .sigap-brand-footer {
            position: absolute;
            bottom: 2rem;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
            text-align: center;
        }

        /* ===== Panel kanan ===== */
        .sigap-form {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #fff;
        }

        .sigap-form-inner {
            width: 100%;
            max-width: 360px;
        }

        .sigap-form-inner h2 {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 0.25rem;
        }

        .sigap-form-inner > p {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1.75rem;
        }

        .sigap-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.35rem;
            display: block;
        }

        .sigap-input-group {
            position: relative;
            margin-bottom: 1.1rem;
        }

        .sigap-input-group .bi {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .sigap-input-group input {
            width: 100%;
            padding: 0.6rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            background: #f9fafb;
        }

        .sigap-input-group input:focus {
            outline: none;
            border-color: var(--sigap-blue);
            background: #fff;
        }

        .sigap-toggle-password {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
        }

        .sigap-row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }

        .sigap-row-between a {
            color: var(--sigap-blue);
            text-decoration: none;
        }

        .sigap-btn-submit {
            width: 100%;
            padding: 0.65rem;
            border: none;
            border-radius: 0.5rem;
            background: var(--sigap-blue);
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .sigap-btn-submit:hover { background: var(--sigap-blue-dark); }

        .sigap-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #9ca3af;
            font-size: 0.75rem;
            margin: 1.25rem 0;
        }

        .sigap-divider::before, .sigap-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .sigap-contact-box {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            text-align: center;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .sigap-contact-box a {
            color: var(--sigap-blue);
            font-weight: 600;
            text-decoration: none;
        }

        .sigap-error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        @media (max-width: 768px) {
            .sigap-brand { display: none; }
        }
    </style>
</head>
<body>

<div class="sigap-wrapper">

    <div class="sigap-brand">
        <img src="{{ asset('image/logo_unuja.png') }}"
             alt="Logo Universitas Nurul Jadid"
             class="sigap-logo">
        <h1>SIGAP</h1>
        <p>Sistem Informasi Gangguan Aset Pembelajaran</p>
        <div class="sigap-brand-footer">
            Universitas Nurul Jadid<br>
            &copy; {{ date('Y') }} All Rights Reserved
        </div>
    </div>

    <div class="sigap-form">
        <div class="sigap-form-inner">
            <h2>Selamat Datang 👋</h2>
            <p>Masuk ke akun SIGAP kamu</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <label class="sigap-label" for="email">Email</label>
                <div class="sigap-input-group">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" id="email"
                           placeholder="Masukkan email kamu"
                           value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <div class="sigap-error mb-2">{{ $message }}</div>
                @enderror

                <label class="sigap-label" for="password">Kata Sandi</label>
                <div class="sigap-input-group">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="password"
                           placeholder="Masukkan kata sandi" required>
                    <button type="button" class="sigap-toggle-password" id="togglePassword">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>

                <div class="sigap-row-between">
                    <label>
                        <input type="checkbox" name="remember"> Ingat Saya
                    </label>
                    <a href="#">Lupa Password?</a>
                </div>

                <button type="submit" class="sigap-btn-submit">Masuk</button>
            </form>

            <div class="sigap-divider">ATAU</div>

            <div class="sigap-contact-box">
                <i class="bi bi-info-circle"></i>
                Belum punya akun? <a href="#">Hubungi Admin PDSI</a>
            </div>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
</script>

</body>
</html>