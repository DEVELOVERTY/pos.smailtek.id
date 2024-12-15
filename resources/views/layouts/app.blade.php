<!doctype html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <title>{{ $page ?? 'MDHPOS' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Netzen - POINT OF SALE" name="description">
    <meta content="PT. Netzen Media Akses" name="author">
    <link rel="shortcut icon" href="{{ asset('theme/images/icon.png') }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="{{asset('theme/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('theme/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('theme/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css">

</head>

<body class="auth-pages" style="background-color: #fff;"> 

        <x-admin.lang-component></x-admin.lang-component>
        @yield('content')
        
    </body>

</html>