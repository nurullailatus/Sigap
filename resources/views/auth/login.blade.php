<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SIGAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sigap-navy: #172554;
            --sigap-blue: #2563eb;
            --sigap-blue-light: #60a5fa;
            --sigap-ink: #172033;
            --sigap-muted: #64748b;
            --sigap-border: #dbe4f0;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: var(--sigap-ink);
            background: #edf3fb;
        }

        .sigap-wrapper {
            display: flex;
            width: 100%;
            max-width: 1080px;
            min-height: 650px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 1.5rem;
            background: #fff;
            box-shadow: 0 24px 70px rgba(23, 37, 84, 0.14);
        }

        .sigap-brand {
            flex: 0 0 43%;
            background:
                radial-gradient(circle at 16% 18%, rgba(147,197,253,0.3) 0 7rem, transparent 7.1rem),
                radial-gradient(circle at 90% 88%, rgba(96,165,250,0.2) 0 12rem, transparent 12.1rem),
                linear-gradient(150deg, var(--sigap-navy), #1d4ed8);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 3rem;
            position: relative;
        }

        .sigap-brand::before,
        .sigap-brand::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50%;
        }

        .sigap-brand::before {
            width: 18rem;
            height: 18rem;
            top: -8rem;
            right: -7rem;
        }

        .sigap-brand::after {
            width: 10rem;
            height: 10rem;
            bottom: 3rem;
            left: -6rem;
        }

        .sigap-logo {
            width: 96px;
            height: 96px;
            object-fit: contain;
            padding: 0.8rem;
            margin-bottom: 1.5rem;
            border-radius: 1.75rem;
            background: rgba(255,255,255,0.96);
            box-shadow: 0 12px 30px rgba(8, 25, 75, 0.2);
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
            margin: 0 0 0.65rem;
            font-size: 2rem;
            letter-spacing: 0.12em;
            font-weight: 800;
        }

        .sigap-brand p {
            max-width: 250px;
            margin: 0;
            color: rgba(255,255,255,0.78);
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .sigap-brand-footer {
            position: absolute;
            bottom: 1.75rem;
            color: rgba(255,255,255,0.58);
            font-size: 0.72rem;
            line-height: 1.6;
            text-align: center;
        }

        .sigap-form {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem clamp(2rem, 7vw, 5.5rem);
            background: #fff;
        }

        .sigap-form-inner {
            width: 100%;
            max-width: 390px;
        }

        .sigap-form-inner h2 {
            margin: 0 0 0.45rem;
            color: var(--sigap-ink);
            font-size: 1.75rem;
            font-weight: 750;
            letter-spacing: -0.025em;
        }

        .sigap-form-inner > p {
            margin: 0 0 2rem;
            font-size: 0.9rem;
            color: var(--sigap-muted);
        }

        .sigap-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #334155;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .sigap-input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .sigap-input-group > .bi {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }

        .sigap-input-group input {
            width: 100%;
            padding: 0.82rem 2.75rem;
            border: 1px solid var(--sigap-border);
            border-radius: 0.75rem;
            outline: none;
            color: var(--sigap-ink);
            font-size: 0.9rem;
            background: #f8fafc;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .sigap-input-group input:focus,
        .sigap-input-group input:focus-visible {
            border-color: var(--sigap-blue);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
        }

        .sigap-toggle-password {
            position: absolute;
            right: 0.95rem;
            top: 50%;
            transform: translateY(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            z-index: 2;
        }

        .sigap-toggle-password .bi {
            font-size: 1rem;
            pointer-events: none;
        }

        .sigap-toggle-password:hover,
        .sigap-toggle-password:focus-visible {
            color: var(--sigap-blue);
            outline: none;
        }

        .sigap-row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0.25rem 0 1.5rem;
            color: var(--sigap-muted);
            font-size: 0.8rem;
        }

        .sigap-row-between label {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            cursor: pointer;
        }

        .sigap-row-between input {
            width: 0.95rem;
            height: 0.95rem;
            accent-color: var(--sigap-blue);
        }

        .sigap-row-between a {
            color: var(--sigap-blue);
            font-weight: 600;
            text-decoration: none;
        }

        .sigap-row-between a:hover,
        .sigap-contact-box a:hover { text-decoration: underline; }

        .sigap-btn-submit {
            width: 100%;
            padding: 0.85rem;
            border: none;
            border-radius: 0.75rem;
            background: var(--sigap-blue);
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(37,99,235,0.2);
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        }

        .sigap-btn-submit:hover {
            background: #1d4ed8;
            box-shadow: 0 10px 20px rgba(37,99,235,0.28);
            transform: translateY(-1px);
        }

        .sigap-btn-submit:focus-visible {
            outline: 3px solid rgba(37,99,235,0.3);
            outline-offset: 2px;
        }

        .sigap-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.6rem 0;
            color: #94a3b8;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .sigap-divider::before, .sigap-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--sigap-border);
        }

        .sigap-contact-box {
            padding: 0.9rem 1rem;
            border: 1px solid var(--sigap-border);
            border-radius: 0.75rem;
            text-align: center;
            color: var(--sigap-muted);
            font-size: 0.8rem;
            background: #f8fafc;
        }

        .sigap-contact-box a {
            color: var(--sigap-blue);
            font-weight: 600;
            text-decoration: none;
        }

        .sigap-error {
            margin: -0.8rem 0 1rem;
            color: #dc2626;
            font-size: 0.78rem;
        }

        @media (max-width: 768px) {
            body { padding: 0; }
            .sigap-wrapper {
                flex-direction: column;
                min-height: 100vh;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }
            .sigap-brand {
                display: flex;
                flex: 0 0 145px;
                width: 100%;
                padding: 1.25rem;
            }
            .sigap-logo {
                width: 48px;
                height: 48px;
                padding: 0.4rem;
                margin: 0 0 0.5rem;
                border-radius: 0.9rem;
            }
            .sigap-brand h1 { font-size: 1.25rem; }
            .sigap-brand p { display: none; }
            .sigap-brand-footer { display: none; }
            .sigap-form {
                align-items: flex-start;
                padding: 2.25rem 1.25rem;
            }
            .sigap-form-inner h2 { font-size: 1.5rem; }
        }

        @media (min-width: 769px) and (max-height: 760px) {
            .sigap-wrapper { min-height: 590px; }
            .sigap-form { padding-top: 2rem; padding-bottom: 2rem; }
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
                                  value="{{ old('email') }}" autocomplete="email" required autofocus>
                </div>
                @error('email')
                    <div class="sigap-error mb-2">{{ $message }}</div>
                @enderror
                <label class="sigap-label" for="password">Kata Sandi</label>
                <div class="sigap-input-group">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="password"
                           placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                    <button type="button"
                            class="sigap-toggle-password"
                            id="togglePassword"
                            aria-controls="password"
                            aria-label="Tampilkan kata sandi"
                            aria-pressed="false"
                            title="Tampilkan kata sandi">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="sigap-error mb-2">{{ $message }}</div>
                @enderror

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

</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        toggleIcon.className = isHidden ? 'bi bi-eye' : 'bi bi-eye-slash';
        togglePassword.setAttribute('aria-pressed', String(isHidden));
        togglePassword.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        togglePassword.setAttribute('title', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    });
</script>

</body>
</html>