@extends('layouts.admin')
@section('content') 

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can('Laporan Hutang')
                    <a class="btn btn-md btn-primary float-end" href="{{ route('due.report') }}"><i class="fa fa-list"></i> {{__('sidebar.debt_book')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
 
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card blue-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" id="identity" value="{{ $data->id }}">
                                <div class="col-sm-12 col-md-6 mb-3">
                                    <label class="control-label">{{__('general.start_date')}}</label>
                                    <div class="input-group">
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 mb-3">
                                    <label class="control-label">{{__('general.end_date')}}</label>
                                    <div class="input-group">
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="searchProduct()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 2px solid black">
                                <div class="col-12">
                                    <h4>{{__('report.general_info')}}</h4>
                                    <table class="table">
                                        <tr>
                                            <th>{{__('customer.name')}} : </th>
                                            <th>{{ $data->customer->name ?? '' }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{__('purchase.date')}} : </th>
                                            <th>{{ my_date($data->created_at) }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{__('sell.due_total')}} : </th>
                                            <th> {{ my_currency($data->final_total) }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{__('report.product_purchase')}} : </th>
                                            <th>
                                                <ul>
                                                    @foreach($data->sell as $s)
                                                        <li> {{$s->variation->product->name ?? ''}} @if($s->variation->name != 'no-name') {{ ' - '. $s->variation->name ?? '' }} @endif - ({{ number_format($s->unit_price) }})</li>
                                                    @endforeach
                                                  
                                                </ul>
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                            </div>
                            <div class="col-6"> 
                                @can("Tambah Pembayaran Hutang")
                                <a href="javascript:void(0)" id="{{ $data->id }}" onclick="getpaymentmodal(this.id)" class="btn btn-sm btn-success float-end" style="margin-top: -5px; margin-right:5px; border: 2px solid white"><i class="fas fa-plus-circle"></i> {{__('general.add_payment')}}</a>
                                @endcan
                                @can("Update Status Hutang")
                                <a href="javascript:void(0)"  id="{{ $data->id }}" onclick="getstatusmodal(this.id)" class="btn btn-sm btn-success float-end" style="margin-top: -5px; margin-right:5px; border: 2px solid white"><i class="fas fa-check-circle"></i> {{__('general.change_status')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="dueContent">
                            {{-- Content Product --}} 
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
                            {{-- End Content --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@can("Update Status Hutang")
<div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{ route('purchase.status') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="">{{__('general.change_status')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name">{{__('general.payment_status')}}</label>
                    <input type="hidden" name="id" id="ti" value="">
                    <select class="form-control" name="status">
                        <option value="final">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.close') }}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.change_status') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endcan
@can("Tambah Pembayaran Hutang")
<div class="modal fade" id="addpay" tabindex="-1" role="dialog" aria-labelledby="add-pay" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full payment_modal" role="document">
        <form method="POST" action="{{ route('purchase.payment') }}" class="modal-content">
            @csrf
            <div class="modal-header header-modal ">
                <input type="hidden" name="transaction_id" id="tri" value="">
                <h5 class="modal-title text-white" id="">{{__('general.add_payment')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="row" id="paymentsession">
                            <div class="col-md-6 form-group">
                                <label>{{__('general.payment_method')}}</label>
                                <select class="choices form-select" name="payment_method" id="payment_method">
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="card">Card</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{__('general.payment_date')}}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{date('Y-m-d H:i:s')}}" id="paid_date" name="paid_date" readonly="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row" id="paymentprocess">
                                    <div class="col-md-6 form-group">
                                        <label>{{__('general.payment_total')}}</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="0" id="payment_amount" name="payment_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>{{__('general.payment_note')}}</label>
                                <textarea class="form-control" name="payment_note"></textarea>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.close') }}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('general.add_payment')}}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endcan 
@section('scripts') 
    <script>
       

        function getstatusmodal(id) {
            $("#ti").val(id);
            document.getElementById("update_status").click();
        }

        function getpaymentmodal(id) {
            $("#tri").val(id);
            document.getElementById("add_payment").click();
        }
        
        var start = null;
        var end = null;

        function searchProduct() { 
            var start = $("#start_date").val();
            var end = $("#end_date").val();
            var identity = $("#identity").val();
            var url = domainpath + '/pos-admin/report/transaction/due/payment/'+identity+'?start_date=' + start + '&end_date=' + end + '';
            console.log(url);
            spinner.show();
            setTimeout(function() {
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#dueContent').html(result);

                    }
                });
                spinner.hide();
            }, 130);
        }
    </script>
@endsection
@endsection
