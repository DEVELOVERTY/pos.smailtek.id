<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.action')}}</th>
                <th>{{__('general.date')}}</th>
                <th>{{__('general.ref_no')}}</th>
                <th>{{__('general.store')}}</th>
                <th>{{__('customer.name')}}</th>
                <th>{{__('hrm.amount_total')}}</th>
                <th>{{__('general.pay_amount')}}</th>
                <th>{{__('general.sell_due_amount')}}</th>
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
                                @can("Detail Hutang")
                                <a class="dropdown-item" href="{{ route('due.detail', $d->id) }}">
                                    <i class="fas fa-eye"></i> {{__('general.detail')}}
                                </a>
                                @endcan
                                @can("Print Laporan Hutang")
                                <a target="_blank" class="dropdown-item" href="{{ route('due.print', $d->id) }}">
                                    <i class="fas fa-print"></i> {{__('general.print')}}
                                </a>
                                @endcan
                                @can("List Credit Hutang")
                                <a class="dropdown-item" href="{{ route('due.payment', $d->id) }}">
                                    <i class="fas fa-money-bill"></i>{{__('report.payment_list')}}
                                </a>
                                @endcan
                                <a class="dropdown-item" href="#">
                                    -
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
                <td> {{ my_date($d->created_at) }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
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
                <th colspan="5" style="height: 100px; font-size:30px">{{__('general.total')}}</th>
                <th>{{ number_format($jumlahTotal) }}</th>
                <th>{{ number_format($jumlahTerbayar) }}</th>
                <th>{{ number_format($jumlahHutang) }}</th>
            </tr>
        </tfoot>
    </table>

    {{ $data->links('partials.purchase_pagination') }}
</div>
