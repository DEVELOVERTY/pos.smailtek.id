 <div class="table-responsive">
     <table class="table table-striped">
         <thead>
             <tr>
                 <th>{{__('general.action')}}</th>
                 <th>{{__('general.date')}}</th>
                 <th>{{__('general.ref_no')}}</th>
                 <th>{{__('transfer.from')}}</th>
                 <th>{{__('transfer.to')}}</th>
                 <th>{{__('transfer.status')}}</th>
                 <th>{{__('purchase.shipping_cost')}}</th>
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
                                 @can("Detail Stock Transfer")
                                 <a class="dropdown-item" href="{{ route('transfer.detail', $d->id) }}">
                                     <i class="fas fa-eye"></i> {{__('general.detail')}}
                                 </a>
                                 @endif
                                 @can("Update Status Stock Transfer")
                                 @if ($d->status != 'complete')
                                 <a class="dropdown-item po-edit" href="javascript:void(0)" id="{{ $d->id }}" onclick="getstatusmodal(this.id)">
                                     <i class="fas fa-check-circle"></i> {{__('general.change_status')}}
                                 </a>
                                 @endif
                                 @endcan
                                 @can("Print Stock Transfer")
                                 <a target="_blank" class="dropdown-item" href="{{ route('transfer.print', $d->id) }}">
                                     <i class="fas fa-print"></i> {{__('general.print')}}
                                 </a>
                                 @endcan
                                 <a class="dropdown-item" href="javascript:void(0)">

                                 </a>
                             </div>
                         </div>
                     </div>
                 </td>
                 <td> {{ my_date($d->created_at) }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                 <td> {{ $d->ref_no }} </td>
                 <td> {{ $d->transfer->fromstore->name ?? '' }} </td>
                 <td> {{ $d->transfer->tostore->name ?? '' }} </td>
                 <td> <span class=" badge bg-primary text-white">{{ $status[$d->status] }}</span> </td>
                 <td> {{ number_format($d->shipping_charges) }} </td>
                 <td> {{ number_format($d->final_total) }} </td> 
             </tr>
             @endforeach
         </tbody>
     </table>

     {{ $data->links('partials.return_pagination') }}
     <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a> 
 </div>
