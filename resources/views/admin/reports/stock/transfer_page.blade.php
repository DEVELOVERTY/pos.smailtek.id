<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.date')}}</th>
                <th>{{__('transfer.from')}}</th>
                <th>{{__('transfer.to')}}</th>
                <th>{{__('transfer.status')}}</th>
                <th>{{__('purchase.shipping_cost')}}</th>
                <th>{{__('report.qty_product')}}</th>
                <th>{{__('general.total')}}</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $d)
            <tr>
                <td> {{ $d->created_at }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                <td> {{ $d->transfer->fromstore->name ?? '' }} </td>
                <td> {{ $d->transfer->tostore->name ?? '' }} </td>
                <td> <span class=" badge bg-primary text-white">{{ $status[$d->status] }}</span> </td>
                <td> {{ number_format($d->shipping_charges) }} </td>
                <td> <span class=" badge bg-primary text-white">{{ count($d->manytransfer) }} Product</span> <span class=" badge bg-primary text-white">{{ $d->transfer_qty }} Quantity</span> </td>
                <td> {{ number_format($d->final_total) }} </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="6" style="height: 100px; font-size:30px">{{__('general.total')}}</th>
                <th> {{ my_currency($jumlah) }}</th>
            </tr>
        </tfoot>
    </table>

    {{ $data->links('partials.return_pagination') }}
</div>