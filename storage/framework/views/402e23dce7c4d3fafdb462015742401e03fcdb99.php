<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <!-- MDHPOS LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo e(route('index')); ?>" class="logo logo-light mb-2">
                    <span class="logo-sm">
                        <img src="<?php echo e(asset('assets/images/icon.png')); ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo e(asset($settings->logo)); ?>" class="mt-4" alt="" style="width: 65%;">
                    </span>
                </a>
            </div>
            <!-- END MDHPOS LOGO -->

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>


        </div>

        <div class="d-flex">
            <!-- Attendance -->
            <?php if(Auth()->user()->can('Check Int Check Out') == true): ?>
            <div class="dropdown d-none d-lg-inline-block button-header">
                <?php if($attendance == null): ?>
                <a href="javascript:void(0)" id="checkint_attendance" class="btn  btn-block btn-primary mt-3"><i class="fas fa-arrow-alt-circle-up"></i> <?php echo e(__('attendance.check_int')); ?></a>
                <a href="javascript:void(0)" id="checkout_attendance" class="btn btn-block btn-danger mt-3 d-none"><i class="fas fa-arrow-alt-circle-up"></i> <?php echo e(__('attendance.check_out')); ?></a>
                <a href="javascript:void(0)" class="btn btn-block btn-success mt-3 d-none" id="attendance_clear"><i class="fas fa-check-circle"></i> <?php echo e(__('attendance.end')); ?> </a>
                <?php elseif($attendance->check_out == null): ?>
                <a href="javascript:void(0)" id="checkout_attendance" class="btn btn-block btn-danger mt-3"><i class="fas fa-arrow-alt-circle-up"></i> <?php echo e(__('attendance.check_out')); ?></a>
                <a href="javascript:void(0)" class="btn btn-block btn-success mt-3 d-none" id="attendance_clear"><i class="fas fa-check-circle"></i> <?php echo e(__('attendance.end')); ?></a>
                <?php else: ?>
                <a href="javascript:void(0)" class="btn btn-block btn-success mt-3" id="attendance_clear"><i class="fas fa-check-circle"></i> <?php echo e(__('attendance.end')); ?></a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <!-- End Attendance -->



            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Peringatan Stock")): ?>
            <div class="dropdown d-none button-header d-lg-inline-block">
                <a href="<?php echo e(route('stock.alert')); ?>" id="checkint_attendance" class="btn  btn-block btn-primary mt-3">
                    <i class="mdi mdi-bell-outline"></i> Qty Alert
                </a>
            </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("POS")): ?>
            <div class="dropdown d-none button-header d-lg-inline-block">
                <a href="<?php echo e(route('pos.index')); ?>" id="checkint_attendance" class="btn  btn-block btn-primary mt-3">
                    <i class="mdi mdi-desktop-classic"></i> POS
                </a>
            </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Profit Loss Report")): ?>
            <div class="dropdown d-none button-header d-lg-inline-block">
                <a href="<?php echo e(route('profit.loss')); ?>" id="checkint_attendance" class="btn  btn-block btn-primary mt-3">
                    <i class="mdi mdi-book-open-outline"></i> Profit Loss
                </a>
            </div>
            <?php endif; ?>

            <!-- Language Option -->
            <div class="dropdown d-none d-md-block">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="me-2" src="<?php echo e(asset('assets/icon/lang/'.app()->getLocale().'.png')); ?>" alt="Language" height="16"> <?php echo e(app()->getLocale()); ?> <span class="mdi mdi-chevron-down"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <?php $__currentLoopData = $lang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(url('locale',$key)); ?>" class="dropdown-item notify-item">
                        <img src="<?php echo e(asset('assets/icon/lang/'.$key.'.png')); ?>" alt="user-image" class="me-1" height="12"> <span class="align-middle"> <?php echo e(__($value)); ?> </span>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <!-- End Language Option -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?php echo e(asset(Auth()->user()->photo)); ?>" alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="<?php echo e(route('profile')); ?>"><i class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>



        </div>
    </div>
</header><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/components/admin/header-component.blade.php ENDPATH**/ ?>