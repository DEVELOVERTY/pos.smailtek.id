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
                    @can("Daftar Printer")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('printer.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.printer') }}</a>
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
                            <form id="cPrinter" method="POST" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('settings.printer_name')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" placeholder="{{__('settings.printer_name')}} ">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.type')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="type" id="type">
                                                <option value="offline">Sharing Printer</option>
                                                <option value="online">Rest Api</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 d-none" id="label-url">
                                            <label>Url Rest Api</label>
                                        </div>
                                        <div class="col-md-8 form-group d-none" id="form-url">
                                            <input type="url" name="url" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- END URL -->
                                        <div class="col-md-4">
                                            <label>{{__('settings.char_by_line')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" name="char_per_line" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('settings.ip_address')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" name="ip_address" class="form-control" placeholder="{{__('settings.ip_address')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-primary me-1 mb-1">{{__('settings.add_printer')}}</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">{{ __('general.reset') }}</button>
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