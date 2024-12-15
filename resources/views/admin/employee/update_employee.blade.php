@extends('layouts.admin')
@section('content')

@section('styles')

@endsection

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Daftar Pegawai")
                    <a href="{{ route('employee.index') }}" class="btn btn-md btn-primary float-end"><i class="fa fa-list"></i> {{__('sidebar.employee')}} </a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div id="errors"></div>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" class="row" id="uEmployee">
                                @csrf
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('hrm.choose_department')}}</h6>
                                    <div class="form-group">
                                        <select class="form-select" name="department" id="department">
                                            <h6>{{__('hrm.choose_department')}}</h6>
                                            @foreach($data as $d)
                                            <option value="{{$d->id}}" @if($d->id == old('department',$employee->designation->department->id ?? '')) selected @endif>{{$d->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('hrm.choose_designation')}}</h6>
                                    <div class="form-group">
                                        <select class="form-select" name="designation_id" id="designation_id">
                                            <option value="{{ $employee->designation_id }}">{{ $employee->designation->name ?? '' }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('hrm.choose_user')}}</h6>
                                    <div class="form-group">
                                        <select class="form-select" name="user_id" id="user_id">
                                            @foreach($user as $u)
                                            <option value="{{$u->id}}" @if($u->id == old('user_id',$employee->user_id)) selected @endif>{{$u->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('general.phone')}}</h6>
                                    <div class="form-group">
                                        <input type="number" name="phone" value="{{old('phone',$employee->phone)}}" id="phone" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>{{__('hrm.hbd')}}</h6>
                                    <div class="form-group">
                                        <input type="date" name="date_birth" value="{{old('date_birth',$employee->date_birth)}}" id="date_birth" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>{{__('hrm.salary_amount')}}</h6>
                                    <div class="form-group">
                                        <input type="text" name="salary" value="{{old('salary',number_format($employee->salary))}}" id="salary" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <h6>{{__('general.address')}}</h6>
                                    <div class="form-group">
                                        <textarea class="form-control" name="address" id="address">{{ old('address',$employee->address) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <h6>{{__('hrm.about')}}</h6>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{ $employee->id }}">
                                        <textarea class="form-control" name="about" id="about">{{ old('about',$employee->about) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-info">{{__('general.save')}}</button>
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

        $("#salary").on("keyup", function() {
            var salary = $("#salary").val();
            $("#salary").val(formatRupiah(salary.toString()));
        });
    });
</script>
@endsection

@endsection