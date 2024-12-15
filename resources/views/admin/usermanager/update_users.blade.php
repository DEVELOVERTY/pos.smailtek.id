@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
@endsection
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Daftar Users")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('user.index') }}"><i class="fa fa-list"></i> {{__('sidebar.user')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="uUsers" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('user.name')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="{{ $users->id }}">
                                            <input type="text" class="form-control" name="name" value="{{ old('name',$users->name) }}" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.email')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="email" class="form-control" name="email" value="{{ old('email',$users->email) }}" id="email" required placeholder="{{__('general.email')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__("user.password")}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="{{__("user.password")}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('store.choose_timezone')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control choices" name="timezone">
                                                @foreach ($timezone as $t => $value)
                                                <option value="{{ $value }}" @if($value==$users->timezone) selected @endif>{{ $t }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('store.choose_store')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="store_id">
                                                <option value="0">{{__('user.all_store')}}</option>
                                                @foreach ($store as $s)
                                                <option value="{{ $s->id }}" @if($s->id == old('store_id',$users->store_id)) selected @endif>{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('user.choose_role')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="role_id">
                                                @foreach ($data as $d)
                                                <option value="{{ $d->id }}" @if($d->id == $users->role) selected @endif>{{ $d->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.image')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="dropify" type="file" id="photo" name="photo" data-default-file="{{ asset(old('photo',$users->photo ?? ''))}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-info me-1 mb-1">{{ __('general.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>

    </div>

    @section('scripts')
    <script src="{{ asset('assets/vendors/dropify/js/dropify.min.js') }}"></script>
    <script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();
        });
    </script>
    @endsection
    @endsection