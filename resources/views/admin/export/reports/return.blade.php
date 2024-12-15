<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="7" style="background-color: yellow; text-align:center; font-size: 30px; height: 50px; font-weight:50;"><b>{{__('sidebar.return_report')}}</b></th>
        </tr>
        <tr>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.date')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.ref_no')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.store')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('supplier.name')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('report.return_product')}}</th>
            <th style="width: 20px; text-align:center; height: 40px;">{{__('report.return_qty')}}</th> 
            <th style="width: 20px; text-align:center; height: 40px;">{{__('general.total')}}</th> 
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
        <tr>

            <td style="text-align:left;"> {{ $d->created_at }}</td>
            <td style="text-align:left;"> {{ $d->ref_no }} </td>
            <td style="text-align:left;"> {{ $d->store->name ?? '' }} </td>
            <td style="text-align:left;"> {{ $d->supplier->name ?? '' }} </td>
            <td style="text-align:left;"> {{ count($d->returndetail) }} </td>
            <td style="text-align:left;"> {{ $d->qty_return }} </td>  
            <td style="text-align:right;"> {{ number_format($d->final_total) }} </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
            <th colspan="6" style="height: 30px; font-size:20px; background-color:#5cb85c; text-align:center;">{{__('general.total')}}</th> 
            <th style="text-align:right;"><b>{{ number_format($jumlahTotal) }}</b></th>

        </tr>
    </tfoot>
</table>
