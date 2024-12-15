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
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>

        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('generate.salary') }}" method="GET" class="row">
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label">{{__('hrm.choose_department')}}</label>
                                    <div class="input-group">
                                        <select class="form-control" id="department" name="department">
                                            <option value="">{{__('hrm.choose_department')}}</option>
                                            @foreach ($department as $d)
                                            <option value="{{ $d->id }}" @if ($d->id == old('department')) selected @endif>{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label">{{__('hrm.choose_designation')}}</label>
                                    <div class="input-group">
                                        <select class="form-control" id="designation" name="designation_id">
                                            <option value="">{{__('hrm.choose_designation')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label">{{__('hrm.choose_employee')}}</label>
                                    <div class="input-group">
                                        <select class="form-control" id="employee" name="employee" required>
                                            <option value="">{{__('hrm.choose_employee')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label"> {{__('general.date')}}</label>
                                    <div class="input-group">
                                        <input type="date" name="date" id="date" class="form-control" required value="{{ old('end_date') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12">
                @if (@$_GET['employee'] != null && @$_GET['date'] != null)
                <form action="{{ route('salary.store') }}" method="POST" class="card ">
                    <div class="card-content">
                        <div class="card-body" id="printarea">
                            <div class="row mb-4">
                                <div class="col-4">
                                    <h1>{{__('hrm.salary_slip')}}</h1>
                                </div>
                                <div class="col-6 text-end">
                                    <b class="">{{ $store->name }}</b>
                                    <address>
                                        <strong> {{ $store->address }}</strong>
                                        <br>
                                        <strong>{{__('general.phone')}} {{ $store->phone }}</strong>
                                        <br>
                                        <strong>{{__('general.email')}} {{ $store->email }}</strong>
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
                                    <input type="hidden" name="user_id" value="{{ $employee->user_id }}">
                                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                    <input type="hidden" name="total_work" value="{{ $employee->month_work($year, $month) }}">
                                    <input type="hidden" name="attendance_this_month" value="{{ $employee->month_total($year, $month) }}">
                                    <input type="hidden" name="designation" value="{{ $employee->designation_id }}">
                                    <p>{{ $employee->user->name ?? '' }}</p>
                                    <p style="margin-top: -15px">{{ $employee->address }}</p>
                                    <p style="margin-top: -15px">{{__('general.phone')}} : {{ $employee->phone }}</p>
                                    <p style="margin-top: -15px">{{__('general.email')}} : {{ $employee->email }}</p>
                                </div>

                                <div class="col-sm-8 text-end">

                                    <p>{{__('general.date')}}: <b>{{ date('Y-m-d') }}</b> </p>
                                    <p style="margin-top: -15px">{{__('attendance.total_attendance_in_monthly')}} :
                                        <b>{{ $employee->month_total($year, $month) }}x</b>
                                    </p>
                                    <p style="margin-top: -15px">{{__('attendance.total_work_in_monthly')}} :
                                        <b>{{ $employee->month_late($year, $month) }}</b>
                                    </p>
                                    <p style="margin-top: -15px">{{__('attendance.total_late_in_monthly')}} :
                                        <b>{{ $employee->month_work($year, $month) }}</b>
                                    </p>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4>{{__('sidebar.deduction')}}:</h4>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white; " class="text-white">
                                                    <th>#</th>
                                                    <th>{{__('hrm.deduction_name')}}</th>
                                                    <th>{{__('general.amount')}}</th>
                                                    <th>X</th>
                                                    <th class="text-end">{{__('general.total')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $tc = 0;
                                                @endphp
                                                @foreach ($cutting as $c)
                                                @php
                                                $total_cutting = 0;
                                                @endphp
                                                @if ($c->designation_id != null)
                                                @if ($c->designation_id == $employee->designation_id)
                                                @if ($c->priode == 'month')
                                                @php
                                                $day = 1;
                                                @endphp
                                                @else
                                                @php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_cutting == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                @endphp
                                                @endif
                                                @php
                                                $total_cutting += $c->amount * $day;
                                                $tc += $c->amount * $day;
                                                @endphp
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{ $c->name }}</td>
                                                    <td>{{ number_format($c->amount) }}</td>
                                                    <td>
                                                        {{ $day }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($total_cutting) }}
                                                    </td>
                                                </tr>
                                                @else
                                                @endif
                                                @else
                                                @if ($c->priode == 'month')
                                                @php
                                                $day = 1;
                                                @endphp
                                                @else
                                                @php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_cutting == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                @endphp
                                                @endif
                                                @php
                                                $total_cutting += $c->amount * $day;
                                                $tc += $c->amount * $day;
                                                @endphp
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{ $c->name }}</td>
                                                    <td>{{ number_format($c->amount) }}</td>
                                                    <td>
                                                        @if ($c->priode == 'month')
                                                        1
                                                        @else
                                                        @php
                                                        $calendar = CAL_GREGORIAN;
                                                        if ($setthrm->attendance_to_cutting == 'no') {
                                                        $day = cal_days_in_month($calendar, $month, $year);
                                                        } else {
                                                        $day = $employee->month_total($year, $month);
                                                        }

                                                        @endphp
                                                        {{ $day }}
                                                        @endif
                                                    </td>
                                                    <td class="text-end"> {{ number_format($total_cutting) }}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4>{{__('sidebar.e_allowance')}}:</h4>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white; " class="text-white">
                                                    <th>#</th>
                                                    <th>{{__('hrm.allowance_name')}}</th>
                                                    <th>{{__('general.amount')}}</th>
                                                    <th>X</th>
                                                    <th class="text-end">{{__('general.total')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $ta = 0;
                                                @endphp
                                                @foreach ($allowance as $a)
                                                @php
                                                $total_allowance = 0;
                                                @endphp
                                                @if ($a->designation_id != null)
                                                @if ($a->designation_id == $employee->designation_id)
                                                @if ($a->priode == 'month')
                                                @php
                                                $day = 1;
                                                @endphp
                                                @else
                                                @php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_salary == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                @endphp
                                                @endif
                                                @php
                                                $total_allowance += $a->amount * $day;
                                                $ta += $a->amount * $day;
                                                @endphp
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{ $a->name }}</td>
                                                    <td>{{ number_format($a->amount) }}</td>
                                                    <td>
                                                        {{ $day }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($total_allowance) }}
                                                    </td>
                                                </tr>
                                                @else
                                                @endif
                                                @else
                                                @if ($a->priode == 'month')
                                                @php
                                                $day = 1;
                                                @endphp
                                                @else
                                                @php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_salary == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                @endphp
                                                @endif
                                                @php
                                                $total_allowance += $a->amount * $day;
                                                $ta += $a->amount * $day;
                                                @endphp
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{ $a->name }}</td>
                                                    <td>{{ number_format($a->amount) }}</td>
                                                    <td>
                                                        @if ($a->priode == 'month')
                                                        1
                                                        @else
                                                        @php
                                                        $calendar = CAL_GREGORIAN;
                                                        if ($setthrm->attendance_to_salary == 'no') {
                                                        $day = cal_days_in_month($calendar, $month, $year);
                                                        } else {
                                                        $day = $employee->month_total($year, $month);
                                                        }

                                                        @endphp
                                                        {{ $day }}
                                                        @endif
                                                    </td>
                                                    <td class="text-end"> {{ number_format($total_allowance) }}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4>{{__('hrm.salary_basic')}} :</h4>
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
                                                    <td>{{ number_format($employee->salary) }}</td>
                                                    <th class="text-end">
                                                        <input type="hidden" name="salary" value="{{ $employee->salary }}"> {{ number_format($employee->salary) }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>#</td>
                                                    <td>Bonus ( {{__('general.optional')}} )</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="bonus" id="bonus" value="0">
                                                    </td>
                                                    <th class="text-end">
                                                        <p id="bonus_total"></p>
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
                                    <textarea class="form-control" name="note" id="note"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">

                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                    <input type="hidden" name="cutting" value="{{ $tc }}">
                                    <input type="hidden" name="tax" value="{{ $setthrm->salary_tax }}">
                                    <input type="hidden" name="allowance" value="{{ $ta }}">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @php
                                                $subtotal = $ta + $employee->salary - $tc;
                                                @endphp
                                                <tr>
                                                    <th>{{__('general.subtotal')}} : </th>
                                                    <td></td>
                                                    <td class="text-end" id="subtotal">
                                                        {{ number_format($subtotal) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @php
                                                    $tax = ($setthrm->salary_tax / 100) * $subtotal;
                                                    $total = $subtotal - $tax;
                                                    @endphp
                                                    <th>{{__('purchase.tax')}} :</th>
                                                    <td>
                                                        <b>(-)</b>
                                                    </td>
                                                    <td class="text-end">{{ $setthrm->salary_tax }}% </td>
                                                </tr>
                                                <tr>
                                                    <th>Bonus :</th>
                                                    <td><b>(+)</b></td>
                                                    <td class="text-end" id="bonus_invoice">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('hrm.amount_total')}} :</th>
                                                    <td><b>(+)</b> <input type="hidden" id="total_salary" name="total" value="{{ $total }}"></td>
                                                    <td class="text-end" id="salary_total"> {{ number_format($total) }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{__('general.add')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        $("select[name='department']").change(function() {
            var url = domainpath + "/pos-admin/hrm/get-designation/" + $(this).val();
            console.log(url);
            $("select[name='designation_id']").load(url);
            return false;
        });

        $("select[name='designation_id']").change(function() {
            var url = domainpath + "/pos-admin/salary/get-employee/" + $(this).val();
            console.log(url);
            $("select[name='employee']").load(url);
            return false;
        });

        $("#bonus").on("keyup", function() {
            var bonus = $("#bonus").val();
            $("#bonus").val(formatRupiah(bonus.toString()))
            $("#bonus_total").html(formatRupiah(bonus.toString()));
            $("#bonus_invoice").html(formatRupiah(bonus.toString()));

            var total = $("#total_salary").val();
            var total_salary = parseInt(total) + parseInt(bonus.replace(/[^0-9]/g, '').toString());
            $("#salary_total").html(formatRupiah(total_salary.toString()));
            $("#total_salary").val(total.toString());
        });
    });
</script>
@endsection
@endsection