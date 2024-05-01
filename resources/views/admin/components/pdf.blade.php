<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <style>
        * {
            font-family: "Arial", sans-serif;
            font-size: 12px;
            letter-spacing: .075rem;
            color: #252323;
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
            margin: 20px auto;
            width: 400px;
            letter-spacing: .085rem;
        }

        main {
            margin-top: 50px;
        }

        td {
            font-size: 14px;
            font-weight: normal;
            text-align: left;
            height: 25px;
        }

        .dot {
            height: 17.5px;
            width: 20px;
            margin-right: 10px;
            margin-bottom: -3px;
            border: 1px solid #252323;
            border-radius: 50%;
            display: inline-block;
        }

        .td-title {
            font-weight: bold;
            font-size: 18px;
            height: 35px;
            position: relative;
            padding-bottom: 5px;
        }

        .td-title::before {
            content: "";
            width: 15px;
            height: 3px;
            position: absolute;
            left: 0;
            top: 30px;
            background: #252323;
            border-radius: 10%;
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
