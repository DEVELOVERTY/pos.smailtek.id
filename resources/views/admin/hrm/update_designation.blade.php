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
                    @can("Daftar Designation")
                    <a href="{{route('designation.index')}}" class="btn btn-md btn-primary float-end"><i class="fa fa-list"></i> {{__('sidebar.designation')}} </a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" id="uDesignation" class="row">
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('hrm.department_name')}}</h6>
                                    <div class="form-group">
                                        <select class="form-select" name="department_id" id="department">
                                            <option value="">{{__('hrm.choose_department')}}</option>
                                            @foreach($data as $d)
                                            <option value="{{$d->id}}" @if($d->id == old('department_id',$designation->department_id)) selected @endif>{{$d->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('hrm.designation_name')}}</h6>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{ $designation->id }}" id="designation_id">
                                        <input type="text" name="name" value="{{old('name',$designation->name)}}" id="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-primary me-1 mb-1">{{__('general.save')}}</button>
                                    <a href="{{route('designation.index')}}" class="btn btn-light-secondary me-1 mb-1">{{__('general.back')}}</a>
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