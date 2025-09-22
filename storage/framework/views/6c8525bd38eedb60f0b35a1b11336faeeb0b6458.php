
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/apexcharts/apexcharts.css')); ?>">
<?php $__env->stopSection(); ?>


<div class="page-content">
    <div class="container-fluid">

        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Selamat datang Kembali <?php echo e(Auth()->user()->name); ?> </li>
                    </ol>
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-lx-8 col-sm-12">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Penjualan 30")): ?>
                <div class="card">
                    <div class="card-body mt-2">
                        <div id="sellMonth"></div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Laporan Purchase')): ?>
                    <div class="col-12 col-lg-6 col-xl-4">
                        <a href="<?php echo e(route('purchase.report')); ?>" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4"><?php echo e(my_currency($data['total_purchase'])); ?></span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0"><?php echo e(__('purchase.purchase_total')); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Laporan Hutang')): ?>
                    <div class="col-12 col-lg-6 col-xl-4">
                        <a href="<?php echo e(route('due.report')); ?>" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4"><?php echo e(my_currency($data['total_due'])); ?></span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0"><?php echo e(__('sell.total_due')); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Laporan Pengeluaran")): ?>
                    <div class="col-12 col-lg-6 col-xl">
                        <a href="<?php echo e(route('expense.report')); ?>" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4"><?php echo e(my_currency($data['total_expense'])); ?></span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0"><?php echo e(__('expense.total_expense')); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="col-md-4 col-lx-4 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Laporan Pengeluaran")): ?>
                        <a href="<?php echo e(route('sell.report')); ?>" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4"><?php echo e(my_currency($data['total_sell'])); ?></span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0"><?php echo e(__('sell.total_sell')); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Pengeluaran dan Pendapatan")): ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header header-modal" style="height: 10px">
                                    <h5 class="card-title text-white" style="margin-top: -10px">Profit Vs Pengeluaran</h5>
                                </div>
                                <div class="card-body mt-2">
                                    <div id="incomeExpense" style="height:300px"></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">






            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("POS")): ?>
            <a href="<?php echo e(route('pos.index')); ?>" class="col-6 col-lg-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-desktop"></i>
                                <h6 class="text-white font-semibold"><?php echo e(__('general.pos')); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Penjualan")): ?>
            <a href="<?php echo e(route('sell.report')); ?>" class="col-6 col-lg-2">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-shopping-cart"></i>
                                <h6 class="text-white font-semibold"><?php echo e(__('general.sell')); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Produk")): ?>
            <a href="<?php echo e(route('product.index')); ?>" class="col-6 col-lg-2">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-cubes"></i>
                                <h6 class="text-white font-semibold"><?php echo e(__('sidebar.product')); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Purchase")): ?>
            <a href="<?php echo e(route('purchase.index')); ?>" class="col-6 col-lg-2">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-cart-plus"></i>
                                <h6 class="text-white font-semibold"><?php echo e(__('sidebar.purchase')); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Laporan Hutang")): ?>
            <a href="<?php echo e(route('due.report')); ?>" class="col-6 col-lg-2">
                <div class="card bg-secondary">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-list"></i>
                                <h6 class="text-black font-semibold"><?php echo e(__('sell.due')); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Pengeluaran")): ?>
            <a href="<?php echo e(route('expense.index')); ?>" class="col-6 col-lg-2">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-money-bill"></i>
                                <h6 class="text-white font-semibold"><?php echo e(__('sidebar.expense')); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <?php endif; ?>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Pengeluaran dan Pendapatan")): ?>
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-modal" style="height: 10px">
                        <h5 class="card-title text-white" style="margin-top: -10px">Transaksi</h5>
                    </div>
                    <div class="card-body mt-2">
                        <div id="transactiondata" style="height:350px"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
 
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Aktivitas Terbaru")): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-modal" style="height: 10px">
                        <h5 class="card-title text-white" style="margin-top: -10px"><?php echo e(__('general.new_activity')); ?></h5>
                    </div>
                    <div class="card-body mt-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="sell-tab" data-bs-toggle="tab" href="#sell" role="tab" aria-controls="sell" aria-selected="true"><?php echo e(__('general.sell')); ?></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="purchase-tab" data-bs-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="false"><?php echo e(__('sidebar.purchase')); ?></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="transfer-tab" data-bs-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="false"><?php echo e(__('sidebar.r_stock_transfer')); ?></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="adjustment-tab" data-bs-toggle="tab" href="#adjustment" role="tab" aria-controls="adjustment" aria-selected="false"><?php echo e(__('sidebar.stock_adjs')); ?></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="return-tab" data-bs-toggle="tab" href="#return" role="tab" aria-controls="return" aria-selected="false"><?php echo e(__('sidebar.return')); ?></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="returnsell-tab" data-bs-toggle="tab" href="#returnsell" role="tab" aria-controls="returnsell" aria-selected="false"><?php echo e(__('sell.return_sell')); ?></a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('general.date')); ?></th>
                                                <th><?php echo e(__('general.ref_no')); ?></th>
                                                <th><?php echo e(__('customer.name')); ?></th>
                                                <th><?php echo e(__('purchase.net_total')); ?></th>
                                                <th><?php echo e(__('general.payment_total')); ?></th>
                                                <th><?php echo e(__('sell.due_total')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $data['act_sell']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $as): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e(my_date($as->created_at)); ?></td>
                                                <td><?php echo e($as->ref_no); ?></td>
                                                <td><?php echo e($as->customer->name ?? ''); ?></td>
                                                <td><?php echo e(number_format($as->final_total)); ?></td>
                                                <td><?php echo e($as->pay_total); ?></td>
                                                <td><?php echo e(number_format($as->due_total ?? $as->final_total)); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__("general.date")); ?></th>
                                                <th><?php echo e(__('general.ref_no')); ?></th>
                                                <th><?php echo e(__('supplier.name')); ?></th>
                                                <th><?php echo e(__('purchase.net_total')); ?></th>
                                                <th><?php echo e(__('general.payment_total')); ?></th>
                                                <th><?php echo e(__('general.po_due')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $data['act_purchase']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(my_date($ap->created_at)); ?></td>
                                                <td><?php echo e($ap->ref_no); ?></td>
                                                <td><?php echo e($ap->supplier->name ?? ''); ?></td>
                                                <td><?php echo e(number_format($ap->final_total)); ?></td>
                                                <td><?php echo e($ap->pay_total); ?></td>
                                                <td><?php echo e(number_format($ap->due_total ?? $ap->final_total)); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('general.date')); ?></th>
                                                <th><?php echo e(__('general.ref_no')); ?></th>
                                                <th><?php echo e(__('transfer.from')); ?></th>
                                                <th><?php echo e(__('transfer.to')); ?></th>
                                                <th><?php echo e(__('purchase.shipping_cost')); ?></th>
                                                <th><?php echo e(__('purchase.net_total')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $data['act_stransfer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(my_date($at->created_at)); ?></td>
                                                <td><?php echo e($at->ref_no); ?></td>
                                                <td> <?php echo e($at->transfer->fromstore->name ?? ''); ?> </td>
                                                <td> <?php echo e($at->transfer->tostore->name ?? ''); ?> </td>
                                                <td><?php echo e(number_format($at->shipping_charges)); ?></td>
                                                <td><?php echo e(number_format($at->final_total)); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="adjustment" role="tabpanel" aria-labelledby="adjustment-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('general.date')); ?></th>
                                                <th><?php echo e(__('general.ref_no')); ?></th>
                                                <th><?php echo e(__('purchase.net_total')); ?></th>
                                                <th><?php echo e(__('adjustment.amount_recovered')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $data['act_sadjustment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(my_date($aa->created_at)); ?></td>
                                                <td><?php echo e($aa->ref_no); ?></td>
                                                <td><?php echo e(number_format($aa->final_total)); ?></td>
                                                <td> <?php echo e(number_format($aa->total_amount_recovered)); ?> </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('general.date')); ?></th>
                                                <th><?php echo e(__("general.ref_no")); ?></th>
                                                <th><?php echo e(__("purchase.parent_transaction")); ?></th>
                                                <th><?php echo e(__('supplier.name')); ?></th>
                                                <th><?php echo e(__('sell.total_return')); ?></th>
                                                <th><?php echo e(__('general.total')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $data['act_return']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e(my_date($ar->created_at)); ?></td>
                                                <td> <?php echo e($ar->ref_no); ?> </td>
                                                <td> <?php echo e($ar->transaction->ref_no ?? ''); ?> </td>
                                                <td> <?php echo e($ar->supplier->name ?? ''); ?> </td>
                                                <td> <?php echo e($ar->qty_return); ?> Qty Return </td>
                                                <td> <?php echo e(number_format($ar->final_total)); ?> </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="returnsell" role="tabpanel" aria-labelledby="returnsell-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('general.date')); ?></th>
                                                <th><?php echo e(__("general.ref_no")); ?></th>
                                                <th><?php echo e(__("purchase.parent_transaction")); ?></th>
                                                <th><?php echo e(__('customer.name')); ?></th>
                                                <th><?php echo e(__('sell.total_return')); ?></th>
                                                <th><?php echo e(__('general.total')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $data['act_returnsell']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e(my_date($rs->created_at)); ?></td>
                                                <td> <?php echo e($rs->ref_no); ?> </td>
                                                <td> <?php echo e($rs->transaction->ref_no ?? ''); ?> </td>
                                                <td> <?php echo e($rs->customer->name ?? ''); ?> </td>
                                                <td> <?php echo e(count($rs->sellreturn)); ?> Qty Return </td>
                                                <td> <?php echo e(number_format($rs->final_total)); ?> </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>





    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/amcharts4/core.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/amcharts4/charts.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/amcharts4/animated.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/amcharts4/worldLow.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/amcharts4/maps.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/apexcharts/apexcharts.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/vendors/amcharts4/incomeexpense.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/amcharts4/transactiondata.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/apexcharts/sell_month.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\tymart\resources\views/admin/index.blade.php ENDPATH**/ ?>