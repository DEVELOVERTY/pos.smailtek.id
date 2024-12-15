@extends('layouts.admin')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div class="row">
            @if ($variation != '')
            <div class="col-xl-4 col-md-6 col-sm-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{__('report.product_popular')}}</h5>
                    </div>
                    <div class="card-content">
                        <img src="{{ asset($variation->gambar->path ?? 'uploads/image.jpg') }}" class="card-img-top img-fluid" alt="singleminded">
                        <div class="card-body">
                            <h5 class="card-title">{{ $variation->product->name ?? '' }} @if ($variation->name != 'no-name') {{ $variation->name }} @endif
                            </h5>
                            <p class="card-text">
                                <?= $variation->product->description ?>
                            </p>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item"><b>{{ $data->quantity }}</b> Terjual</li>
                        <li class="list-group-item">{{__('purchase.unit_cost')}}<b>: {{ my_currency($variation->selling_price) }}</b></li>
                    </ul>
                </div>
            </div>
            @endif
            <div class="col-xl-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{__('report.ten_popular')}}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {{-- Content Product --}}
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{__('produk.name')}}</th>
                                            <th>{{__('report.sell')}}</th>
                                            <th>{{__('purchase.unit_cost')}}</th>
                                            <th>{{__('general.image')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product as $p)
                                        <tr>
                                            <td>{{ $p['name'] }}</td>
                                            <td>{{ $p['selling'] }}</td>
                                            <td>{{ number_format($p['unit_price']) }}</td>
                                            <td> <img src="{{ asset($p['image']) }}" style="width: 50px; border-radius: 10%"> </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection