<div class="card-body">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                            <th>{{__('sidebar.transaction_reports')}}</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{__('report.total_purchase')}}</td>
                            <td class="text-right">: {{ my_currency($data['total_purchase']->total ?? 0) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.total_sell')}}</td>
                            <td class="text-right">: {{ my_currency($data['total_sell']->total ?? 0) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.shipping_purchase')}}</td>
                            <td class="text-right">: {{ my_currency($data['purchase_shipping']) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.purchase_discount')}}</td>
                            <td class="text-right">: {{ my_currency($data['purchase_discount']) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.sell_discount')}}</td>
                            <td class="text-right">: {{ my_currency($data['sell_discount']) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.shipping_sell')}} </td>
                            <td class="text-right">: {{ my_currency($data['sell_shipping']) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.total_adjustment')}}</td>
                            <td class="text-right">: {{ my_currency($data['stock_adjustment']->total ?? 0) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.total_recovered')}} </td>
                            <td class="text-right">: {{ my_currency($data['amount_recovered']) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.total_expense')}}</td>
                            <td class="text-right">: {{ my_currency($data['total_expense']) }} </td>
                        </tr>
                        <tr>
                            <td>{{__('report.shipping_transfer')}}</td>
                            <td class="text-right">: {{ my_currency($data['transfer_shipping']) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                            <th>{{__('report.profitloss')}} </th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>{{__('general.total')}} </td>
                            <td class="text-right">: {{ my_currency($gross) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                @php
                $profitsell_after_return = $profitsell->terjual - $profitsell->dikembalikan;
                @endphp
                <table class="table">
                    <tbody>
                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                            <th>{{__('report.profitsell')}}</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>{{__("report.net_profit_before_return")}} </td>
                            <td class="text-right">: {{ my_currency($profitsell->terjual) }}</td>
                        </tr>
                        <tr>
                            <td>{{__("report.net_profit_after_return")}} </td>
                            <td class="text-right">: {{ my_currency($profitsell->dikembalikan) }}</td>
                        </tr>
                        <tr>
                            <td>{{__('report.return_sell_after_purchase')}} </td>
                            <td class="text-right">: {{ my_currency($profitsell_after_return) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                            <th>{{__('report.net_profit')}}</th>
                            <th width="30%"></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td style="font-size:12px">{{__('report.profitloss')}}</td>
                            <td class="text-right">: {{ my_currency($gross) }}</td>
                            <td class="text-right">(+)</td>
                        </tr>
                        <tr>
                            <td style="font-size:12px">{{__('report.total_adjustment')}} + {{__('report.total_expense')}} + {{__('report.shipping_purchase')}} + {{__('report.shipping_transfer')}} + {{__('report.sell_discount')}}</td>
                            @php
                            $adjustment = $data['stock_adjustment']->total ?? 0;
                            $jumlah = $adjustment + $data['total_expense'] + $data['purchase_shipping'] + $data['transfer_shipping'] + $data['sell_discount'];
                            @endphp
                            <td class="text-right">: {{ my_currency($jumlah) }}</td>
                            <td class="text-right">(-)</td>
                        </tr>
                        <tr>
                            <td style="font-size:12px">{{__('report.shipping_sell')}} + {{__('report.total_recovered')}} + {{__('report.purchase_discount')}}</td>
                            @php
                            $jml = $data['sell_shipping'] + $data['amount_recovered'] + $data['purchase_discount'];
                            @endphp
                            <td class="text-right">: {{ my_currency($jml) }}</td>
                            <td class="text-right">(+)</td>
                        </tr>
                        <tr style="background-color: #5cb85c;" class="text-white">
                            <td>{{__('general.total')}} </td>
                            <td class="text-right">: {{ my_currency($profit) }}</td>
                            <td class="text-right"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
