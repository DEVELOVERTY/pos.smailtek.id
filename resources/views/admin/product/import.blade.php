@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/css/dropify.min.css')}}">
@endsection

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">`
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can('Daftar Produk')
                    <a class="btn btn-md btn-primary float-end" href="{{ route('product.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.product') }}</a>
                    @endcan
                </div>
            </div>
        </div>

        <x-admin.validation-component></x-admin.validation-component>

        <div class="row match-height">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Langkah-Langkah Import Data Produk</h4>
                        <p class="card-title-desc">Berikut penjelasan untuk mengimport produk</p>


                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#documentasiImport" aria-expanded="true" aria-controls="documentasiImport">
                                        Documentasi Import
                                    </button>
                                </h2>
                                <div id="documentasiImport" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h5 class="mb-4">Perhatian</h5>
                                        <h6>LAST ID PRODUCT : {{ $lastProductId }}</h6>
                                        <br><h6>Type Barcode :</h6>
                                        <br><ul>
                                            <li>c128</li>
                                            <li>c39</li>
                                            <li>ean13</li>
                                            <li>ean8</li>
                                            <li>upcA</li>
                                            <li>upcE</li>
                                        </ul>
                                        <br>Pastikan bahwa format file yang diimport berbentuk <b><small>.xlsx</small></b>, 
                                        <br>Untuk mempermudah proses import, silahkan download sample file yang telah disediakan.
                                        <br>Untuk product dan variant, silahkan download file dibawah ini.
                                        <br>Variant diimport jika menggunaka type variabel di product.
                                        <br>Jika type single maka <b>p_price</b>, <b>s_price</b>,	<b>mrg</b> harus diisi pada format product dan pada variant tidak perlu diisi   
                                        <br>Jika type variabel maka <b>purchase_price</b>, <b>selling_price</b>, <b>margin</b> harus diisi pada format variant
                                        <h5 class="mb-4">Format ( Untuk Import Produk)</h5>
                                        <table class="table" style="background-color: green; overflow-x: auto; display: block; white-space: nowrap;">
                                            <tr class="text-white">
                                                <th>ID</th>
                                                <th>NAME (Nama Product)</th>
                                                <th>SKU PRODUCT</th>
                                                <th>TYPE</th>
                                                <th>CATEGORY</th>
                                                <th>SUBCATEGORY</th>
                                                <th>BRAND ID</th>
                                                <th>UNIT ID</th>
                                                <th>BARCODE TYPE</th>
                                                <th>ALERT QUANTITY</th>
                                                <th>WEIGHT</th>
                                                <th>DESCRIPTION</th>
                                                <th>P PRICE (Purchase Price)</th>
                                                <th>S PRICE (Sell Price)</th>
                                                <th>MRG (Margin)</th>
                                            </tr>
                                        </table>
                                        <h5 class="mb-4">Format ( Untuk Import Variant)</h5>
                                        <table class="table" style="background-color: #00b050;">
                                            <tr class="text-white">
                                                <th>PRODUCT ID (Dilihat di menu Product)</th>
                                                <th>SKU VARIANT</th>
                                                <th>NAME</th>
                                                <th>PURCHASE PRICE</th>
                                                <th>SELLING PRICE</th>
                                                <th>MARGIN</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12">
                    <div class="card-header header-modal ">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                            </div>
                            <div class="col-6">
                                <a href="{{asset('assets/product.xlsx')}}" target="_blank" class="btn btn-sm btn-success float-end" style="margin-top: -9px; border: 2px solid white; margin-top: -6px"><i class="fas fa-download"></i> Download Sample Import </a>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{route('product.import_store')}}" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                @csrf
                                <div class="form-body">

                                    <div class="row mb-3">
                                        <div class="col-md-12 form-group">
                                            <label>Upload File, (xlsx)</label>
                                            <input class="dropify" type="file" id="file" name="file" data-default-file="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button class="btn btn-info me-1 mb-1">Import Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card-header header-modal ">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }} Variant</h5>
                            </div>
                            <div class="col-6">
                                <a href="{{asset('assets/variant.xlsx')}}" target="_blank" class="btn btn-sm btn-success float-end" style="margin-top: -9px; border: 2px solid white; margin-top: -6px"><i class="fas fa-download"></i> Download Sample Import </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{route('product.import_variant_store')}}" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                @csrf
                                <div class="form-body">

                                    <div class="row mb-3">
                                        <div class="col-md-12 form-group">
                                            <label>Upload File, (xlsx)</label>
                                            <input class="dropify" type="file" id="file_variant" name="file_variant" data-default-file="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button class="btn btn-info me-1 mb-1">Import Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</div>

@section('scripts')
<script src="{{ asset('assets/vendors/dropify/js/dropify.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
@endsection
@endsection