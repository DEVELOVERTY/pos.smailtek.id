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
                    @can("Daftar Unit")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('unit.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.unit') }}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" id="uUnit" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('settings.unit_name')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.code')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" id="dataid" name="id" value="{{ $data->id }}">
                                            <input type="text" id="code" name="code" class="form-control" value="{{ $data->code }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.detail')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control" id="detail">{{ $data->detail }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-info me-1 mb-1">{{__('settings.update_unit')}}</button>
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