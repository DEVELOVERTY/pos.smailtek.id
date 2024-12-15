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
                    <a class="btn btn-md btn-primary float-end" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add"><i class="fa fa-plus"></i> {{ __('sidebar.add_product') }}</a>
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
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> No </th>
                                            <th>{{__('user.permission_name')}}</th>
                                            <th>{{__('user.guard_name')}}</th>
                                            <th>{{__('general.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($data as $d)
                                        <tr class="edit_permission">
                                            <td>{{$no++}} </td>
                                            <td>
                                                <p id="pn">{{$d->name}}</p>
                                            </td>
                                            <td>
                                                <p id="pi" class="d-none">{{$d->id}}</p> {{ $d->guard_name }}
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-warning permission"><i class="fas fa-edit"></i></a>
                                                <a href="{{route('permission.delete',$d->id)}}" class="btn btn-sm btn-danger deletebutton"><i class="fas fa-trash"></i></a>
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

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{route('permission.store','create')}}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="add">{{__('user.add_permission')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="time">{{__('user.permission_name')}} {{__('user.permission_alert')}}</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.close')}}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('user.add_permission')}}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="update_permission" tabindex="-1" role="dialog" aria-labelledby="update_permission" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{route('permission.store','up')}}" class="modal-content">
            @csrf
            <div class="modal-header header-warning">
                <h5 class="modal-title" id="">{{__('user.update_permission')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="time">{{__('user.permission_name')}} {{__('user.permission_alert')}}</label>
                    <input type="hidden" name="id" id="permission_id" value="">
                    <input type="text" class="form-control" id="permission_name" name="name" value="" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.close')}}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.save')}}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@section('scripts')
<script src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/datatables.js')}}"></script>
@endsection
@endsection