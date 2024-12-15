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
                    @can("Daftar Role")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('role.index') }}"><i class="fa fa-list"></i> {{__('sidebar.role')}}</a>
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
                            <form action="{{ route('role.store', 'create') }}" method="POST"
                                enctype="multipart/form-data" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('user.role_name')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name"  value="" id="name" required  >
                                        </div> 

                                        <div class="divider mt-2 mb-0">
                                            <div class="divider-text">{{ __('sidebar.role') }}</div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('user.permission_name')}}</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($permission as $p)
                                                    <tr class="">
                                                        <td>
                                                            <div class="form-check">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="form-check-input form-check-primary"  name="permission_id[]" value="{{ $p->id }}" id="permission_id">
                                                                    <label class="form-check-label" for="permission_id">{{ $p->name }}</label>
                                                                </div>
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" id="send"   class="btn btn-info me-1 mb-1">{{ __('save') }}</button>
                                            <button type="reset"
                                                class="btn btn-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
