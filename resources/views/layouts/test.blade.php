<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('styles')
        <style>
            body{
                background: -webkit-linear-gradient(left, #3931af, #00c6ff);
            }
        </style>
    </head>

    <body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
        <div class="app flex-row align-items-center">
            <div class="container">
                @yield("content")
            </div>
        </div>
        @yield('scripts')
    </body>

</html>
