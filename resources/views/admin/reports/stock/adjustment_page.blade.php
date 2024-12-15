<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.date')}}</th>
                <th>{{__('general.store')}}</th>
                <th>{{__('general.type')}}</th>
                <th>{{__('report.qty_product')}}</th>
                <th>{{__('adjustment.amount_total')}}</th>
                <th>{{__('adjustment.amount_recovered')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td> {{ $d->created_at }}</td>
                <td> {{ $d->store->name ?? '' }} </td>
                <td> <span class=" badge bg-primary text-white">{{ $d->adjustment_type }}</span> </td>
                <td> <span class=" badge bg-primary text-white">{{ count($d->adjustment) }} Product</span> <span class=" badge bg-primary text-white">{{ $d->adjustment_qty }} Qty</span> </td>
                <td> {{ number_format($d->final_total) }} </td>
                <td> {{ number_format($d->total_amount_recovered) }} </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="5" style="height: 100px; font-size:30px">Total</th>
                <th> {{ my_currency($jumlah) }}</th>
            </tr>
        </tfoot>
    </table>
    {{ $data->links('partials.return_pagination') }}
</div>