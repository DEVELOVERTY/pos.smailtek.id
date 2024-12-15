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
                    @can("Tambah Role")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('role.create') }}"><i class="fa fa-plus"></i> {{__('user.add_role')}}</a>
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
                        <a href="javascript:void(0)" class="d-none" id="update_p" data-bs-toggle="modal" data-bs-target="#update_permission"></a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- COUNTRY  DATA -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> No </th>
                                            <th>{{__('user.role_name')}}</th>
                                            <th>{{__('user.permission_get')}} : </th>
                                            <th>{{__('action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($data as $d)
                                        <tr>
                                            <td>{{$no++}} </td>
                                            <td>{{$d->name}}</p>
                                            </td>
                                            <td>
                                                <?php $count = 0; ?>
                                                @foreach($d->permissions as $p)
                                                <?php if ($count == 10) break; ?>
                                                <span class="badge bg-primary">{{ $p['name'] }}</span>
                                                <?php $count++; ?>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('role.update',$d->id) }}" class="btn btn-sm btn-warning "><i class="fas fa-edit"></i></a>
                                                <a href="{{route('role.delete',$d->id)}}" class="btn btn-sm btn-danger deletebutton"><i class="fas fa-trash"></i></a>
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