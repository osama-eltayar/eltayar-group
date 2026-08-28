<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('user.accept_invitation') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f3f4f6;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .card {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            padding: 32px;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 4px;
        }

        p.subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        input[type="password"]:focus {
            outline: none;
            border-color: #f59e0b;
        }

        button {
            width: 100%;
            padding: 10px 12px;
            background: #f59e0b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #d97706;
        }

        .errors {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .errors ul {
            list-style: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>{{ __('user.accept_invitation') }}</h1>
        <p class="subtitle">{{ $user->name }} ({{ $user->email }})</p>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('invitation.store', $token) }}">
            @csrf

            <label for="password">{{ __('user.new_password') }}</label>
            <input type="password" id="password" name="password" required autofocus>

            <label for="password_confirmation">{{ __('user.confirm_password') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">{{ __('user.set_password') }}</button>
        </form>
    </div>
</body>
</html>
