<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\ValidationComponent::class, []); ?>
<?php $component->withName('admin.validation-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9)): ?>
<?php $component = $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9; ?>
<?php unset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9); ?>
<?php endif; ?>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="accordion" id="accordionSearching">
                        <div class="accordion-item border rounded mt-2">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#searchdata" aria-expanded="false" aria-controls="searchdata">
                                    <i class="fa fa-search" style="margin-right: 5px;"></i> <?php echo e(__('general.search')); ?>

                                </button>
                            </h2>
                            <div id="searchdata" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSearching">
                                <div class="accordion-body">
                                    <div class="row">

                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Filter Toko</label>
                                            <div class="input-group">
                                                <select class="form-control" id="store" name="store">
                                                    <option value="">Pilih Toko</option>
                                                    <?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($st->id); ?>" <?php if(isset($_GET['store'])): ?> <?php if($st->id==$_GET['store']): ?> selected <?php endif; ?>
                                                        <?php endif; ?>><?php echo e($st->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Filter Kategori</label>
                                            <div class="input-group">
                                                <select class="form-control" id="category" name="category">
                                                    <option value="">Pilih category</option>
                                                    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($st->id); ?>" <?php if(isset($_GET['category'])): ?> <?php if($st->id==$_GET['category']): ?> selected <?php endif; ?>
                                                        <?php endif; ?>><?php echo e($st->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Mulai Tanggal</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" placeholder="Mulai Tanggal" class="form-control" value="<?php echo e(old('start_date')); ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Sampai Tanggal</label>
                                            <div class="input-group">
                                                <input type="date" name="end_date" id="end_date" placeholder="Sampai Tanggal" class="form-control" value="<?php echo e(old('end_date')); ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="searchProduct()"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
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
                                <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                            </div>
                            <div class="col-6">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Download Laporan Pengeluaran")): ?>
                                <a href="#" class="btn btn-sm btn-success float-end" style="margin-top: -5px; border: 2px solid white"><i class="fas fa-download"></i>
                                    Download Excel</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="expenseContent">
                            
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ref No</th>
                                            <th>Kategori</th>
                                            <th>Nama Pengeluaran</th>
                                            <th>Store</th>
                                            <th>Tanggal</th>
                                            <th>Refund</th>
                                            <th>Jumlah Pengeluaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td> <?php echo e($d->ref_no); ?> </td>
                                            <td> <?php echo e($d->category->name ?? ''); ?> </td>
                                            <td> <?php echo e($d->name); ?> </td>
                                            <td> <?php echo e($d->store->name ?? ''); ?> </td>
                                            <td> <?php echo e(my_date($d->created_at)); ?> </td>
                                            <td>
                                                <?php if($d->refund == 'yes'): ?>
                                                Iya
                                                <?php else: ?>
                                                Bukan
                                                <?php endif; ?>
                                            </td>
                                            <td> <?php echo e(number_format($d->amount)); ?> </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                            <th colspan="6" style="height: 100px; font-size:30px">Total</th>
                                            <th><?php echo e(number_format($jumlahTotal)); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php echo e($data->links('partials.return_pagination')); ?>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>

    </div>


    <?php $__env->startSection('scripts'); ?>
    <script>
        function movePage(url) {

            $("#expenseContent").html("s");
            spinner.show();
            setTimeout(function() {
                $("#dueContent").html("s");
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#dueContent').html(result);
                    }
                });
                spinner.hide();
            }, 130)
        }
        var category = null;
        var start = null;
        var end = null;
        var store = null;

        function searchProduct() {
            var category = $("#category").val();
            var start = $("#start_date").val();
            var end = $("#end_date").val();
            var store = $("#store").val();
            var url = domainpath + '/pos-admin/report/transaction/expense?category=' + category + '&start_date=' + start + '&end_date=' + end + '&store=' + store;
            spinner.show();
            setTimeout(function() {
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#expenseContent').html(result);

                    }
                });
                spinner.hide();
            }, 130);
        }
    </script>
    <?php $__env->stopSection(); ?>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/reports/transaction/expense.blade.php ENDPATH**/ ?>