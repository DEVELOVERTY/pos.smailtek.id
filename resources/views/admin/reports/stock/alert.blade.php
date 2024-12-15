
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
 
        <div class="row match-height">
            
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="expenseContent">
                            {{-- Content Product --}} 
                            <div class="table-responsive"> 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{__('produk.name')}}</th>
                                            <th>{{__('report.total_stock')}}</th>
                                            <th>{{__('general.image')}}</th>  
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach ($product as $d)
                                            <tr>  
                                                <td> {{ $d['name'] }} </td>
                                                <td> {{ number_format($d['stock']) }} </td>
                                                <td> <img src="{{ asset($d['image']) }}" style="width: 50px; border-radius: 10%"> </td> 
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>  
                            </div>
                            {{-- End Content --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
