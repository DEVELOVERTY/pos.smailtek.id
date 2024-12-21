<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page }}</title>
 
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pos.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select3/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/slick/slick.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/slick/slick-theme.min.css')}}" />
   
</head>

<body>
    <div id="app" class="hide-print">
        <div id="loader"></div>
        <div id="sound"></div>
        <div id="addcartlang" class="d-none">{{__('pos.add_cart')}}</div>

        <x-admin.lang-component></x-admin.lang-component>
        
        {{-- SIDEBAR COMPONENT --}}
        <x-pos.sidebar-component></x-pos.sidebar-component>
        {{-- END SIDEBAR --}}

        <form method="POST" id="main" class='layout-navbar cTransaction'>
            @csrf
            {{-- HEADER COMPONENT --}}
            <x-pos.top-header-component></x-pos.top-header-component>
            <x-pos.header-component></x-pos.header-component>
            {{-- END HEADER COMPONENT --}}

            <div id="main-content">

                @yield('content')

                {{-- FOOTER COMPONENT --}}
                <x-pos.footer-component></x-pos.footer-component>
                {{-- END FOOTER COMPONENT --}}

            </div>
        </form>
    </div>

    <div class="modal fade text-left" id="receipt" tabindex="-1" role="dialog" aria-labelledby="receipt"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="height: 90vh; width:50vh">
                <div class="modal-header">
                    <h4 class="modal-title" id="receipt">Receipt Struck</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times text-white"></i>
                    </button>
                </div>
                <div class="modal-body print-area" id="receiptbody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-primary buttonprint" onclick="printcepeipt(this.id)">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('pos.print')}}</span>
                    </button>
                    <button type="button" id="closeprint" class="btn btn-block btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('general.close')}}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
 
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/evolution.js') }}"></script>
    <script src="{{ asset('assets/vendors/slick/slick.min.js')}}"></script>  
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/evolution.js') }}"></script>  
    <script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/scanner/scanner.js') }}"></script>
    <script src="{{ asset('assets/vendors/select3/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/lang.js') }}"></script>
    <script src="{{ asset('js/connection.js') }}"></script>
    <script src="{{ asset('js/pos.js') }}"></script>
    <script src="{{ asset('js/mobile.js')}}"></script> 
</body>

</html>
