<!DOCTYPE html>
<html lang="id"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <link rel="shortcut icon" href="{{ asset('assets/images/icon.png') }}" type="image/x-icon">
    <title>{{$page}}</title>

    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/slick/slick.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/slick/slick-theme.min.css')}}" />

    <link href="{{asset('assets/vendors/icons/feather.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('assets/vendors/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">
    <link href="{{asset('assets/mobile/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select3/dist/css/select2.min.css') }}" />
</head>

<body class="fixed-bottom-bar">
    <div id="loader"></div>
    <div id="sound"></div>
    <div id="addcartlang" class="d-none">{{__('pos.add_cart')}}</div>
    <x-admin.lang-component></x-admin.lang-component>
    <form method="POST" id="cTransaction">
        @csrf
        <div class="mdhpos-home-page">
            @yield('content')
        </div>

        <x-pos-mobile.filter-component></x-pos-mobile.filter-component>

        <x-pos-mobile.billing-component></x-pos-mobile.billing-component>
    </form>

    <div class="modal fade" id="receipt" tabindex="-1" role="dialog" aria-labelledby="paymodalLabel" aria-hidden="true">
        <div class="modal-dialog payment_modal">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="exampleModalLabel">Struk Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="feather-x float-right"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="mdhpos-filter">
                        <div class="filter">
                            <div class="filters-body" >
                                <div id="receiptbody"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0 border-0 p-3">
                    <div class="col-12 m-0 pr-0 pl-1">
                        <button type="button" class="btn btn-lg btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/jquery-3.3.1.min.js') }}"></script>
    <script src="{{asset('assets/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script> 
    <script src="{{asset('assets/vendors/slick/slick.min.js')}}"></script>  
    
    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/evolution.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/evolution.js') }}"></script>
    <script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/lang.js') }}"></script>
    <script src="{{ asset('js/connection.js') }}"></script>
    <script src="{{ asset('assets/vendors/select3/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/pos_mobile.js') }}"></script>

    <script src="{{asset('js/mobile.js')}}" ></script> 
    
    

</body>

</html>