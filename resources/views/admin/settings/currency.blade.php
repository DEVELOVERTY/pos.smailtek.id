@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Tambah Mata Uang")
                    <a class="btn btn-md btn-primary float-end" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add"><i class="fa fa-plus"></i> {{__('settings.add_currency')}}</a>
                    @endcan
                    <a href="javascript:void(0)" class="d-none" id="update_c" data-bs-toggle="modal" data-bs-target="#update_currency"></a>
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> No </th>
                                            <th>{{__('settings.simbol')}}</th>
                                            <th>{{__('sidebar.country')}}</th>
                                            <th>{{__('sidebar.currency')}}</th>
                                            <th>{{__('general.code')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('general.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($data as $d)
                                        <tr class="edit_currency">
                                            <td>{{$no++}} </td>
                                            <td>
                                                <p id="ci" class="d-none">{{$d->id}}</p>
                                                <p id="cd">{{$d->code}}</p>
                                            </td>
                                            <td>
                                                <p id="cn">{{$d->country}}</p>
                                            </td>
                                            <td>
                                                <p id="cr">{{$d->currency}}</p>
                                            </td>
                                            <td>
                                                <p id="cdd">{{$d->code}}</p>
                                            </td>
                                            <td>{{count($d->store)}}</td>
                                            <td>
                                                @can("Update Mata Uang")
                                                <a href="javascript:void(0)" class="btn btn-warning currency"><i class="fas fa-edit"></i></a>
                                                @endcan
                                                @can("Hapus Mata Uang")
                                                <a href="{{route('currency.delete',$d->id)}}" class="btn btn-danger deletebutton"><i class="fa fa-trash"></i></a>
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
            </div>
        </div>
    </div>
</div>
@can("Tambah Mata Uang")
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{route('currency.store','create')}}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="add">{{__('settings.add_currency')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="time">{{ __('sidebar.country') }}</label>
                    <input type="text" class="form-control" name="country" value="{{ old('country') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time">{{ __('sidebar.currency') }}</label>
                    <input type="text" class="form-control" name="currency" value="{{ old('currency') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time">{{ __('settings.simbol') }}</label>
                    <input type="text" class="form-control" name="symbol" value="{{ old('symbol') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time">{{ __('general.code') }}</label>
                    <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.close')}}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('settings.add_currency')}}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endcan
@can("Update Mata Uang")
<div class="modal fade" id="update_currency" tabindex="-1" role="dialog" aria-labelledby="update_currency" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{route('currency.store','up')}}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="">{{__('settings.update_currency')}} </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="system_name">{{ __('sidebar.country') }}</label>
                    <input type="hidden" name="id" id="currency_id" value="">
                    <input type="text" class="form-control" id="currency_name" name="country" value="" required>
                </div>
                <div class="form-group mb-3">
                    <label for="system_name">{{ __('settings.simbol') }}</label>
                    <input type="text" class="form-control" id="currency_code" name="symbol" value="" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time">{{ __('sidebar.currency') }}</label>
                    <input type="text" class="form-control" id="currency_c" name="currency" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time">{{ __('general.code') }}</label>
                    <input type="text" class="form-control" id="currency_cd" name="code" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.close')}}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.save')}}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endcan
@section('scripts')
<script src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/datatables.js')}}"></script>
@endsection
@endsection