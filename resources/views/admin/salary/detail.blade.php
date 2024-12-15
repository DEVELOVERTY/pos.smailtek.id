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
                    @can("Daftar Slip Gaji")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('salary.list') }}"><i class="fa fa-list"></i> {{__('sidebar.salary_list')}}</a>
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
                        <div class="card-body" id="printarea">
                            <div class="row mb-4">
                                <div class="col-4">
                                    <h1>{{__('hrm.salary_slip')}}</h1>
                                </div>
                                <div class="col-6 text-end">
                                    <b class="">{{ $salary->store->name ?? '' }}</b>
                                    <address>
                                        <strong> {{$salary->store->address ?? '' }}</strong>
                                        <br>
                                        <strong>{{__('general.phone')}} {{ $salary->store->phone ?? '' }}</strong>
                                        <br>
                                        <strong>{{__('general.email')}} {{ $salary->store->email ?? '' }}</strong>
                                    </address>
                                </div>
                                <div class="col-2 text-end">
                                    <img src="{{ asset($setting->logo) }}" style="width: 230px">
                                </div>
                            </div>
                            <hr style="border:2px solid black">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <b>{{__('hrm.to')}} :</b>
                                    <p>{{ $salary->user->name ?? '' }}</p>
                                    <p style="margin-top: -15px">{{ $salary->employee->address ?? '' }}</p>
                                    <p style="margin-top: -15px">{{__('general.phone')}} : {{ $salary->employee->phone ?? '' }}</p>
                                    <p style="margin-top: -15px">{{__('general.email')}} : {{ $salary->employee->email ?? '' }}</p>
                                </div>

                                <div class="col-sm-8 text-end">
                                    <p>{{__('general.date')}}: <b>{{ date('Y-m-d') }}</b> </p>
                                    <p style="margin-top: -15px">{{__('attendance.total_attendance_in_monthly')}} :
                                        <b>{{ $salary->attendance_this_month }}x</b>
                                    </p>
                                    <p style="margin-top: -15px">{{__('attendance.total_work_in_monthly')}} :
                                        <b>{{ $salary->total_work }}</b>
                                    </p>
                                </div>
                            </div>

                            <br>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4>{{__('general.detail')}} :</h4>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white; " class="text-white">
                                                    <th>#</th>
                                                    <th></th>
                                                    <th>{{__('general.amount')}}</th>
                                                    <th class="text-end">{{__('general.total')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{__('hrm.salary_basic')}}</td>
                                                    <td>{{ number_format($salary->salary) }}</td>
                                                    <th class="text-end">
                                                        {{ number_format($salary->salary) }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{__('hrm.amount_allowance')}}</td>
                                                    <td>{{ number_format($salary->allowance) }}</td>
                                                    <th class="text-end"> {{ number_format($salary->allowance) }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{__('hrm.amount_deduction')}}</td>
                                                    <td>{{ number_format($salary->cutting) }}</td>
                                                    <th class="text-end"> {{ number_format($salary->cutting) }}
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label class="control-label">{{__('general.note')}} : </label>
                                    <textarea class="form-control" name="note" id="note">{{ $salary->note }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">

                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                @php
                                                $subtotal = $salary->allowance + $salary->salary - $salary->cutting;
                                                @endphp
                                                <tr>
                                                    <th>{{__('general.subtotal')}} : </th>
                                                    <td></td>
                                                    <td class="text-end"> {{ number_format($subtotal) }}</td>
                                                </tr>
                                                <tr>
                                                    @php
                                                    $tax = ($salary->tax / 100) * $subtotal;
                                                    @endphp
                                                    <th>{{__('purchase.tax')}} :</th>
                                                    <td>
                                                        <b>(-)</b>
                                                    </td>
                                                    <td class="text-end">{{ $salary->tax }}% </td>
                                                </tr>
                                                <tr>
                                                    <th>Bonus :</th>
                                                    <td><b>(+)</b></td>
                                                    <td class="text-end" id="bonus_invoice">
                                                        {{ number_format($salary->bonus ?? 0) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('purchase.net_total')}} :</th>
                                                    <td><b>(+)</b> </td>
                                                    <td class="text-end" id="salary_total"> {{ number_format($salary->total) }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @can("Print Slip Gaji")
                            <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <a href="{{ route('salary.print',$salary->id) }}" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> {{__('hrm.print_slip')}}</a>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')

@endsection
@endsection