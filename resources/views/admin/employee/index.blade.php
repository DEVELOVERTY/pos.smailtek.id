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
                    @can("Tambah Pegawai")
                    <a href="{{ route('employee.create') }}" class="btn btn-md btn-primary float-end"><i class="fa fa-plus"></i> {{__('sidebar.add_employee')}} </a>
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
                                            <th>#</th>
                                            <th>{{__('hrm.employee_name')}}</th>
                                            <th>{{__('hrm.designation_name')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('general.phone')}}</th>
                                            <th width="110px"><span class="fa fa-cogs"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach ($data as $c)
                                        <tr class="data-product">
                                            <td> {{ $no++ }} </td>
                                            <td> {{ $c->user->name ?? '' }} </td>
                                            <td> {{ $c->designation->name ?? '' }} </td>
                                            <td> {{ $c->user->store->name ?? __('user.all_store') }} </td>
                                            <td> {{ $c->phone ?? '' }} </td>
                                            <td>
                                                @can("Update Pegawai")
                                                <a href="{{ route('employee.update',$c->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                @endcan
                                                @can("Hapus Pegawai")
                                                <a href="{{ route('employee.delete',$c->id) }}" class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
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