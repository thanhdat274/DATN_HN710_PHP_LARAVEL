<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .icon {
            font-size: 48px;
            color: #ff5e5e;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="icon">⚠️</div>
        <h1>@yield('title_code')</h1>
        <p>@yield('message')</p>
        @if (!request()->is('admin/*'))
        <!-- Nếu không ở khu vực admin (tức là user) -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Quay lại</a>
        @endif
        @if (request()->is('admin/*'))
        <!-- Nếu đang ở trang quản trị -->
        <a href="{{ url('/admin') }}" class="btn btn-secondary">Trở về trang chủ</a>
        @else
        <!-- Nếu đang ở trang người dùng -->
        <a href="{{ url('/') }}" class="btn btn-secondary">Trở về trang chủ</a>
        @endif
    </div>
</body>

</html>