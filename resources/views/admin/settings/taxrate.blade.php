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
                    @can("Tambah Pajak")
                    <a class="btn btn-md btn-primary float-end" href="{{route('taxrate.create')}}"><i class="fa fa-plus"></i> {{__('settings.add_taxrate')}}</a>
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
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> No </th>
                                            <th>{{__('settings.taxrate_name')}}</th>
                                            <th>{{__('settings.taxrate_code')}}</th>
                                            <th>{{__('settings.percentase_tax')}}</th>
                                            <th>{{__('general.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($data as $d)
                                        <tr>
                                            <td>{{$no++}} </td>
                                            <td> {{$d->name}} </td>
                                            <td> {{$d->code}} </td>
                                            <td> {{$d->taxrate}} </td>
                                            <td>
                                                @can("Update Pajak")
                                                <a href="{{route('taxrate.update',$d->id)}}" class="btn btn-warning">{{__('update')}}</a>
                                                @endcan
                                                @can("Hapus Pajak")
                                                <a href="{{route('taxrate.delete',$d->id)}}" class="btn btn-danger deletebutton">{{__('delete')}}</a>
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
@endsection
@endsection