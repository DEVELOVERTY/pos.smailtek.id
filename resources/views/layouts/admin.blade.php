<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Netzen - POINT OF SALE" name="description">
    <meta content="PT. Netzen Media Akses" name="author">
    <link rel="shortcut icon" href="{{ asset('assets/images/icon.png') }}"" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="{{asset('theme/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('theme/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('theme/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/vendors/toastr/toastr.min.css')}}">
    @yield('styles')

</head>

<body data-sidebar="colored" data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <div id="loader"></div>
        <div id="sound"></div>
        <x-admin.lang-component></x-admin.lang-component>

        {{-- HEADER COMPONENT --}}
        <x-admin.header-component></x-admin.header-component>
        {{-- END HEADER COMPONENT --}}

        {{-- SIDEBAR COMPONENT --}}
        <x-admin.sidebar-component></x-admin.sidebar-component>
        {{-- END SIDEBAR --}}

        <div class="main-content">
            @yield('content')
            <!-- Footer Component Area -->
            <x-admin.footer-component></x-admin.footer-component>
            <!-- End Footer Component -->


        </div>
    </div>

    <div class="rightbar-overlay"></div>

    <script src="{{ asset('assets/jquery-3.3.1.min.js') }}"></script>
    <script src="{{asset('theme/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('theme/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('theme/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('theme/libs/node-waves/waves.min.js')}}"></script>

    <script src="{{asset('theme/js/app.js')}}"></script>

    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/evolution.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/evolution.js')}}"></script>
    <script src="{{ asset('assets/vendors/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/lang.js') }}"></script>
    <script src="{{ asset('js/connection.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @yield('scripts')

</body>

</html>
