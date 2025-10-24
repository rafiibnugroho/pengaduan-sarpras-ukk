<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Sarpras</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #0d47a1; /* biru tua */
            font-family: 'Poppins', sans-serif;
        }
        .auth-container {
            max-width: 360px;
            margin: auto;
            padding: 30px;
            color: white;
            text-align: center;
        }
        .auth-box {
            background: #1565c0;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .auth-input {
            border-radius: 12px;
            padding: 12px;
        }
        .btn-custom {
            border-radius: 12px;
            background: #42a5f5;
            color: white;
            font-weight: bold;
            padding: 12px;
        }
        .btn-custom:hover {
            background: #1e88e5;
        }
        a {
            color: #bbdefb;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        @yield('content')
    </div>
</body>
</html>
