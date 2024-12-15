<div class="table-responsive">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.action')}}</th>
                <th>{{__('general.date')}}</th>
                <th>{{__('general.ref_no')}}</th>
                <th>{{__('general.store')}}</th>
                <th>{{__('supplier.name')}}</th>
                <th>{{__('purchase.received_status')}}</th>
                <th>{{__('general.payment_status')}}</th>
                <th>{{__('general.pay_amount')}}</th>
                <th>{{__('general.po_due_amount')}}</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $d)
            <tr class="purchase_order">
                <td>
                    <div class="btn-group mb-1">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="bi bi-error-circle me-50"></i> Action </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                @can("Detail Purchase")
                                <a class="dropdown-item" href="{{ route('purchase.detail', $d->id) }}">
                                    <i class="fas fa-eye"></i> {{__('general.detail')}}
                                </a>
                                @endcan
                                @can("Print Purchase")
                                <a target="_blank" class="dropdown-item" href="{{ route('purchase.print', $d->id) }}">
                                    <i class="fas fa-print"></i> {{__('general.print')}}
                                </a>
                                @endcan

                                @if ($d->status != 'received')
                                @can("Update Status Purchase")
                                <a class="dropdown-item po-edit" href="javascript:void(0)" id="{{ $d->id }}" onclick="getstatusmodal(this.id)">
                                    <i class="fas fa-check-circle"></i> {{__('general.change_status')}}
                                </a>
                                @endcan
                                @endif
                                 @if($d->payment_status == 'due')
                                    @if($d->due_total < $d->pay_total)
                                        @can("Update Status Purchase")
                                        <a class="dropdown-item po-edit" href="javascript:void(0)" id="{{ $d->id }}" onclick="getstatuspayment(this.id)">
                                            <i class="fas fa-money-bill-wave"></i> {{__('purchase.change_payment_status')}}
                                        </a>
                                        @endcan
                                    @endif
                                @endif
                                @if ($d->due_total != '0')
                                @can("Tambah Pembayaran Purchase")
                                <a class="dropdown-item" href="javascript:void(0)" id="{{ $d->id }}" onclick="getpaymentmodal(this.id)">
                                    <i class="fas fa-money-bill-wave"></i> {{__('general.add_payment')}}
                                </a>
                                @endcan
                                @endif 
                                @can("Produk Label")
                                <a class="dropdown-item" href="{{ route('barcode.purchase',$d->id) }}">
                                    <i class="fas fa-barcode"></i> {{__('produk.print_label')}}
                                </a>
                                @endcan
                                @can("Tambah Return") 
                                @if($d->status == 'received')
                                <a class="dropdown-item" href="{{ route('return.po',$d->id) }}">
                                    <i class="fas fa-redo"></i> {{__('purchase.return')}}
                                </a>
                                @endif
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
                <td> {{ $d->supplier->name ?? '' }} </td>
                <td> <span class=" badge bg-primary text-white">{{ $status[$d->status] }}</span> {{ $d->return }}</td>
                <td> <span class=" badge bg-primary text-white">{{ $payment[$d->payment_status] }}</span>
                </td>
                <td> {{ $d->pay_total }} </td>
                <td> {{ number_format($d->due_total ?? $d->final_total) }} </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links('partials.purchase_pagination') }}
    <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
    <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
    <a href="javascript:void(0)" class="d-none" id="update_payment" data-bs-toggle="modal" data-bs-target="#updatepayment"></a>
</div>
