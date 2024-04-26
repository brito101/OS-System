<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>@yield('title')</title>
    <style>
        * {
            font-family: "Arial", sans-serif;
            font-size: 14px;
        }

        @page {
            margin: 100px 70px;
        }

        header {
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            text-align: center;
        }

        h1 {
            margin-top: -20px;
            font-size: 22px;
            color: #252323;
            margin: 20px auto;
            width: 375px;
        }

        main {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <header>
        <img style="width: 260px" alt="{{ env('APP_NAME') }}" src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(public_path('img/logo-os.png'))); ?>">
        <h1>@yield('title')</h1>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
