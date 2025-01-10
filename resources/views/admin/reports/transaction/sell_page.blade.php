<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.action')}}</th>
                <th>{{__('general.date')}}</th>
                <th>{{__('general.ref_no')}}</th>
                <th>{{__('general.store')}}</th>
                <th>{{__('customer.name')}}</th>
                <th>{{__('general.payment_status')}}</th>
                <th>{{__('report.product_sell')}}</th>
                <th>{{__('report.qty_sell')}}</th>
                <th>{{__('hrm.amount_total')}}</th>
                <th>{{__('general.pay_amount')}}</th>
                <th>{{__('general.payment_method')}}</th>
                <th>{{__('general.sell_due_amount')}}</th>
                <th>{{__('report.profit_amount')}}</th>
                <th>{{__('report.createdby')}}</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $d)
            <tr class="purchase_order">
                <td>
                    <div class="btn-group mb-1">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-error-circle me-50"></i> {{__('general.action')}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                @can("Detail Penjualan")
                                <a class="dropdown-item" href="{{ route('sell.detail', $d->id) }}">
                                    <i class="fas fa-eye"></i> {{__('general.detail')}}
                                </a>
                                @endcan
                                @can("Print Penjualan")
                                <a target="_blank" class="dropdown-item" href="{{ route('sell.print', $d->id) }}">
                                    <i class="fas fa-print"></i> {{__('general.print')}}
                                </a>
                                @endcan
                                @can("Return Penjualan")
                                <a class="dropdown-item" href="{{ route('returnsell.create', $d->id) }}">
                                    <i class="fas fa-redo"></i> {{__('sell.return_sell')}}
                                </a>
                                @endcan
                                @can("Tambah Pembayaran Penjualan")
                                @if ($d->due_total != '0')
                                <a class="dropdown-item" href="javascript:void(0)" id="{{ $d->id }}" onclick="getpaymentmodal(this.id)">
                                    <i class="fas fa-money-bill-wave"></i> {{__('general.add_payment')}}
                                </a>
                                @endif
                                @endcan 
                            </div>
                        </div>
                    </div>
                </td>
                <td> {{ my_date($d->created_at) }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                <td> {{ $d->ref_no }} </td>
                <td> {{ $d->store->name ?? '' }} </td>
                <td> {{ $d->customer->name ?? '' }} </td>
                <td> <span class=" badge bg-primary text-white">{{$status[$d->status]}} </span> </td>
                <td> <span class=" badge bg-primary text-white">{{ count($d->sell) }}</span> {{$d->return_sell}}</td>
                <td> <span class=" badge bg-primary text-white">0</span> </td>
                <td> {{ number_format($d->final_total) }} </td>
                <td> {{ $d->pay_total }} </td>
                <td> {{ $d->method }} </td>
                <td> {{ number_format($d->due_total ?? $d->final_total) }} </td>
                <td> {{ number_format($d->profit) }} </td>
                <td> {{ $d->createdby->name ?? '' }} </td>
            </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="9" style="height: 100px; font-size:30px">{{__('report.total_income')}} : {{ number_format($jumlahProfit) }}</th>
                <th>{{ number_format($jumlahTotal) }}</th>
                <th></th>
                <th>{{ number_format($jumlahTerbayar) }}</th>
                <th>{{ number_format($jumlahHutang) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    {{ $data->links('partials.purchase_pagination') }}
    <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
    <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
</div>