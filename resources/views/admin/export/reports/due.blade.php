<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="7" style="background-color: yellow; text-align:center; font-size: 30px; height: 50px; font-weight:50;"><b>{{__('sidebar.debt_book')}}</b></th>
        </tr>
        <tr>
            <th style="width: 20px; text-align:center; height: 40px;"><b>{{__('general.date')}}</b></th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.ref_no')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.store')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('customer.name')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('hrm.amount_total')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.pay_amount')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.sell_due_amount')}}</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color:#3c8dbc; color:white">1</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">2</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">3</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">4</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">5</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">6</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">7</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr class="purchase_order">
            <td> {{ $d->created_at }}</td>
            <td> {{ $d->ref_no }} </td>
            <td> {{ $d->store->name ?? '' }} </td>
            <td> {{ $d->customer->name ?? '' }} </td>
            <td> {{ number_format($d->final_total) }} </td>
            <td> {{ $d->pay_total }} </td>
            <td> {{ number_format($d->due_total ?? $d->final_total) }} </td>
        </tr>
        @endforeach

    </tbody>
    <tfoot>
        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
            <th colspan="4" style="height: 30px; font-size:20px; background-color:#5cb85c; text-align:center;">{{__('general.total')}}</th>
            <th style="text-align:right;"><b>{{ number_format($jumlahTotal) }}</b></th>
            <th style="text-align:right;"><b>{{ number_format($jumlahTerbayar) }}</b></th>
            <th style="text-align:right;"><b>{{ number_format($jumlahHutang) }}</b></th>
        </tr>
    </tfoot>
</table>
