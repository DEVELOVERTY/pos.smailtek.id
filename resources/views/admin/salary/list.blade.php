@extends('layouts.admin')
@section('content')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
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
 
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('salary.list') }}" method="GET" class="row">
                                <div class="col-sm-12 col-md-4 mb-3">
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
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="control-label">{{__('hrm.choose_designation')}}</label>
                                    <div class="input-group">
                                        <select class="form-control" id="designation" name="designation_id">
                                            <option value="">{{__('hrm.choose_designation')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
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
                @if (@$_GET['designation_id'] != null && @$_GET['date'] != null)
                    <div class="card ">
                        <div class="card-header header-modal">
                            <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- COUNTRY  DATA -->
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>{{__('hrm.employee_name')}}</th>
                                                <th>{{__('hrm.salary_generate_date')}}</th>
                                                <th>{{__('sidebar.deduction')}}</th>
                                                <th>{{__('sidebar.e_allowance')}}</th>
                                                <th>Bonus</th>
                                                <th>{{__('purchase.tax')}}</th>
                                                <th>{{__('hrm.salary_basic')}}</th>
                                                <th>{{__('general.total')}}</th>
                                                <th>{{__('general.payment_status')}}</th>
                                                <th>{{__('general.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $c)
                                                <tr class="data-product">
                                                    <td>{{ $c->user->name }}</td>
                                                    <td>{{ $c->created_at }}</td>
                                                    <td>{{ number_format($c->cutting) }}</td>
                                                    <td>{{ number_format($c->allowance) }}</td>
                                                    <td>{{ number_format($c->bonus ?? 0) }}</td>
                                                    <td>{{ $c->tax }}%</td>
                                                    <td>{{ number_format($c->salary) }}</td>
                                                   
                                                    <td>{{ number_format($c->total) }}</td>
                                                    <td>
                                                        @if ($c->status == 'due')
                                                            {{__('hrm.before_pay')}}
                                                        @else
                                                            {{__('hrm.after_pay')}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($c->status == 'due')
                                                        @can("Update Status Pengajian")
                                                            <a href="javascript:void(0)" id="{{ $c->id }}" onclick="getstatusmodal(this.id)" class="btn btn-sm btn-info"><i class="fa fa-money-bill"></i></a>
                                                        @endcan
                                                        @endif
                                                        @can("Detail Slip Gaji")
                                                            <a href="{{ route('salary.detail', $c->id) }}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
<div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{ route('salary.status') }}" class="modal-content">
            @csrf
            <div class="modal-header header-modal">
                <h5 class="modal-title text-white" id="">{{__('purchase.change_payment_status')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="system_name">{{__('purchase.status')}}</label>
                    <input type="hidden" name="id" id="ti" value="">
                    <select class="form-control" name="status">
                        <option value="paid">{{__('hrm.after_pay')}}</option> 
                    </select>
                </div>

                <div class="form-group">
                    <label for="system_name">{{__('general.payment_method')}}</label> 
                    <select class="form-control" name="method">
                        <option value="Bank Transfer">Bank Transfer</option> 
                        <option value="Cash">Cash</option> 
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.close') }}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.add_payment') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables/datatables.js') }}"></script>
    <script>
        function getstatusmodal(id)
        {
            $("#ti").val(id);
            document.getElementById("update_status").click();
        }

        $(document).ready(function() {
            $("select[name='department']").change(function() {
                var url = domainpath + "/pos-admin/hrm/get-designation/" + $(this).val();
                console.log(url);
                $("select[name='designation_id']").load(url);
                return false;
            });
        });
    </script>
@endsection
@endsection
