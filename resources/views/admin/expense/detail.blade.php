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
                    @can("Daftar Pengeluaran")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('expense.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.expense') }}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-content">
                        <div class="card-body" id="printarea">
                            <div class="row invoice-info">

                                <div class="col-sm-6 invoice-col">
                                    {{__('general.store')}} :
                                    <address>
                                        <strong>{{ $data->store->name }},</strong>
                                        <br> {{ $data->store->address }}
                                    </address>
                                </div>

                                <div class="col-sm-6 invoice-col">
                                    <b>{{__('general.ref_no')}} :</b> #{{ $data->ref_no }}<br>
                                    <b>{{__('general.date')}} :</b> {{ my_date($data->created_at) }}<br>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                    <th>{{__('general.ref_no')}}</th>
                                                    <th>{{__('general.category_name')}}</th>
                                                    <th>{{__('expense.name')}}</th>
                                                    <th>{{__('expense.amount')}}</th>
                                                    <th>{{__('general.store')}}</th>
                                                    <th>{{__('general.date')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> {{ $data->ref_no }} </td>
                                                    <td> {{ $data->category->name ?? '' }} </td>
                                                    <td> {{ $data->name }} </td>
                                                    <td> {{ number_format($data->amount) }} </td>
                                                    <td> {{ $data->store->name ?? '' }} </td>
                                                    <td> {{ $data->created_at }} </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <strong>{{__('general.detail')}} / {{__("general.note")}} :</strong><br>
                                    <?= $data->detail; ?>


                                </div>
                            </div>
                            @if ($data->document != null)
                            <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <a target="_blank" href="{{ asset($data->document) }}" class="btn btn-primary"><i class="fas fa-print"></i> Download {{__('general.file')}}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection