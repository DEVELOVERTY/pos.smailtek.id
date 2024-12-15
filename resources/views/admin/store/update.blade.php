@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendors/maps/leaflet.css') }}" />
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
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" class="row" id="uStore">
                                @csrf
                                <div class="col-md-4 mb-4">
                                    <h6>{{__('store.choose_country')}}</h6>
                                    <div class="form-group">
                                        <select class="choices form-select" name="country_id" id="country" required>
                                            <option value="">{{__('store.choose_country')}}</option>
                                            @foreach($data['country'] as $d)
                                            <option value="{{$d->id}}" @if($d->id == old('country_id',$store->country_id)) selected @endif>{{$d->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-4">
                                    <h6>{{__('store.choose_currency')}}</h6>
                                    <div class="form-group">
                                        <select class="choices form-select" name="currency_id" id="currency" required>
                                            <option value="">{{__('store.choose_currency')}}</option>
                                            @foreach($data['currency'] as $c)
                                            <option value="{{$c->id}}" @if($c->id == old('currency_id',$store->currency_id)) selected @endif>{{$c->country}} - {{ $c->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h6>{{__('store.choose_printer')}} </h6>
                                    <div class="form-group">
                                        <select class="choices form-select" name="printer_id" id="printer" required>
                                            <option value="">{{__('store.choose_printer')}}</option>
                                            @foreach($data['printer'] as $p)
                                            <option value="{{$p->id}}" @if($p->id == old('printer_id',$store->printer_id)) selected @endif>{{$p->name}} - {{ $p->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>{{__('store.store_name')}}</h6>
                                    <div class="form-group">
                                        <input type="text" name="name" value="{{old('name',$store->name)}}" id="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('general.code')}}</h6>
                                    <div class="form-group">
                                        <input type="text" name="code" value="{{old('code',$store->code)}}" id="code" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>{{__('general.email')}}</h6>
                                    <div class="form-group">
                                        <input type="email" name="email" value="{{old('email',$store->email)}}" id="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('general.email')}}</h6>
                                    <div class="form-group">
                                        <input type="number" name="phone" value="{{old('phone',$store->phone)}}" id="phone" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>{{__('store.zip_code')}}</h6>
                                    <div class="form-group">
                                        <input type="text" name="zip_code" value="{{old('zip_code',$store->zip_code)}}" id="zip_code" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('purchase.tax')}}</h6>
                                    <div class="form-group">
                                        <input type="number" name="tax" value="{{old('tax',$store->tax)}}" id="tax" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>{{__('store.after_sell')}}</h6>
                                    <div class="form-group">
                                        <select class="form-control" name="after_sell" id="after_sell">
                                            @if($store->after_sell == 1 || $store->after_sell == null)
                                            <option value="1">POS</option>
                                            <option value="2">{{ __('open_receipt_popup') }}</option>
                                            <option value="3">{{ __('open_receipt_window') }}</option>
                                            @elseif($store->after_sell == 2)
                                            <option value="2">{{ __('open_receipt_popup') }}</option>
                                            <option value="1">POS</option>
                                            <option value="3">{{ __('open_receipt_window') }}</option>
                                            @elseif($store->after_sell == 3)
                                            <option value="3">{{ __('open_receipt_window') }}</option>
                                            <option value="1">POS</option>
                                            <option value="2">{{ __('open_receipt_popup') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>Zakat</h6>
                                    <div class="form-group">
                                        <input type="number" name="zakat" value="{{old('zakat',$store->zakat)}}" id="zakat" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>{{__('store.currency_position')}}</h6>
                                    <div class="form-group">
                                        <select class="form-control" name="currency_position" id="currency_position" required>
                                            @if($store->currency_position == 1 || $store->currency_position == null)
                                            <option value="1">{{ __('store.before_amount') }}</option>
                                            <option value="2">{{ __('store.after_amount') }}</option>
                                            @elseif($store->currency_position == 2)
                                            <option value="2">{{ __('store.after_amount') }}</option>
                                            <option value="1">{{ __('store.before_amount') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>{{__('store.sound_in_pos')}}</h6>
                                    <div class="form-group">
                                        <select class="form-control" name="sound" id="sound">
                                            @if($store->sound == 1 || $store->sound == null)
                                            <option value="1">{{ __('general.yes') }}</option>
                                            <option value="2">{{ __('general.no') }}</option>
                                            @elseif($store->sound == 2)
                                            <option value="2">{{ __('general.no') }}</option>
                                            <option value="1">{{ __('general.yes') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <h6>{{__('general.address')}}</h6>
                                    <div class="form-group">
                                        <textarea class="form-control" name="address" id="address" required>{{ old('address',$store->address) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <h6>{{__('store.footer_text')}}</h6>
                                    <div class="form-group">
                                        <textarea class="form-control" name="footer_text" id="footer_text">{{ old('footer_text',$store->footer_text) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h6>{{__('store.format_reference')}}</h6>
                                    <div class="form-group">
                                        <select class="form-control" name="reference_format" id="reference_format">
                                            @foreach($reference_format as $key => $value)
                                            <option value="{{$key}}" @if($key==old('reference_format',$store->reference_format)) selected @endif >{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-4">
                                    <h6>GST Reg. No</h6>
                                    <div class="form-group">
                                        <input type="text" name="gst" value="{{old('gst',$store->gst)}}" id="gst" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h6>VAT Reg. No</h6>
                                    <div class="form-group">
                                        <input type="text" name="vat" value="{{old('vat',$store->vat)}}" id="vat" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-5">
                                    <div id="map" style="height: 400px"></div>
                                </div>

                                <div class="col-md-6 mb-6">
                                    <h6>LongTitude</h6>
                                    <div class="form-group">
                                        <input type="text" name="long" value="{{old('long',$store->long)}}" id="long" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-6">
                                    <h6>Langtitude</h6>
                                    <div class="form-group">
                                        <input type="text" name="lang" value="{{old('lang',$store->lang)}}" id="lang" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end mt-4">
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
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
<script src="{{ asset('assets/vendors/maps/leaflet.js') }}"></script>
<script src="{{ asset('assets/vendors/maps/store_update.js') }}"></script>
@endsection

@endsection