<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page }}</title>
    @yield('styles')
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <style type="text/css">
       
        @media  print{
           

        }
    </style>
    <script>window.print()</script>
</head>

<body>

    <div class="row" style="break-after:page" >
        @foreach ($product as $p)
            <div class="col-2 mb-2">
                @if(isset($option['product_name'])) 
                <p class="bproductname" style="font-size: 8px;">
                    <b>{{ $p['name'] }}</b> 
                </p> 
                @endif 
                <img class="product_barcode" id="barcode_img" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($p['barcode'], $p['type']) }}" height="30" width="110" style="margin-top: -16px">
                <div class="row">
                    @if(isset($option['barcode_number']))
                    <div class="col-6 bbarcode">
                        <div style="font-size: 8px;">{{ $p['barcode'] }} </div>
                    </div>
                    @endif
                    @if(isset($option['product_price']))
                    <div class="col-6 bprice">
                        <div style="font-size: 8px; ">{{ $p['price'] }} </div>
                    </div>
                    @endif
                    @if(isset($option['store_name']))
                    <div class="col-12 btoko">
                        <div style="font-size: 10px; margin-top:-5px">{{ $store->name }} </div>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach

    </div>

    <script src="{{ asset('assets/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
