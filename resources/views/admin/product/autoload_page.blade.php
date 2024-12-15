<div class="table-responsive">
    <div class="float-end mb-5">
        <form method="get" class="row">
            <div class="col-3">
                <div class="input-group">
                    <select class="form-control" id="unit">
                        <option value="">{{__('produk.choose_unit')}}</option>
                        @foreach ($unit as $u)
                            <option value="{{ $u->id }}" @if (isset($_GET['unit']))  @if ($u->id==$_GET['unit']) selected @endif
                        @endif>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group">
                    <select class="form-control" id="brand">
                        <option value="">{{__('produk.choose_brand')}}</option>
                        @foreach ($brand as $b)
                            <option value="{{ $b->id }}" @if (isset($_GET['brand']))  @if ($b->id==$_GET['brand']) selected @endif
                        @endif>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="name" placeholder="{{__('produk.name')}}"
                        value="@if (isset($_GET['name'])) {{ $_GET['name'] }} @endif">
                    <div class="input-group-append">
                        <button class="btn btn-primary" onclick="searchProduct()" ><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped" id="tableExport">
        <thead>
            <tr>
                <th class="text-center"> No </th>
                <th>{{ __('general.image') }}</th>
                <th>{{ __('produk.name') }}</th>
                <th>{{ __('category.category_name') }}</th>
                <th>{{ __('general.sell_price') }}</th>
                <th>{{ __('general.purchase_price') }}</th>
                <th>{{ __('sidebar.unit') }}</th>
                <th>{{ __('sidebar.brand') }}</th>
                <th>{{ __('general.stock') }}</th>
                <th>{{ __('general.stock') }}</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $d)
                <tr>
                    <td>{{ $no++ }} </td>
                    <td>
                        <img src="{{ asset($d->image) }}" style="width: 50px; border-radius:10%">
                    </td>
                    <td> {{ $d->name }} </td>
                    <td> {{ $d->category->name ?? '' }} </td>
                    <td> {{ $d->price_sell_range }} </td>
                    <td> {{ $d->price_purchase_range }} </td>
                    <td> {{ $d->unit->name ?? '' }} </td>
                    <td> {{ $d->brand->name ?? '' }} </td>
                    <td> {{$d->stock_total}}  </td>
                    <td>
                        @can("Update Produk")
                        <a href="{{ route('product.update', $d->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('product.opening', $d->id) }}" class="btn btn-sm btn-success"><i class="fa fa-cubes"></i> {{__('produk.open_stock')}}</a>
                        @endcan
                        @can("Hapus Produk")
                        <a href="{{ route('product.delete', $d->id) }}"  class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links('partials.product_pagination') }}
</div>

