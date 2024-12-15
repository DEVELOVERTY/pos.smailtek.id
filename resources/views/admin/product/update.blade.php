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
            <form method="POST" id="cProduct" enctype="multipart/form-data" class="col-md-12 col-12">
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
                                            <label>{{__('produk.name')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="text" class="form-control" name="name" value="{{ old('name',$product->name) }}" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('produk.code')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('sku_product',$product->sku) }}" id="product_sku" name="sku_product" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('sidebar.category') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="category" id="category" required>
                                                <option value="">{{ __('category.choose_category') }} </option>
                                                @foreach ($data['category'] as $c)
                                                @if($c->id == $product->category_id)
                                                @php
                                                $subcategory = 0;
                                                @endphp
                                                <option value="{{ $c->id }}" @if ($c->id == old('category',$product->category_id)) selected @endif>{{ $c->name }}</option>
                                                @else
                                                @php
                                                $subcategory = 1;
                                                @endphp
                                                <option value="{{ $c->id }}" @if ($c->id == old('category',$product->category->parent->id ?? '')) selected @endif>{{ $c->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('category.subcategory') }} ( {{__('general.optional')}} )</label>
                                        </div>
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
                                            <label>{{ __('sidebar.brand') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="brand_id" id="brand_id" required>
                                                <option value="">{{ __('produk.choose_brand') }}</option>
                                                @foreach ($data['brand'] as $b)
                                                <option value="{{ $b->id }}" @if ($b->id == old('brand_id',$product->brand_id ?? '')) selected @endif>{{ $b->name }}</option>
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
                                                <option value="{{ $u->id }}" @if ($u->id == old('unit_id',$product->unit_id)) selected @endif>{{ $u->name }}</option>
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
                                                <option value="{{ $br }}" @if ($br==old('barcode_type',$product->barcode_type)) selected @endif>{{ $barcode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.min_qty') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="alert_quantity" value="{{ old('alert_quantity', $product->alert_quantity ?? 0) }}" id="alert_quantity" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.weight') }} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="weight" value="{{ old('weight', $product->weight ?? 0) }}" id="weight">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 1 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field1" value="{{ old('custom_field1',$product->custom_field1) }}" id="custom_field1">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 2 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field2" value="{{ old('custom_field2',$product->custom_field2) }}" id="custom_field2">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 3 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field3" value="{{ old('custom_field3',$product->custom_field3) }}" id="custom_field3">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.custom_field') }} 4 ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field4" value="{{ old('custom_field4',$product->custom_field4) }}" id="custom_field4">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.detail') }} ( {{__('general.optional')}} )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea id="summernote" style="height: 350px" name="description">{{ old('detail',$product->description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.upload_image') }}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="dropify" type="file" id="image" name="image" data-default-file="{{ asset($product->image) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card warning-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('product') }} {{ __('type') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="type" value="{{ $product->type }}" required readonly>
                                        </div>
                                    </div>
                                    @if($product->type == 'single')

                                    <div class="row" id="single">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('general.barcode_code') }}</th>
                                                        <th>{{ __('general.purchase_price') }}</th>
                                                        <th>{{ __('general.margin') }} (%)</th>
                                                        <th>{{ __('general.sell_price') }}</th>
                                                        <th>{{ __('general.image') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="single_product">
                                                    @foreach($product->variant as $variant)
                                                    <tr>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                                                <input type="text" class="form-control" name="sku_" value="{{ $variant->sku }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="p_price" value="{{ number_format($variant->purchase_price) }}" id="p_price">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="number" class="form-control" name="mrg" value="{{ $variant->margin }}" id="margin">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="s_price" value="{{ number_format($variant->selling_price) }}" id="s_price">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="file" class="form-control" name="img" id="image">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @elseif($product->type == 'variable')
                                    <div class="row" id="variable">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-1">
                                                <thead>
                                                    <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                        <th>{{ __('produk.variant_content') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table table" id="table-1">
                                                                    <thead>
                                                                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                                            <td>{{ __('general.barcode_code') }}</td>
                                                                            <td>{{ __('produk.variant_name') }}</td>
                                                                            <td>{{ __('general.purchase_price') }}</td>
                                                                            <td>{{ __('general.margin') }} (%)</td>
                                                                            <td>{{ __('general.sell_price') }}</td>
                                                                            <td>{{ __('general.image') }}</td>
                                                                            <td><i class="fa fa-cogs"></i></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="defaulth">
                                                                        @php
                                                                        $no = 1;
                                                                        $num = 0;
                                                                        @endphp
                                                                        @foreach($product->variant as $variant)
                                                                        <tr class="variant variant-@if($num++ == 0)0 @else{{ $variant->id }} @endif">
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" value="{{ $variant->sku }}" name="sku[]">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="hidden" name="variation_id[]" value="{{ $variant->id }}">
                                                                                    <input type="hidden" name="value_id[]" value="{{ $variant->variation_value_id }}">
                                                                                    <input type="text" class="form-control" name="value[]" value="{{ $variant->name }}" readonly id="value">
                                                                                </div>
                                                                            </td>


                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="purchase_price[]" value="{{ number_format($variant->purchase_price) }}" id="purchase_price">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="number" class="form-control" name="margin[]" value="{{ $variant->margin }}" id="margin">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="selling_price[]" value="{{ number_format($variant->selling_price) }}" id="selling_price">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="file" class="form-control" name="im[]" id="image">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                @if($no++ == 1)
                                                                                <button type="button" class="btn btn-sm btn-success text-white" onclick="add_variant()"><i class="fas fa-plus-circle"></i></button>
                                                                                @else
                                                                                <button type="button" class="btn btn-sm btn-danger " id="{{ $variant->id }}" onclick="delete_variant(this.id)"><i class="fas fa-minus-circle"></i></button>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
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
                                    @endif



                                </div>

                                <div class="col-sm-12 d-flex justify-content-end mt-5">
                                    <button class="btn btn-primary me-1 mb-1">{{ __('general.update') }}</button>
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
<script src="{{ asset('js/update_product.js') }}"></script>
@endsection
@endsection