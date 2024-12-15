<div class="col-xl-5 col-md-5 col-sm-12 billing-pos" style="background-color: #fff;">
    <div class="table-responsive pos-billing" style="height:53vh;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 15%"><?php echo e(__('pos.qty')); ?></th>
                    <th style="width: 30%"><?php echo e(__('sidebar.product')); ?></th>
                    <th><?php echo e(__('pos.price')); ?></th>
                    <th><?php echo e(__('general.subtotal')); ?></th>
                    <th><i class="fa fa-trash"></i></th>
                </tr>
            </thead>
            <tbody id="cartProduct">
                <tr class="table-success cart0 d-none"> <input type="hidden" id="productID"> </tr>
            </tbody>
        </table>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="width: 50%"></th>
                <th style="width: 50%"></th>
            </tr>
        </thead>
        <tbody onchange="otherPriceTotal()">
            <tr class="">
                <td>
                    <label for="discount"><?php echo e(__('purchase.discount_amount')); ?></label>
                    <input type="number" id="discount" class="form-control" name="discount" min="0" value="0">
                </td>
                <td>
                    <label for="shipping"><?php echo e(__('purchase.shipping_cost')); ?></label>
                    <input type="number" id="shipping" class="form-control" name="shipping" min="0" value="0">
                </td>
            </tr>
            <tr class="">
                <td>
                    <label for="tax"><?php echo e(__('purchase.tax')); ?></label>
                    <input type="number" id="taxPrice" class="form-control" name="tax" min="0" value="0">
                </td>
                <td>
                    <label for="other_price"><?php echo e(__('purchase.other_payment')); ?></label>
                    <input type="number" id="other_price" class="form-control" name="other_price" min="0" value="0">
                </td>
            </tr>
        </tbody>
    </table>

    <a href="javascript:void(0)" id="pay_shop" class="card text-white my-2" style="background-color: #198754; padding:2%">
        <div>
            <div class="float-end">
                <div class="text-white">
                    <input type="hidden" name="fixtotal" id="jumlahtotal" value="0">
                    <p class="mb-0 font-weight-bold text-white" style="font-size: 30px;" id="fixTotal">0</p>
                </div>
            </div>
            <p class="text-white-50 mb-0 mt-1">
                <i class="fas fa-shopping-basket h5 text-white" style="font-size: 30px;"></i>
            </p>
        </div>
    </a>
    <a href="javascript:void(0)" class="d-none" id="pay_modal_click" data-bs-toggle="modal" data-bs-target="#paymodal"></a>
</div><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/components/pos/bill-component.blade.php ENDPATH**/ ?>