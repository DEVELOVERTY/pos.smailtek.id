<div class="modal fade" id="billingmodal" tabindex="-1" role="dialog" aria-labelledby="billingmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="exampleModalLabel">Billing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="feather-x float-right"></i>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="mdhpos-filter">
                    <div class="filter">
                        <div class="filters-body">
                            <div class="bg-white shadow mb-3">
                                <div class="table-responsive pos-billing" style="height:60vh;">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%"><?php echo e(__('pos.qty')); ?></th>
                                                <th style="width: 30%"><?php echo e(__('sidebar.product')); ?></th>
                                                <th><?php echo e(__('pos.price')); ?></th>
                                                <th><?php echo e(__('general.subtotal')); ?></th>
                                                <th><i class="feather-trash"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartProduct">
                                            <tr class="table-success cart0 d-none"> <input type="hidden" id="productID"> </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-0">

                                        <tbody onchange="otherPriceTotal()">
                                            <tr>
                                                <td style="width: 50%">
                                                    <label for="discount"><?php echo e(__('purchase.discount_amount')); ?></label>
                                                    <input type="number" style="border: 1px solid black;" id="discount" class="form-control" name="discount" min="0" value="0">
                                                </td>
                                                <td style="width: 50%">
                                                    <label for="shipping"><?php echo e(__('purchase.shipping_cost')); ?></label>
                                                    <input type="number" style="border: 1px solid black;" id="shipping" class="form-control" name="shipping" min="0" value="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="tax"><?php echo e(__('purchase.tax')); ?></label>
                                                    <input type="number" style="border: 1px solid black;" id="taxPrice" class="form-control" name="tax" min="0" value="0">
                                                </td>
                                                <td>
                                                    <label for="other_price"><?php echo e(__('purchase.other_payment')); ?></label>
                                                    <input type="number" style="border: 1px solid black;" id="other_price" class="form-control" name="other_price" min="0" value="0">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="holdtype" class="d-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-0 border-0 p-3">

                <div class="col-6 m-0 pl-0 pr-1">
                    <a href="javascript:void(0)" id="holdbutton" class="btn border btn-lg btn-block">Tunggu</a>
                </div>
                <div class="col-6 m-0 pr-0 pl-1">
                    <button type="button" id="pay_shop" class="btn btn-primary btn-lg btn-block">Bayar</button>
                </div>
                <a href="javascript:void(0)" class="d-none" id="pay_modal_click" data-toggle="modal" data-target="#paymodal"></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="holdmodal" tabindex="-1" role="dialog" aria-labelledby="holdmodalLabel" aria-hidden="true">
    <div class="modal-dialog hold_modal">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="exampleModalLabel">Saving Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="feather-x float-right"></i>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="mdhpos-filter">
                    <div class="filter">
                        <div class="filters-body">
                            <div class="row p-3" id="holdlist"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-0 border-0 p-3">
                <div class="col-12 m-0 pr-0 pl-1">
                    <button type="button" class="btn btn-lg btn-block" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-labelledby="paymodalLabel" aria-hidden="true">
    <div class="modal-dialog payment_modal">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="feather-x float-right"></i>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="mdhpos-filter">
                    <div class="filter">
                        <div class="filters-body">
                            <div class="bg-white shadow mb-3">
                                <div class="col-md-12 form-group mt-3">
                                    <label class="form-label mb-1 small"><?php echo e(__('general.payment_total')); ?></label>
                                    <div class="input-group">
                                        <input style="border: 1px solid black;" type="text" class="form-control " id="on_pay" name="on_pay" min="0" value="0">
                                    </div>
                                </div>
                                <div class="col-md-12 form-group mt-2" id="duepay">
                                    <label class="form-label mb-1 small"><?php echo e(__('general.payment_due')); ?></label>
                                    <div class="input-group">
                                        <input style="border: 1px solid black;" type="text" class="form-control" id="on_due" name="on_due" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group mt-2 d-none" id="changepay">
                                    <label class="form-label mb-1 small"><?php echo e(__('pos.return_pay')); ?></label>
                                    <div class="input-group">
                                        <input style="border: 1px solid black;" type="text" class="form-control" id="on_change" name="on_change" readonly>
                                    </div>
                                </div>
                                <div class="mb-0 col-md-12 form-group">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                        <label class="btn btn-outline-secondary active">
                                            <input type="radio" name="options" id="cash" checked /> Cash
                                        </label>
                                        <label class="btn btn-outline-secondary">
                                            <input type="radio" name="options" id="bank" /> Bank Transfer
                                        </label>
                                        <label class="btn btn-outline-secondary">
                                            <input type="radio" name="options" id="card" /> Kartu Kredit
                                        </label>
                                    </div>
                                </div>
                                <div id="paymentprocess"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-0 border-0 p-3">
                        <div class="col-12 m-0 pr-0 pl-1">
                            <button type="submit" id="paytransaction" class="btn btn-primary btn-lg btn-block">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/components/pos-mobile/billing-component.blade.php ENDPATH**/ ?>