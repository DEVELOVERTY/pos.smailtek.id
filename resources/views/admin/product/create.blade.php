@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/css/dropify.min.css') }}">
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
                    @can("Daftar Produk")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('product.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.product') }}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>

        <div class="row match-height">
            <form action="{{ route('product.store','create') }}" method="POST" enctype="multipart/form-data" class="col-md-12 col-12">
                @csrf
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('produk.name')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('produk.code')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('sku_product') }}" id="product_sku" name="sku_product">
                                                <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('sidebar.category') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="category" id="category">
                                                <option value="">{{ __('category.choose_category') }}</option>
                                                @foreach ($data['category'] as $c)
                                                <option value="{{ $c->id }}" @if ($c->id == old('category')) selected @endif>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('category.subcategory') }} ( {{__('general.optional')}} ) </label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="subcategory" id="subcategory">
                                                <option value="">{{ __('category.choose_subcategory') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('sidebar.brand') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="brand_id" id="brand_id">
                                                <option value="">{{ __('produk.choose_brand') }}</option>
                                                @foreach ($data['brand'] as $b)
                                                <option value="{{ $b->id }}" @if ($b->id == old('brand_id')) selected @endif>{{ $b->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('sidebar.unit') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="unit_id" id="unit_id">
                                                <option value="">{{ __('produk.choose_unit') }}</option>
                                                @foreach ($data['unit'] as $u)
                                                <option value="{{ $u->id }}" @if ($u->id == old('unit_id')) selected @endif>{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.barcode_type') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="barcode_type" id="barcode_type">
                                                @foreach ($data['barcode'] as $br => $barcode)
                                                <option value="{{ $br }}" @if ($br==old('barcode_type')) selected @endif>{{ $barcode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.min_qty') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="alert_quantity" value="{{ old('alert_quantity', 0) }}" id="alert_quantity" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.weight') }} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="weight" value="{{ old('weight', 0) }}" id="weight">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 1 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field1" value="{{ old('custom_field1') }}" id="custom_field1">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 2 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field2" value="{{ old('custom_field2') }}" id="custom_field2">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 3 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field3" value="{{ old('custom_field3') }}" id="custom_field3">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 4 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field4" value="{{ old('custom_field4') }}" id="custom_field4">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.detail') }} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea id="summernote" style="height: 350px" name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.upload_image') }} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="dropify" type="file" id="image" name="image" data-default-file="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blue-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.product_type') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="type" id="type" required>
                                                <option value="">{{ __('produk.choose_type') }}</option>
                                                <option value="single">Single</option>
                                                <option value="variable">Variable</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="hasil"></div>

                                    <div class="row d-none" id="single">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('general.barcode_code')}}</th>
                                                        <th>{{ __('general.purchase_price') }}</th>
                                                        <th>{{ __('general.margin') }} (%)</th>
                                                        <th>{{ __('general.sell_price') }}</th>
                                                        <th>{{ __('general.image') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="single_product">
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="sku_" id="sku_">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="p_price" id="p_price">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="number" class="form-control" name="mrg" id="margin">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="s_price" id="s_price">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="file" class="form-control" name="img" id="image">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row d-none" id="variable">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-1">
                                                <thead>
                                                    <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                        <th width="10%">{{ __('sidebar.v_product') }}</th>
                                                        <th>{{ __('produk.variant_content') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-select" name="variation" id="variation">
                                                                <option value="0">{{ __('produk.choose_variant') }} </option>
                                                                @foreach ($data['variant'] as $v)
                                                                <option value="{{ $v->id }}">
                                                                    {{ $v->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table table" id="table-1">
                                                                    <thead>
                                                                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                                            <td>{{ __('produk.variant_name') }}</td>
                                                                            <th>{{__('general.barcode_code')}}</th>
                                                                            <td>{{ __('general.purchase_price') }}</td>
                                                                            <td>{{ __('general.margin') }} (%)</td>
                                                                            <td>{{ __('general.sell_price') }}</td>
                                                                            <td>{{ __('general.image') }}</td>
                                                                            <td><i class="fa fa-cogs"></i></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="defaulth">
                                                                        <tr class="variant-0">

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="hidden" name="variation_id[]">
                                                                                    <input type="hidden" name="value_id[]">
                                                                                    <input type="text" class="form-control" name="value[]" value="" id="value">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="sku[]" id="sku">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="purchase_price[]" id="purchase_price">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="number" class="form-control" name="margin[]" id="margin">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="selling_price[]" id="selling_price">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="file" class="form-control" name="im[]" id="image">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <button type="button" class="btn btn-sm btn-success text-white" onclick="add_variant()"><i class="fas fa-plus-circle"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="variant-001"></tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-sm-12 d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('general.add') }}</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">{{__('general.reset')}}</button>
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
<script src="{{ asset('assets/vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/vendors/choices.js/choices.min.js') }}"></script>
<script src="{{asset('js/create_produk.js')}}"></script>
@endsection
@endsection