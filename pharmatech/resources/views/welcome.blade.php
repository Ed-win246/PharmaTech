<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PharmaTech</title>
        <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    </head>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fbfefc;
            font-family: sans-serif;
        }
        .spinner-container {
            text-align: center;
        }
        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #e2e8f0;
            border-top: 6px solid #01fd01f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        p {
            color: #475569;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="spinner-container">
        <div class="spinner"></div>
        <p>Loading PharmaTech Solutions...</p>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "{{ url('/login') }}";
        }, 2000);
    </script>
</body>
</html>

