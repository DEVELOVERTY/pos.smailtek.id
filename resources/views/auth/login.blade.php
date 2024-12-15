@extends('layouts.app')
@section('content')
<div class="authbg" style="background: url(<?=asset('installer/img/background.png');?>);background-size: cover;background-position: center;"></div>

<div class="wrapper-page auth-page-full">

    <div class="card shadow-none">
        <div class="card-block">

            <div class="auth-box">

                <div class="card-box shadow-none p-4">
                    <div class="p-2">
                        <div class="text-center mt-4">
                            <a href="{{ route('signin') }}"><img src="{{asset($data->logo)}}" height="60px" alt="logo"></a>
                        </div>

                        <h4 class="font-size-18 mt-5 text-center">{{ __('signin') }}</h4>
                        <p class="text-muted text-center">{{ __('auth.welcome') }}</p>
                        <x-admin.validation-component></x-admin.validation-component>
                        <form class="mt-4" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">{{__('auth.email')}}</label>
                                <input type="email" class="form-control" id="email" value="{{old('email')}}" name="email">
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="userpassword">{{ __('auth.password') }}</label>
                                <input type="password" class="form-control" id="userpassword" name="password">
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember"  {{ old('remember') ? 'checked' : '' }} class="form-check-input" id="customControlInline">
                                        <label class="form-check-label" for="customControlInline"> {{ __('auth.remember')}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{__('auth.signin')}}</button>
                                </div>
                            </div>

                            <div class="mb-3 mt-2 mb-0 row">
                                <div class="col-12 mt-3">
                                    <a href="{{ route('password.request') }}"><i class="mdi mdi-lock"></i> {{__('auth.forget')}}</a>
                                </div>
                            </div>

                        </form>

                         

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection