<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SIKANDIS</title>
    <style>
        :root {
            --blue-900: #0b1220;
            --blue-800: #0f172a;
            --blue-700: #1d4ed8;
            --blue-600: #2563eb;
            --blue-500: #3b82f6;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-300: #cbd5e1;
            --slate-200: #e2e8f0;
            --white: #ffffff;
            --shadow: 0 24px 80px rgba(15, 23, 42, 0.22);
        }

        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background:
                radial-gradient(1100px 520px at 10% 10%, rgba(59, 130, 246, 0.18) 0%, rgba(59, 130, 246, 0) 60%),
                radial-gradient(900px 480px at 90% 20%, rgba(37, 99, 235, 0.14) 0%, rgba(37, 99, 235, 0) 55%),
                linear-gradient(135deg, #0b1220 0%, #0f172a 45%, #0b1220 100%);
        }

        .card {
            width: 100%;
            max-width: 440px;
            background: rgba(15, 23, 42, 0.92);
            border-radius: 18px;
            padding: 22px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(148, 163, 184, 0.25);
            overflow: hidden;
            position: relative;
        }

        .card:before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(37, 99, 235, 0.10) 0%, rgba(37, 99, 235, 0) 55%);
            pointer-events: none;
        }

        .brand {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(180deg, var(--blue-600) 0%, var(--blue-700) 100%);
            box-shadow: 0 10px 28px rgba(37, 99, 235, 0.28);
        }

        h1 {
            margin: 0;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.95);
            letter-spacing: 0.2px;
        }

        p {
            margin: 0 0 16px;
            color: rgba(226, 232, 240, 0.78);
            font-size: 13px;
            position: relative;
        }

        .field { margin-bottom: 12px; position: relative; }
        label { display: block; font-size: 12px; color: var(--slate-600); margin-bottom: 6px; font-weight: 700; }

        input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 12px;
            outline: none;
            transition: box-shadow 160ms ease, border-color 160ms ease;
            background: rgba(2, 6, 23, 0.55);
            color: rgba(255, 255, 255, 0.92);
        }

        input:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.18);
        }

        .btn {
            width: 100%;
            padding: 11px 12px;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(180deg, var(--blue-600) 0%, var(--blue-700) 100%);
            color: #fff;
            cursor: pointer;
            font-weight: 800;
            letter-spacing: 0.2px;
            transition: transform 120ms ease, box-shadow 160ms ease;
            box-shadow: 0 14px 34px rgba(37, 99, 235, 0.25);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 46px rgba(37, 99, 235, 0.30);
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
            font-weight: 700;
        }

        .hint {
            margin-top: 14px;
            font-size: 12px;
            color: rgba(226, 232, 240, 0.78);
            padding: 0;
            border-radius: 0;
            border: 0;
            background: transparent;
            position: relative;
        }

        code { background: rgba(148, 163, 184, 0.16); color: rgba(255, 255, 255, 0.9); padding: 2px 6px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <div class="brand-mark"></div>
            <div>
                <h1>Login SIKANDIS</h1>
                <p>Masuk sebagai admin atau operator.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="field">
                <label for="login">Username / Email</label>
                <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus>
                @error('login')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
