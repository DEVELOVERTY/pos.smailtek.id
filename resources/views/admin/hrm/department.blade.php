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
                    @can("Tambah Department")
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-md btn-primary float-end"><i class="fa fa-plus"></i> {{__('hrm.add_department')}} </a>
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
                        <a href="javascript:void(0)" class="d-none" id="update_d" data-bs-toggle="modal" data-bs-target="#update_department"></a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- COUNTRY  DATA -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> # </th>
                                            <th>{{__('hrm.department_name')}}</th>
                                            <th>{{__('hrm.total_designation')}}</th>
                                            <th>{{__('general.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($data as $d)
                                        <tr class="edit_department">
                                            <td>{{$no++}}
                                                <p id="di" class="d-none">{{$d->id}}</p>
                                            </td>
                                            <td>
                                                <p id="dn">{{$d->name}}</p>
                                            </td>
                                            <td>{{count($d->designation)}}</td>
                                            <td>
                                                @can("Update Department")
                                                <a href="javascript:void(0)" class="btn btn-sm btn-warning department">{{__('hrm.update_department')}}</a>
                                                @endcan
                                                @can("Hapus Department")
                                                <a href="{{route('department.delete',$d->id)}}" class="btn btn-sm btn-danger deletebutton">{{__('hrm.delete_department')}}</a>
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
@can("Tambah Department")
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{route('department.store','create')}}" class="modal-content">
            @csrf
            <div class="modal-header header-modal">
                <h5 class="modal-title text-white" id="add">{{__('hrm.add_department')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name">{{ __('hrm.department_name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required id="name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.close')}}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.add')}}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endcan
@can("Update Department")
<div class="modal fade" id="update_department" tabindex="-1" role="dialog" aria-labelledby="update_department" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{route('department.store','up')}}" class="modal-content">
            @csrf
            <div class="modal-header header-warning">
                <h5 class="modal-title" id="">{{__('hrm.update_department')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name">{{ __('hrm.department_name') }}</label>
                    <input type="hidden" name="id" id="department_id" value="">
                    <input type="text" class="form-control" id="department_name" name="name" value="{{ old('name') }}" required>
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
@endcan

@section('scripts')
<script src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/datatables.js')}}"></script>
<script src="{{asset('js/department.js')}}"></script>
@endsection
@endsection