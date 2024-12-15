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
                    @can("Tambah Potongan")
                    <a href="{{route('cutting.create')}}" class="btn btn-md btn-primary float-end"><i class="fa fa-plus"></i> {{__('hrm.add_deduction')}} </a>
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
                                            <th class="text-center"> # </th>
                                            <th>{{__('hrm.deduction_name')}}</th>
                                            <th>{{__('hrm.for')}}</th>
                                            <th>{{__('hrm.amount_deduction')}}</th>
                                            <th>{{__('hrm.deduction_circle')}}</th>
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
                                            <td>{{$d->name}}</td>
                                            <td>{{$d->designation->name ?? 'Seluruh Pegawai'}}</td>
                                            <td>{{number_format($d->amount)}}</td>
                                            <td>
                                                @if($d->priode == 'day')
                                                {{__('hrm.daily')}}
                                                @else
                                                {{__('hrm.monthly')}}
                                                @endif
                                            </td>
                                            <td>
                                                @can("Update Potongan")
                                                <a href="{{route('cutting.update',$d->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                @endcan
                                                @can("Hapus Potongan")
                                                <a href="{{route('cutting.delete',$d->id)}}" class="btn btn-sm btn-danger deletebutton"><i class="fas fa-trash"></i></a>
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