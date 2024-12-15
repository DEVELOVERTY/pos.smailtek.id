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
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="uPrinter" method="POST" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('settings.printer_name')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="{{ old('name',$data->name) }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.type')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="type" id="type">
                                                @if($data->type == 'offline')
                                                <option value="offline">Sharing Printer</option>
                                                <option value="online">Rest Api</option>
                                                @elseif($data->type == 'online')
                                                <option value="online">Rest Api</option>
                                                <option value="offline">Sharing Printer</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 @if($data->type != 'online') d-none @endif" id="label-url">
                                            <label>Url Rest Api</label>
                                        </div>
                                        <div class="col-md-8 form-group @if($data->type != 'online') d-none @endif" id="form-url">
                                            <input type="hidden" name="id" value="{{ $data->id }}" id="id">
                                            <input type="url" name="url" class="form-control" value="{{ old('url',$data->url) }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('settings.char_by_line')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" name="char_per_line" class="form-control" value="{{ old('char_per_line',$data->char_per_line) }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('settings.ip_address')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" name="ip_address" class="form-control" value="{{ old('ip_address',$data->ip_address) }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-info me-1 mb-1">{{__('settings.update_printer')}}</button>
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