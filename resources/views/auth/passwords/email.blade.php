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

                        <h4 class="font-size-18 mt-5 text-center">{{ __('forgot_password') }}</h4>
                        <p class="text-muted text-center">{{ __('auth.forget_page') }}</p>

                        <x-admin.validation-component></x-admin.validation-component>

                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form class="mt-4" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">{{__('auth.email')}}</label>
                                <input type="email" class="form-control" id="email" value="{{old('email')}}" name="email">
                            </div> 

                            <div class="mb-3 row"> 
                                <div class="col-sm-6 text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{__('auth.ask_password')}}</button>
                                </div>
                            </div>

                            <div class="mb-3 mt-2 mb-0 row">
                                <div class="col-12 mt-3">
                                    <a href="{{ route('signin') }}"><i class="mdi mdi-keyboard-backspace"></i> {{__('auth.back_login')}}</a>
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