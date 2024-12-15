@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" />
<link href="{{ asset('assets/vendors/summernote/summernote.min.css') }}" rel="stylesheet">
@endsection

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
            <form id="uExpense" method="POST" enctype="multipart/form-data" class="col-md-12 col-12">
                @csrf
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('expense.name')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="{{ $expense->id }}">
                                            <input type="text" class="form-control" name="name" value="{{ old('name',$expense->name) }}" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.ref_no')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('ref_no',$expense->ref_no) }}" id="get_sku" name="ref_no" readonly>
                                                <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('category.category_name') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="category" id="category">
                                                <option value="">{{ __('category.choose_category') }}</option>
                                                @foreach ($data as $c)
                                                @if($c->id == $expense->category_id)
                                                @php
                                                $subcategory = 0;
                                                @endphp
                                                <option value="{{ $c->id }}" @if ($c->id == old('category',$expense->category_id)) selected @endif>{{ $c->name }}</option>
                                                @else
                                                @php
                                                $subcategory = 1;
                                                @endphp
                                                <option value="{{ $c->id }}" @if ($c->id == old('category',$expense->category->parent->id ?? '')) selected @endif>{{ $c->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('category.subcategory_name') }}</label>
                                        </div>
                                        @php
                                        @endphp
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="subcategory" id="subcategory">
                                                @if($subcategory == 1)
                                                <option value="">{{ __('category.choose_subcategory') }} </option>
                                                @else
                                                <option value="{{ $product->category->id ?? '' }}">{{ $product->category->name ?? '' }} </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('expense.amount')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="amount" value="{{ old('amount',number_format($expense->amount)) }}" id="amount">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('expense.refund')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="refund" id="refund">
                                                <option value="yes">Iya</option>
                                                <option value="no">Bukan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.detail') }}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea id="summernote" style="height: 350px" name="detail">{{ old('detail',$expense->detail) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.file')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="form-control" type="file" id="document" name="document">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary float-end mt-3">{{ __('general.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

@section('scripts')
<script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('assets/vendors/choices.js/choices.min.js') }}"></script>
<script src="{{asset('js/expense.js')}}"></script>
@endsection
@endsection