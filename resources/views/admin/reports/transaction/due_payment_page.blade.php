<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.payment_date')}}</th>
                <th>{{__('general.payment_total')}}</th>
                <th>{{__('general.payment_note')}}</th>
                <th>{{__('general.note')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payment as $d)
            <tr class="purchase_order">
                @php
                $method = '';
                if ($d->method == 'cash') {
                $method = 'Cash';
                } elseif ($d->method == 'bank_transfer') {
                $method = 'Bank Transfer';
                } elseif ($pay->method == 'card') {
                $method = 'Card';
                } elseif ($d->method == 'other') {
                $method = 'Lainnya';
                }
                @endphp
                <td> {{ $d->created_at }} </td>
                <td> {{ number_format($d->amount) }} </td>
                <td> {{ $method }} </td>
                <td> {{ $d->note }} </td>

            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="3" style="height: 50px; font-size:25px">{{__('general.sell_due_amount')}} : </th>
                <th style="font-size: 20px">Rp. {{ $data->pay_total }}</th>
            </tr>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="3" style="height: 50x; font-size:25px">{{__('report.remaining_debt')}} : </th>
                <th style="font-size: 20px">Rp. {{ number_format($data->due_total) }}</th>
            </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
    <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
</div>
