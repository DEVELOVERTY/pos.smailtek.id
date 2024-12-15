@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/css/dropify.min.css') }}">
@endsection
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Daftar Potongan")
                    <a href="{{route('cutting.index')}}" class="btn btn-md btn-primary float-end"><i class="fa fa-list"></i> {{__('sidebar.deduction')}} </a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="uCutting" method="POST" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('hrm.deduction_name') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="{{ old('name',$allowance->name) }}" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('hrm.choose_department')}} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="department">
                                                @if($allowance->designation_id != 0)
                                                <option value="{{ $allowance->designation->department_id }}">{{ $allowance->designation->department->name }}</option>
                                                @else
                                                <option value="">{{__('hrm.all_employee')}}</option>
                                                @endif
                                                @foreach ($department as $d)
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('hrm.choose_designation')}} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="{{ $allowance->id }}">
                                            <select class="form-control" name="designation_id">
                                                <option value="{{ $allowance->designation_id }}">{{ $allowance->designation->name ?? 'Seluruh Pegawai' }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('hrm.deduction_circle')}} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="priode">
                                                @foreach ($priode as $p => $i)
                                                <option value="{{ $p }}" @if ($p==old('priode',$allowance->priode)) selected @endif>{{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('hrm.amount_deduction')}}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="amount" value="{{ old('amount',number_format($allowance->amount)) }}" id="amount" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-info me-1 mb-1">{{ __('general.add') }}</button>
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
<script src="{{ asset('assets/vendors/dropify/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("select[name='department']").change(function() {
            var url = domainpath + "/pos-admin/hrm/get-designation/" + $(this).val();
            $("select[name='designation_id']").load(url);
            return false;
        });

        $("#amount").on("keyup", function() {
            var amount = $("#amount").val();
            $("#amount").val(formatRupiah(amount.toString()))
        });
    });
</script>
@endsection
@endsection