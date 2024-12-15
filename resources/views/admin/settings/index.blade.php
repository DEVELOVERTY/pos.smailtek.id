@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/css/dropify.min.css')}}">
@endsection 
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div id="errors"></div>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" class="form form-vertical" id="uSetting">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{ __('settings.system_name') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="name" value="{{ old('name',$settings->name ?? '') }}" required id="system_name"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="email-id-icon">{{ __('settings.d_mail') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="default_email" value="{{ old('default_email',$settings->default_email ?? '') }}" id="email-id-icon"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="mobile-id-icon">{{ __('settings.d_phone') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="default_phone" value="{{ old('default_phone',$settings->default_phone ?? '') }}" id="mobile-id-icon"> 
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="smtp_host">{{ __('settings.smtp_host') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="smtp_host" value="{{ old('smtp_host',$settings->smtp_host ?? '') }}" id="smptp_host"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="port">{{ __('settings.smtp_port') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="port" value="{{ old('port',$settings->port ?? '') }}" id="port"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="username">{{ __('settings.smtp_username') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="username" value="{{ old('username',$settings->username ?? '') }}" id="username"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="password">{{ __('settings.smtp_password') }}</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" name="password" id="password"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="encrypt">{{ __('settings.smtp_encrypt') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="encrypt" value="{{ old('encrypt',$settings->encrypt ?? '') }}" id="encrypt"> 
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="ftp_host">{{ __('settings.ftp_host') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="host" value="{{ old('host',$settings->host ?? '') }}" id="ftp_host"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="ftp_user">{{ __('settings.ftp_username') }}</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="user" value="{{ old('user',$settings->user ?? '') }}" id="ftp_user"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="ftp_password">{{ __('settings.ftp_password') }}</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" name="pass" id="ftp_password"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group has-icon-left">
                                                <label for="rest_api">Masukkan Rest Api</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="rest_api" value="{{$settings->rest_api}}" id="restapi">
                                                    <button class="btn btn-info" type="button" id="getrest"><i class="fas fa-random"></i></button>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="divider">
                                            <div class="divider-text mb-3 mt-3">{{ __('settings.system_logo') }}</div>
                                        </div>

                                        <div class="col-12 mb-5">
                                            <input class="dropify" type="file" id="logo" name="logo" data-default-file="{{ asset(old('logo',$settings->logo ?? ''))}}">
                                        </div>

                                        <div class="col-12 d-flex justify-content-end mt04">
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
    </div>
</div>

@section('scripts')
<script src="{{ asset('assets/vendors/dropify/js/dropify.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
    });
</script>
@endsection
@endsection