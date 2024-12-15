@extends('layouts.admin')
@section('content')

@section('styles')

@endsection

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Daftar Customer")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('customer.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.customer') }}</a>
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
                            <form id="cCustomer" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('customer.name')}}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name" required placeholder="{{__('customer.name')}} ">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.phone')}}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="phone" value="{{ old('phone') }}" id="phone" required placeholder="{{__('general.phone')}} ">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.email')}}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" required placeholder="{{__('general.email')}} ">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.code')}}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="code" value="{{ old('code') }}" id="code" required placeholder="{{__('general.code')}} ">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.city')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" id="city" required placeholder="{{__('general.city')}} ">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.address')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control" name="address" id="address">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.detail')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control" name="detail" id="detail">{{ old('detail') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button class="btn btn-info me-1 mb-1">{{__('general.add')}}</button>
                                        <button type="reset" class="btn btn-secondary me-1 mb-1">{{__('general.reset')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @section('scripts')

    @endsection
    @endsection