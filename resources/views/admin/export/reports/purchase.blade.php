<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="11" style="background-color: yellow; text-align:center; font-size: 30px; height: 50px; font-weight:50;"><b>{{__('sidebar.purchase_report')}}</b></th>
        </tr>
        <tr>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.date')}}</th>
            <th style="width: 20px; text-align:center">{{__("general.ref_no")}}</th>
            <th style="width: 20px; text-align:center">{{__('general.store')}}</th>
            <th style="width: 20px; text-align:center">{{__('supplier.name')}}</th>
            <th style="width: 20px; text-align:center">{{__('report.product_purchase')}}</th>
            <th style="width: 20px; text-align:center">{{__('report.qty_purchase')}}</th>
            <th style="width: 20px; text-align:center">{{__('purchase.received_status')}}</th>
            <th style="width: 20px; text-align:center">{{__('general.payment_status')}}</th>
            <th style="width: 20px; text-align:center">{{__('purchase.net_total')}}</th>
            <th style="width: 20px; text-align:center">{{__('general.pay_amount')}}</th>
            <th style="width: 20px; text-align:center">{{__('general.po_due_amount')}}</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color:#3c8dbc; color:white">1</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">2</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">3</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">4</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">5</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">6</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">7</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">8</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">9</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">10</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">11</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($data as $d)
        <tr class="purchase_order">

            <td style="text-align:left;"> {{ $d->created_at }}</td>
            <td style="text-align:left;"> {{ $d->ref_no }} </td>
            <td style="text-align:left;"> {{ $d->store->name ?? '' }} </td>
            <td style="text-align:left;"> {{ $d->supplier->name ?? '' }} </td>
            <td style="text-align:left;"> {{ count($d->purchase) }} </td>
            <td style="text-align:left;"> {{ $d->qty_purchase }} </td>
            <td>{{ $status[$d->status] }}</td>
            <td>{{ $payment[$d->payment_status] }}</td>
            <td style="text-align:right;"> {{ number_format($d->final_total) }} </td>
            <td style="text-align:right;"> {{ $d->pay_total }} </td>
            <td style="text-align:right;"> {{ number_format($d->due_total ?? $d->final_total) }} </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
            <th colspan="8" style="height: 30px; font-size:20px; background-color:#5cb85c; text-align:center;"><b>{{__('general.total')}}</b> </th>
            <th style="text-align:right;"><b>{{ number_format($jumlahTotal) }}</b></th>
            <th style="text-align:right;"><b>{{ number_format($jumlahTerbayar) }}</b></th>
            <th style="text-align:right;"><b>{{ number_format($jumlahHutang) }}</b></th>
        </tr>
    </tfoot>
</table>
