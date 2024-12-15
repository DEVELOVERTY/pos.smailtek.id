@extends('layouts.pos_mobile')
@section('content')
<x-pos-mobile.header-component></x-pos-mobile.header-component>

<div class="osahan-main">
    <x-pos-mobile.category-component></x-pos-mobile.category-component> 
    <div class="px-3 pt-4 pb-3 title d-flex align-items-center">
        <h6 class="m-0 font-weight-bold">Daftar Produk</h6> 
    </div> 
    <x-pos-mobile.product-component></x-pos-mobile.product-component>
</div>

<div class="fixed-bottom p-3">
    <a href="javascript:void(0);" data-toggle="modal" data-target="#billingmodal" class=" btn btn-success btn-block btn-lg text-white rounded shadow text-decoration-none d-flex align-items-center shadow ">
        <div class="border-right pr-3">
            <h4 class="m-0">
                <i class="feather-shopping-bag" aria-hidden="true"></i>
            </h4>
        </div>
        <div class="ml-3 text-left"> 
            <input type="hidden" name="fixtotal" id="jumlahtotal" value="0">
            <p class="mb-0 font-weight-bold text-white" id="fixTotal">0</p>
        </div>
        <div class="ml-auto">
            <p class="mb-0 text-white"> Lihat Billing <i class="feather-chevron-right pl-2" aria-hidden="true"></i>
            </p>
        </div>
    </a>
</div>
@endsection