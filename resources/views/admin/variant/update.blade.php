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
                    @can("Daftar Variasi Produk")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('variant.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.v_product') }}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>

        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('variant.store', 'update') }}" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ __('produk.variant_type') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <input type="text" class="form-control" name="name" value="{{ old('name',$data->name) }}" id="name" required placeholder="{{ __('produk.variant_type') }} ">
                                        </div>

                                        <div class="divider mt-2 mb-0">
                                            <div class="divider-text">{{ __('produk.variant_content') }}</div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('produk.variant_name') }}</th>
                                                        <th width="110px"><span class="fa fa-cogs"></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="hasil">
                                                    @php
                                                    $no = 1;
                                                    @endphp
                                                    @foreach($data->value as $value)
                                                    <tr>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="hidden" name="value_id[]" value="{{ $value->id }}">
                                                                <input type="text" class="form-control" name="value_name[]" id="name" value="{{ $value->name }}" required>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-2">
                                                                @if($no++ == 1)
                                                                <button type="button" class="btn btn-sm btn-success" id="add"><i class="fas fa-plus-circle"></i></button>
                                                                @else
                                                                <button type="button" class="btn btn-sm btn-danger " id="{{ $value->id }}" onclick="deleteValue(this.id)"><i class="fas fa-minus-circle"></i></button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="variant0"></tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" id="send" class="btn btn-primary me-1 mb-1">{{ __('general.update') }}</button>
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
<script>
    window.onload = function() {
        $('#add').click(function() {
            var cloning = `<tr class="variant">
                    <td>
                        <div class="col-md-10 form-group">
                            <input type="hidden" name="value_id[]" >
                            <input type="text" class="form-control" name="value_name[]" id="name"  required>
                        </div>
                    </td>
                   
                    <td>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-danger"><i  class="fas fa-minus-circle"></i></button>
                        </div>    
                    </td>
                </tr>`;
            $(".variant0").after(cloning).prev();
        });



        $("body").on("click", ".btn-danger", function() {
            console.log($(this).parents(".variant").remove());
            $(this).parents(".variant").remove();
        });
    }

    var url = document.location.origin;
    var success = $("#success").val();

    function deleteValue(identity) {
        $.post(url + domainpath + "/pos-admin/product/variant/variant-value-delete/" + identity, {
                id: identity,
                _token: token,
            })
            .done(function() {
                toastr.success(success, {
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    positionClass: "toast-top-right",
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "100",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1,
                });

                var ini = $("#" + identity).parents('.variant');
                ini.remove();
            });
        event.preventDefault();
    }
</script>
<script>

</script>
@endsection
@endsection