 <div class="table-responsive">
     <table class="table table-striped">
         <thead>
             <tr>
                 <th>{{__('general.action')}}</th>
                 <th>{{__('general.date')}}</th>
                 <th>{{__('general.ref_no')}}</th>
                 <th>{{__('general.store')}}</th>
                 <th>{{__('supplier.name')}}</th>
                 <th>{{__('report.return_product')}}</th>
                 <th>{{__('report.return_qty')}}</th> 
                 <th>{{__('general.total')}}</th>
             </tr>
         </thead>
         <tbody>

             @foreach ($data as $d)
             <tr>
                 <td>
                     <div class="btn-group mb-1">
                         <div class="dropdown">
                             <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <i class="bi bi-error-circle me-50"></i> {{__('general.action')}}
                             </button>
                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                 @can("Detail Return")
                                 <a class="dropdown-item" href="{{ route('return.detail', $d->id) }}">
                                     <i class="fas fa-eye"></i> {{__('general.detail')}}
                                 </a>
                                 @endcan
                                 @can("Print Return")
                                 <a target="_blank" class="dropdown-item" href="{{ route('return.print', $d->id) }}">
                                     <i class="fas fa-print"></i> {{__('general.print')}}
                                 </a>
                                 @endcan
                                 @can("Tambah Pembayaran Return")
                                 @if ($d->due_total != '0')
                                 <a class="dropdown-item" href="javascript:void(0)" id="{{ $d->id }}" onclick="getpaymentmodal(this.id)">
                                     <i class="fas fa-money-bill-wave"></i> {{__('general.add_payment')}}
                                 </a>
                                 @endif
                                 @endcan
                                 <a class="dropdown-item" href="javascript:void(0)">

                                 </a>
                             </div>
                         </div>
                     </div>
                 </td>
                 <td> {{ my_date($d->created_at) }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                 <td> {{ $d->ref_no }} </td>
                 <td> {{ $d->store->name ?? '' }} </td>
                 <td> {{ $d->supplier->name ?? '' }} </td>
                 <td> {{ count($d->returndetail) }} </td>
                 <td> {{ $d->qty_return }} </td> 
                 <td> {{ number_format($d->final_total) }} </td>
             </tr>
             @endforeach
         </tbody>
         <tfoot>
             <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                 <th colspan="7" style="height: 100px; font-size:30px">{{__('general.total')}}</th> 
                 <th>{{ number_format($jumlahTotal) }}</th>

             </tr>
         </tfoot>
     </table>

     {{ $data->links('partials.return_pagination') }}
     @can("Tambah Pembayaran Return")
     <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
     @endcan
 </div>
