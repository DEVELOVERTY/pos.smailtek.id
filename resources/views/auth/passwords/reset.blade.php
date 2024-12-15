@extends('layouts.app')
@section('content')
<div class="accountbg" style="background: url({{asset('installer/img/background.png')}});background-size: cover;background-position: center;"></div>

<div class="wrapper-page account-page-full">

    <div class="card shadow-none">
        <div class="card-block">

            <div class="account-box">

                <div class="card-box shadow-none p-4">
                    <div class="p-2">
                        <div class="text-center mt-4">
                            <a href="{{ route('signin') }}"><img src="{{asset($data->logo)}}" height="60px" alt="logo"></a>
                        </div>

                        <h4 class="font-size-18 mt-5 text-center">{{ __('reset_password') }}</h4> 
                        <x-admin.validation-component></x-admin.validation-component>
                        <form class="mt-4" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">{{__('auth.email')}}</label>
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="email" class="form-control" id="email" value="{{old('email')}}" name="email">
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="userpassword">{{ __('auth.password') }}</label>
                                <input type="password" class="form-control" id="userpassword" name="password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">{{ __('confirm_password') }}</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>

                            <div class="mb-3 row"> 
                                <div class="col-sm-12 text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit"> {{ __('reset_password') }}</button>
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