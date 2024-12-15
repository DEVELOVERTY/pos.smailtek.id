<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>{{__('produk.name')}}</th>
                <th>{{__('general.store')}}</th>
                <th>{{__('report.total_stock')}}</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach ($data as $d)
            <tr class="purchase_order">
                <td>{{$no++}}</td>
                <td> {{ $d->product_name }} - {{$d->variation_name}} </td>
                <td> {{ $d->store_name}} </td>
                <td> {{ number_format($d->stok) }} </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    {{ $data->links('partials.purchase_pagination') }}
</div>