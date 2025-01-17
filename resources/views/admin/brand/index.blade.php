@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                @can("Tambah Brand")
                    <a class="btn btn-md btn-primary float-end" href="{{route('brand.create')}}"><i class="fa fa-plus"></i> {{__('settings.add_brand')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>  
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body"> 
                            <!-- COUNTRY  DATA -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> ID </th>
                                            <th>{{__('settings.brand_name')}}</th>
                                            <th>{{__('general.code')}}</th>
                                            <th>{{__('general.detail')}}</th>
                                            <th>{{ __('general.image') }}</th>
                                            <th>{{__('general.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($data as $d)
                                        <tr>
                                            {{-- <td>{{$no++}} </td> --}}
                                            <td class="text-center"> {{$d->id}} </td>
                                            <td> {{$d->name}} </td>
                                            <td> {{$d->code}} </td>
                                            <td> {{$d->detail}} </td>
                                            <td></td> <img src="{{ asset($d->image ?? 'assets/images/image.png') }}" width="60px"> </td>
                                            <td>
                                                @can("Update Brand")
                                                <a href="{{route('brand.update',$d->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                @endcan
                                                @can("Hapus Brand")
                                                <a href="{{route('brand.delete',$d->id)}}" class="btn btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                                                @endcan
                                            </td>
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

@section('scripts')
<script src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/datatables.js')}}"></script>
<script src="{{asset('js/currency.js')}}"></script>
@endsection
@endsection