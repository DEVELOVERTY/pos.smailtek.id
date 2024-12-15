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
        <div id="errors"></div>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data"  class="form form-vertical"  id="uHrm">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{__('settings.time_min')}}</label>
                                                <div class="position-relative">
                                                    <input type="time" class="form-control" name="min_check_int" value="{{ old('min_check_int',$hrm->min_check_int ?? '') }}" required id="min_check_int"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{__('settings.time_max')}}</label>
                                                <div class="position-relative">
                                                    <input type="time" class="form-control" name="max_check_int" value="{{ old('max_check_int',$hrm->max_check_int ?? '') }}" required id="max_check_int"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{__('settings.time_out')}}</label>
                                                <div class="position-relative">
                                                    <input type="time" class="form-control" name="min_check_out" value="{{ old('min_check_out',$hrm->min_check_out ?? '') }}" required id="min_check_out"> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{__('settings.late_loss')}}</label>
                                                <div class="position-relative">
                                                    <select class="form-control" name="attendance_in_late">
                                                        @if($hrm->attendance_in_late == 'yes')
                                                            <option value="yes">{{__('settings.connect')}}</option>
                                                            <option value="no">{{__('settings.no')}}</option>
                                                        @else 
                                                            <option value="no">{{__('settings.no')}}</option>
                                                            <option value="yes">{{__('settings.connect')}}</option>
                                                        @endif
                                                    </select> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{__('settings.allowance_to_attendance')}}</label>
                                                <div class="position-relative">
                                                    <select class="form-control" name="attendance_to_salary">
                                                        @if($hrm->attendance_to_salary == 'yes')
                                                            <option value="yes">{{__('settings.connect')}}</option>
                                                            <option value="no">{{__('settings.no')}}</option>
                                                        @else 
                                                            <option value="no">{{__('settings.no')}}</option>
                                                            <option value="yes">{{__('settings.connect')}}</option>
                                                        @endif
                                                    </select> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{__('settings.deduction_to_attendance')}}</label>
                                                <div class="position-relative">
                                                    <select class="form-control" name="attendance_to_cutting">
                                                        @if($hrm->attendance_to_cutting == 'yes')
                                                            <option value="yes">{{__('settings.connect')}}</option>
                                                            <option value="no">{{__('settings.no')}}</option>
                                                        @else 
                                                            <option value="no">{{__('settings.no')}}</option>
                                                            <option value="yes">{{__('settings.connect')}}</option>
                                                        @endif
                                                    </select> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4 mt-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name">{{__('settings.salary_tax')}} ( % )</label>
                                                <div class="position-relative">
                                                    <input type="number" class="form-control" name="salary_tax" value="{{ old('salary_tax',$hrm->salary_tax ?? '') }}" required id="salary_tax"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4 d-flex justify-content-end mt-4">
                                            <button  class="btn btn-info me-1 mb-1">{{ __('save') }}</button> 
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
 
@endsection