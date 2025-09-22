<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled mt-4" id="side-menu">

                
                <li <?php echo e(request()->is('pos-admin/home') ? 'class=mm-active' : ''); ?>>
                    <a href="<?php echo e(route('index')); ?>" class="waves-effect <?php echo e(request()->is('pos-admin/home') ? 'class=mm-active' : ''); ?>">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                

                <li class="menu-title"><?php echo e(__('sidebar.product_transaction')); ?></li>

                
                <?php if(Auth()->user()->can('Daftar Kategori') == true || Auth()->user()->can('Tambah Kategori') == true || Auth()->user()->can('Daftar Subkategori') == true ): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/category*') ? 'mm-active' : ''); ?>  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-align-justify"></i>
                        <span><?php echo e(__('sidebar.category')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/category*') ? 'mm-active' : ''); ?> ">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Tambah Kategori')): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/category/category-create*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('category.create')); ?>"> <?php echo e(__('sidebar.add_category')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Daftar Kategori')): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/category/category') || request()->is('pos-admin/category/category-update/*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('category.index')); ?>"><?php echo e(__('sidebar.category')); ?></a>
                        </li> 
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Daftar Subkategori')): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/category/subcategory') || request()->is('pos-admin/category/subcategory-create') || request()->is('pos-admin/category/subcategory-update*') ||  request()->is('pos-admin/category/by-category*')   ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('subcategory.index')); ?>"><?php echo e(__('sidebar.subcategory')); ?></a>
                        </li>
                        <?php endif; ?>
                        <li class="submenu-item">
                            <a href="<?php echo e(route('category.import')); ?>">Import Kategori</a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Supplier') == true || Auth()->user()->can('Tambah Supplier') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/supplier*') ? 'mm-active' : ''); ?>  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-user-tag"></i>
                        <span><?php echo e(__('sidebar.supplier')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/supplier*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Supplier")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/supplier/supplier') || request()->is('pos-admin/supplier/supplier-update*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('supplier.index')); ?>"><?php echo e(__('sidebar.supplier')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Supplier")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/supplier/supplier-create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('supplier.create')); ?>"><?php echo e(__('sidebar.add_supplier')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Supplier') == true || Auth()->user()->can('Tambah Supplier') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/customer*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-user-tie"></i>
                        <span><?php echo e(__('sidebar.customer')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/customer*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Customer")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/customer/customer') || request()->is('pos-admin/customer/customer-update*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('customer.index')); ?>"><?php echo e(__('sidebar.customer')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Customer")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/customer/customer-create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('customer.create')); ?>"><?php echo e(__('sidebar.add_customer')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Variasi Produk') == true || Auth()->user()->can('Daftar Produk') == true || Auth()->user()->can('Tambah Produk') == true || Auth()->user()->can('Produk Label') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/product*') ? 'mm-active' : ''); ?>  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-cubes"></i>
                        <span><?php echo e(__('sidebar.product')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/product*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Variasi Produk")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/product/variant*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('variant.index')); ?>"><?php echo e(__('sidebar.v_product')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Produk")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/product/create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('product.create')); ?>"><?php echo e(__('sidebar.add_product')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Produk")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/product') || request()->is('pos-admin/product/update*') || request()->is('pos-admin/product/opening-stock*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('product.index')); ?>"> <?php echo e(__('sidebar.product')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Produk Label")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/product/print-barcode*') || request()->is('pos-admin/product/purchase-label*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('product.barcode')); ?>"><?php echo e(__('sidebar.print_barcode')); ?></a>
                        </li>
                        <?php endif; ?>
                        <li class="submenu-item">
                            <a href="<?php echo e(route('product.import')); ?>">Import Product</a>
                        </li> 
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Purchase') == true || Auth()->user()->can('Tambah Purchase') == true || Auth()->user()->can('Daftar Return') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/purchase*') || request()->is('pos-admin/return/index*') || 
                request()->is('pos-admin/return/detail*') || request()->is('pos-admin/return/by-purchase*')  ? 'mm-active' : ''); ?>  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-truck"></i>
                        <span><?php echo e(__('sidebar.purchase')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/purchase*') || request()->is('pos-admin/return/index*') ||  request()->is('pos-admin/return/detail*') || request()->is('pos-admin/return/by-purchase*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Purchase")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/purchase/index') || request()->is('pos-admin/purchase/detail*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('purchase.index')); ?>"><?php echo e(__('sidebar.purchase')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Purchase")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/purchase/create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('purchase.create')); ?>"><?php echo e(__('sidebar.add_purchase')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Return")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/return/index*') || request()->is('pos-admin/return/detail*') || request()->is('pos-admin/return/by-purchase*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('return.index')); ?>"><?php echo e(__('sidebar.return')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Adjustment') == true || Auth()->user()->can('Tambah Adjustment') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/stock-adjustment*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="far fa-check-circle"></i>
                        <span><?php echo e(__('sidebar.stock_adjs')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/stock-adjustment*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Adjustment")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/stock-adjustment/index') || request()->is('pos-admin/stock-adjustment/detail*')  ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('adjustment.index')); ?>"><?php echo e(__('sidebar.list_adjs')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Adjustment")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/stock-adjustment/create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('adjustment.create')); ?>"><?php echo e(__('sidebar.create_adjs')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Stock Transfer') == true || Auth()->user()->can('Tambah Stock Transfer') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/stock-transfer*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="far fa-share-square"></i>
                        <span><?php echo e(__('sidebar.stock_transfer')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/stock-transfer*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Stock Transfer")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/stock-transfer/index') || request()->is('pos-admin/stock-transfer/detail*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('transfer.index')); ?>"><?php echo e(__('sidebar.stock_transfer')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Stock Transfer")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/stock-transfer/create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('transfer.create')); ?>"><?php echo e(__('sidebar.add_stock_transfer')); ?> </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Kategori Pengeluaran') == true || Auth()->user()->can('Daftar Pengeluaran') == true || Auth()->user()->can('Daftar Subkategori Pengeluaran') == true || Auth()->user()->can('Tambah Pengeluaran') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/expense-category*') || request()->is('pos-admin/expense*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-money-bill"></i>
                        <span><?php echo e(__('sidebar.expense')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/expense-category*') || request()->is('pos-admin/expense*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Kategori Pengeluaran")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/expense-category/category') || request()->is('pos-admin/expense-category/category-update*') || request()->is('pos-admin/expense-category/category-create')  ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('exca.index')); ?>"><?php echo e(__('sidebar.expense_category')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Subkategori Pengeluaran")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/expense-category/subcategory') || request()->is('pos-admin/expense-category/subcategory-create') || request()->is('pos-admin/expense-category/subcategory-update*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('exsub.index')); ?>"><?php echo e(__('sidebar.expense_subcategory')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Pengeluaran")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/expense/index') || request()->is('pos-admin/expense/update*') || request()->is('pos-admin/expense/detail*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('expense.index')); ?>"><?php echo e(__('sidebar.expense')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pengeluaran")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/expense/create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('expense.create')); ?>"><?php echo e(__('sidebar.add_expense')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                <li class="menu-title"><?php echo e(__('sidebar.human_resource')); ?></li>

                
                <?php if(Auth()->user()->can('Daftar Department') == true || Auth()->user()->can('Daftar Designation') == true || Auth()->user()->can('Daftar Tunjangan') == true || Auth()->user()->can('Daftar Potongan') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/hrm*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-id-card-alt"></i>
                        <span><?php echo e(__('sidebar.hrm_master')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/hrm*') ? 'mm-active' : ''); ?> ">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Department")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/hrm/department') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('department.index')); ?>"><?php echo e(__('sidebar.department')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Designation")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/hrm/designation*') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('designation.index')); ?>"><?php echo e(__('sidebar.designation')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Tunjangan")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/hrm/allowance*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('allowance.index')); ?>"><?php echo e(__('sidebar.e_allowance')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Potongan")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/hrm/cutting-salary*') || request()->is('pos-admin/hrm/cutting-update*') || request()->is('pos-admin/hrm/cutting-create')  ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('cutting.index')); ?>"><?php echo e(__('sidebar.deduction')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Daftar Stock Transfer') == true || Auth()->user()->can('Tambah Stock Transfer') == true): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/employee/employee*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-users"></i>
                        <span><?php echo e(__('sidebar.employee')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/employee/employee*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Pegawai")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/employee/employee') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('employee.index')); ?>"><?php echo e(__('sidebar.employee')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pegawai")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/employee/employee-create') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('employee.create')); ?>"><?php echo e(__('sidebar.add_employee')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Absensi Hari ini")): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/attendance*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-calendar-check"></i>
                        <span><?php echo e(__('sidebar.attendance')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/attendance*') ? 'mm-active' : ''); ?>">
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/attendance/today*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('attendance.today')); ?>"><?php echo e(__('sidebar.today_attendance')); ?></a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Generate Slip') == true || Auth()->user()->can('Daftar Slip Gaji') == true): ?>
                <li class="sidebar-item has-sub <?php echo e(request()->is('pos-admin/salary*') ? 'mm-active' : ''); ?>">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-money-bill-alt"></i>
                        <span><?php echo e(__('sidebar.salary')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/salary*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Generate Slip")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/salary/index*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('generate.salary')); ?>"><?php echo e(__('sidebar.generate_slip')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Slip Gaji")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/salary/list*') || request()->is('pos-admin/salary/detail*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('salary.list')); ?>"><?php echo e(__('sidebar.salary_list')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                <li class="menu-title"><?php echo e(__('sidebar.reports')); ?></li>

                
                <?php if(Auth()->user()->can('Daftar Penjualan') || Auth()->user()->can('Laporan Purchase') || Auth()->user()->can('Laporan Return')
                || Auth()->user()->can('Laporan Hutang') || Auth()->user()->can('Daftar Laporan Pengeluaran') || Auth()->user()->can('Profit Loss Report') ): ?>
                <li class="sidebar-item has-sub  <?php echo e(request()->is('pos-admin/report/transaction/sell*') || request()->is('pos-admin/sell*')  || request()->is('pos-admin/report/transaction/purchase*')
                 || request()->is('pos-admin/report/transaction/return*') || request()->is('pos-admin/report/transaction/due*') || request()->is('pos-admin/report/transaction/expense*') || request()->is('pos-admin/report/transaction/profit-loss*') ? 'mm-active' : ''); ?>">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-chart-area"></i>
                        <span><?php echo e(__('sidebar.transaction_reports')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/report/transaction/sell*') || request()->is('pos-admin/sell*') || request()->is('pos-admin/report/transaction/purchase*')
                    || request()->is('pos-admin/report/transaction/return*') || request()->is('pos-admin/report/transaction/due*') || request()->is('pos-admin/report/transaction/expense*') 
                    || request()->is('pos-admin/report/transaction/profit-loss*') || request()->is('pos-admin/return-sell*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Penjualan")): ?>
                        <li class="submenu-item  <?php echo e(request()->is('pos-admin/report/transaction/sell*') || request()->is('pos-admin/sell*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('sell.report')); ?>"><?php echo e(__('sidebar.sell_report')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Return Penjualan")): ?>
                        <li class="submenu-item  <?php echo e(request()->is('pos-admin/return-sell*')  ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('returnsell.index')); ?>"><?php echo e(__('sell.return_sell')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Laporan Purchase")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/transaction/purchase*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('purchase.report')); ?>"><?php echo e(__('sidebar.purchase_report')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Laporan Return")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/transaction/return*') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('return.report')); ?>"><?php echo e(__('sidebar.return_report')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Laporan Hutang')): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/transaction/due*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('due.report')); ?>"><?php echo e(__('sidebar.debt_book')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Laporan Pengeluaran")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/transaction/expense*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('expense.report')); ?>"><?php echo e(__('sidebar.expense_report')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Profit Loss Report")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/transaction/profit-loss*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('profit.loss')); ?>"><?php echo e(__('sidebar.profit_loss')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Top Product') || Auth()->user()->can('Peringatan Stock') || Auth()->user()->can('Laporan Stock Adjustment') || Auth()->user()->can('Laporan Stock Transfer') ): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/report/stock-product/top-product*') || request()->is('pos-admin/report/stock-product/stock-alert*') 
                || request()->is('pos-admin/report/stock-product/transfer*') || request()->is('pos-admin/report/stock-product/adjustment*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-chart-bar"></i>
                        <span><?php echo e(__('sidebar.stock_n_product')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/report/stock-product/top-product*') || request()->is('pos-admin/report/stock-product/stock-alert*')
                     || request()->is('pos-admin/report/stock-product/transfer*') || request()->is('pos-admin/report/stock-product/adjustment*')
                     || request()->is('pos-admin/report/stock-product/all-stock*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Top Product")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/stock-product/top-product*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('top.product')); ?>"><?php echo e(__('sidebar.top_product')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Peringatan Stock")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/stock-product/stock-alert*')  ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('stock.alert')); ?>"><?php echo e(__('sidebar.stock_alert')); ?></a>
                        </li>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/stock-product/all-stock*')  ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('all.stock')); ?>"><?php echo e(__('sidebar.all_stock')); ?></a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Laporan Stock Adjustment")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/stock-product/adjustment*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('stock.adjustment')); ?>"><?php echo e(__('sidebar.stock_adjs')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Laporan Stock Transfer")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/stock-product/transfer*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('stock.transfer')); ?>"><?php echo e(__('sidebar.r_stock_transfer')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Absensi Harian') || Auth()->user()->can('Absensi Bulanan') || Auth()->user()->can('Total Absensi') ): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/report/attendance*') ? 'mm-active' : ''); ?> has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-chart-line"></i>
                        <span><?php echo e(__('sidebar.attendance')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/report/attendance*') ? 'mm-active' : ''); ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Absensi Harian")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/attendance/today*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('attendance.today_report')); ?>"><?php echo e(__('sidebar.r_today_attendance')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Absensi Bulanan")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/attendance/month*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('attendance.month_report')); ?>"><?php echo e(__('sidebar.month_attendance')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Total Absensi")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/report/attendance/total*') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('attendance.total')); ?>"><?php echo e(__('sidebar.attendance_total')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                


                <li class="menu-title"><?php echo e(__('sidebar.system_setting')); ?></li>

                
                <?php if(Auth()->user()->can('Daftar Permission') || Auth()->user()->can('Daftar Role') || Auth()->user()->can('Daftar Users') ): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/user-manager*') ? 'mm-active' : ''); ?>  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-user-shield"></i>
                        <span><?php echo e(__('sidebar.user_manager')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/user-manager*') ? 'mm-active' : ''); ?> ">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Permission")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/user-manager/permission*') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('permission.index')); ?>"><?php echo e(__('sidebar.permission')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Role")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/user-manager/role*') || request()->is('pos-admin/system/user-manager/role-create*') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('role.index')); ?>"><?php echo e(__('sidebar.role')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Users")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/user-manager/user*') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('user.index')); ?>"><?php echo e(__('sidebar.user')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Setting') || Auth()->user()->can('HRM Setting') || Auth()->user()->can('Daftar Negara')
                || Auth()->user()->can('Daftar Mata Uang') || Auth()->user()->can('Daftar Bank') || Auth()->user()->can('Daftar Printer')
                || Auth()->user()->can('Daftar Pajak') || Auth()->user()->can('Daftar Box') || Auth()->user()->can('Daftar Unit') || Auth()->user()->can('Daftar Brand') ): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/system*') ? 'mm-active' : ''); ?>  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-cogs"></i>
                        <span> <?php echo e(__('sidebar.system_setting')); ?> </span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/system*') ? 'mm-active' : ''); ?> ">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Setting")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/settings') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('sett.index')); ?>"><?php echo e(__('sidebar.general')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("HRM Setting")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/hrm-setting') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('hrm.setting')); ?>"><?php echo e(__('sidebar.hrm')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Negara")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/countries') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('country.index')); ?>"><?php echo e(__('sidebar.country')); ?></a>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Mata Uang")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/currency') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('currency.index')); ?>"><?php echo e(__('sidebar.currency')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Bank")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/bank') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('bank.index')); ?>"><?php echo e(__('sidebar.bank')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Printer")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/printer*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('printer.index')); ?>"><?php echo e(__('sidebar.printer')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Pajak")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/taxrate*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('taxrate.index')); ?>"><?php echo e(__('sidebar.tax_persentation')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Box")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/box*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('box.index')); ?>"><?php echo e(__('sidebar.box')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Unit")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/unit*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('unit.index')); ?>"><?php echo e(__('sidebar.unit')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Brand")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/system/brand*') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('brand.index')); ?>"><?php echo e(__('sidebar.brand')); ?></a>
                        </li>
                        <?php endif; ?>

                        <li class="submenu-item">
                            <a href="<?php echo e(route('setting.import')); ?>">Import Master Data</a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if(Auth()->user()->can('Tambah Toko') || Auth()->user()->can('Update Toko') || Auth()->user()->can('Pilih Toko') ): ?>
                <li class="sidebar-item <?php echo e(request()->is('pos-admin/store*') ? 'mm-active' : ''); ?>  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-store"></i>
                        <span><?php echo e(__('sidebar.store')); ?></span>
                    </a>
                    <ul class="sub-menu <?php echo e(request()->is('pos-admin/store*') ? 'mm-active' : ''); ?> ">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Toko")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/store/create') ? 'mm-active' : ''); ?> ">
                            <a href="<?php echo e(route('store.create')); ?>"><?php echo e(__('sidebar.add_store')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Toko")): ?>
                        <li class="submenu-item <?php echo e(request()->is('pos-admin/store/update') ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('store.update')); ?>"><?php echo e(__('sidebar.update_store')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Pilih Toko")): ?>
                        <li class="submenu-item">
                            <a href="<?php echo e(route('store.choose')); ?>"><?php echo e(__('sidebar.choose_store')); ?> </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div><?php /**PATH /var/www/tymart/resources/views/components/admin/sidebar-component.blade.php ENDPATH**/ ?>