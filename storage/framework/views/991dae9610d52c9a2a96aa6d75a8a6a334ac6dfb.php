<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/choices.js/choices.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/maps/leaflet.css')); ?>" />
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
        <div id="errors"></div>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" class="row" id="uStore">
                                <?php echo csrf_field(); ?>
                                <div class="col-md-4 mb-4">
                                    <h6><?php echo e(__('store.choose_country')); ?></h6>
                                    <div class="form-group">
                                        <select class="choices form-select" name="country_id" id="country" required>
                                            <option value=""><?php echo e(__('store.choose_country')); ?></option>
                                            <?php $__currentLoopData = $data['country']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($d->id); ?>" <?php if($d->id == old('country_id',$store->country_id)): ?> selected <?php endif; ?>><?php echo e($d->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-4">
                                    <h6><?php echo e(__('store.choose_currency')); ?></h6>
                                    <div class="form-group">
                                        <select class="choices form-select" name="currency_id" id="currency" required>
                                            <option value=""><?php echo e(__('store.choose_currency')); ?></option>
                                            <?php $__currentLoopData = $data['currency']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>" <?php if($c->id == old('currency_id',$store->currency_id)): ?> selected <?php endif; ?>><?php echo e($c->country); ?> - <?php echo e($c->code); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h6><?php echo e(__('store.choose_printer')); ?> </h6>
                                    <div class="form-group">
                                        <select class="choices form-select" name="printer_id" id="printer" required>
                                            <option value=""><?php echo e(__('store.choose_printer')); ?></option>
                                            <?php $__currentLoopData = $data['printer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->id); ?>" <?php if($p->id == old('printer_id',$store->printer_id)): ?> selected <?php endif; ?>><?php echo e($p->name); ?> - <?php echo e($p->type); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('store.store_name')); ?></h6>
                                    <div class="form-group">
                                        <input type="text" name="name" value="<?php echo e(old('name',$store->name)); ?>" id="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('general.code')); ?></h6>
                                    <div class="form-group">
                                        <input type="text" name="code" value="<?php echo e(old('code',$store->code)); ?>" id="code" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('general.email')); ?></h6>
                                    <div class="form-group">
                                        <input type="email" name="email" value="<?php echo e(old('email',$store->email)); ?>" id="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('general.email')); ?></h6>
                                    <div class="form-group">
                                        <input type="number" name="phone" value="<?php echo e(old('phone',$store->phone)); ?>" id="phone" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('store.zip_code')); ?></h6>
                                    <div class="form-group">
                                        <input type="text" name="zip_code" value="<?php echo e(old('zip_code',$store->zip_code)); ?>" id="zip_code" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('purchase.tax')); ?></h6>
                                    <div class="form-group">
                                        <input type="number" name="tax" value="<?php echo e(old('tax',$store->tax)); ?>" id="tax" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('store.after_sell')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-control" name="after_sell" id="after_sell">
                                            <?php if($store->after_sell == 1 || $store->after_sell == null): ?>
                                            <option value="1">POS</option>
                                            <option value="2"><?php echo e(__('open_receipt_popup')); ?></option>
                                            <option value="3"><?php echo e(__('open_receipt_window')); ?></option>
                                            <?php elseif($store->after_sell == 2): ?>
                                            <option value="2"><?php echo e(__('open_receipt_popup')); ?></option>
                                            <option value="1">POS</option>
                                            <option value="3"><?php echo e(__('open_receipt_window')); ?></option>
                                            <?php elseif($store->after_sell == 3): ?>
                                            <option value="3"><?php echo e(__('open_receipt_window')); ?></option>
                                            <option value="1">POS</option>
                                            <option value="2"><?php echo e(__('open_receipt_popup')); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6>Zakat</h6>
                                    <div class="form-group">
                                        <input type="number" name="zakat" value="<?php echo e(old('zakat',$store->zakat)); ?>" id="zakat" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('store.currency_position')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-control" name="currency_position" id="currency_position" required>
                                            <?php if($store->currency_position == 1 || $store->currency_position == null): ?>
                                            <option value="1"><?php echo e(__('store.before_amount')); ?></option>
                                            <option value="2"><?php echo e(__('store.after_amount')); ?></option>
                                            <?php elseif($store->currency_position == 2): ?>
                                            <option value="2"><?php echo e(__('store.after_amount')); ?></option>
                                            <option value="1"><?php echo e(__('store.before_amount')); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('store.sound_in_pos')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-control" name="sound" id="sound">
                                            <?php if($store->sound == 1 || $store->sound == null): ?>
                                            <option value="1"><?php echo e(__('general.yes')); ?></option>
                                            <option value="2"><?php echo e(__('general.no')); ?></option>
                                            <?php elseif($store->sound == 2): ?>
                                            <option value="2"><?php echo e(__('general.no')); ?></option>
                                            <option value="1"><?php echo e(__('general.yes')); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <h6><?php echo e(__('general.address')); ?></h6>
                                    <div class="form-group">
                                        <textarea class="form-control" name="address" id="address" required><?php echo e(old('address',$store->address)); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <h6><?php echo e(__('store.footer_text')); ?></h6>
                                    <div class="form-group">
                                        <textarea class="form-control" name="footer_text" id="footer_text"><?php echo e(old('footer_text',$store->footer_text)); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h6><?php echo e(__('store.format_reference')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-control" name="reference_format" id="reference_format">
                                            <?php $__currentLoopData = $reference_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" <?php if($key==old('reference_format',$store->reference_format)): ?> selected <?php endif; ?> ><?php echo e($value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-4">
                                    <h6>GST Reg. No</h6>
                                    <div class="form-group">
                                        <input type="text" name="gst" value="<?php echo e(old('gst',$store->gst)); ?>" id="gst" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <h6>VAT Reg. No</h6>
                                    <div class="form-group">
                                        <input type="text" name="vat" value="<?php echo e(old('vat',$store->vat)); ?>" id="vat" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-5">
                                    <div id="map" style="height: 400px"></div>
                                </div>

                                <div class="col-md-6 mb-6">
                                    <h6>LongTitude</h6>
                                    <div class="form-group">
                                        <input type="text" name="long" value="<?php echo e(old('long',$store->long)); ?>" id="long" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-6">
                                    <h6>Langtitude</h6>
                                    <div class="form-group">
                                        <input type="text" name="lang" value="<?php echo e(old('lang',$store->lang)); ?>" id="lang" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end mt-4">
                                    <button class="btn btn-info"><?php echo e(__('general.save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/choices.js/choices.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/maps/leaflet.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/maps/store_update.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/store/update.blade.php ENDPATH**/ ?>