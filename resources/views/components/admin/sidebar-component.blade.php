<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled mt-4" id="side-menu">

                {{-- DASHBOARD MENU --}}
                <li {{ request()->is('pos-admin/home') ? 'class=mm-active' : '' }}>
                    <a href="{{ route('index') }}" class="waves-effect {{ request()->is('pos-admin/home') ? 'class=mm-active' : '' }}">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- END DASHBOARD MENU --}}

                <li class="menu-title">{{ __('sidebar.product_transaction') }}</li>

                {{-- CATEGORY MENU --}}
                @if(Auth()->user()->can('Daftar Kategori') == true || Auth()->user()->can('Tambah Kategori') == true || Auth()->user()->can('Daftar Subkategori') == true )
                <li class="sidebar-item {{ request()->is('pos-admin/category*') ? 'mm-active' : '' }}  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-align-justify"></i>
                        <span>{{ __('sidebar.category') }}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/category*') ? 'mm-active' : '' }} ">
                        @can('Tambah Kategori')
                        <li class="submenu-item {{ request()->is('pos-admin/category/category-create*') ? 'mm-active' : '' }}">
                            <a href="{{ route('category.create') }}"> {{ __('sidebar.add_category') }}</a>
                        </li>
                        @endcan
                        @can('Daftar Kategori')
                        <li class="submenu-item {{ request()->is('pos-admin/category/category') || request()->is('pos-admin/category/category-update/*') ? 'mm-active' : '' }}">
                            <a href="{{ route('category.index') }}">{{ __('sidebar.category') }}</a>
                        </li> 
                        @endcan
                        @can('Daftar Subkategori')
                        <li class="submenu-item {{ request()->is('pos-admin/category/subcategory') || request()->is('pos-admin/category/subcategory-create') || request()->is('pos-admin/category/subcategory-update*') ||  request()->is('pos-admin/category/by-category*')   ? 'mm-active' : '' }}">
                            <a href="{{ route('subcategory.index') }}">{{ __('sidebar.subcategory') }}</a>
                        </li>
                        @endcan
                        <li class="submenu-item">
                            <a href="{{ route('category.import') }}">Import Kategori</a>
                        </li>
                    </ul>
                </li>
                @endif
                {{-- END CATEGORY MENU --}}

                {{-- SUPPLIER MENU --}}
                @if(Auth()->user()->can('Daftar Supplier') == true || Auth()->user()->can('Tambah Supplier') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/supplier*') ? 'mm-active' : '' }}  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-user-tag"></i>
                        <span>{{ __('sidebar.supplier') }}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/supplier*') ? 'mm-active' : '' }}">
                        @can("Daftar Supplier")
                        <li class="submenu-item {{ request()->is('pos-admin/supplier/supplier') || request()->is('pos-admin/supplier/supplier-update*') ? 'mm-active' : '' }}">
                            <a href="{{ route('supplier.index') }}">{{ __('sidebar.supplier') }}</a>
                        </li>
                        @endcan
                        @can("Tambah Supplier")
                        <li class="submenu-item {{ request()->is('pos-admin/supplier/supplier-create') ? 'mm-active' : '' }}">
                            <a href="{{ route('supplier.create') }}">{{ __('sidebar.add_supplier') }}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END SUPPLIER MENU --}}

                {{-- CUSTOMER MENU --}}
                @if(Auth()->user()->can('Daftar Supplier') == true || Auth()->user()->can('Tambah Supplier') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/customer*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-user-tie"></i>
                        <span>{{__('sidebar.customer')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/customer*') ? 'mm-active' : '' }}">
                        @can("Daftar Customer")
                        <li class="submenu-item {{ request()->is('pos-admin/customer/customer') || request()->is('pos-admin/customer/customer-update*') ? 'mm-active' : '' }}">
                            <a href="{{ route('customer.index') }}">{{ __('sidebar.customer') }}</a>
                        </li>
                        @endcan
                        @can("Tambah Customer")
                        <li class="submenu-item {{ request()->is('pos-admin/customer/customer-create') ? 'mm-active' : '' }}">
                            <a href="{{ route('customer.create') }}">{{ __('sidebar.add_customer') }}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END CUSTOMER MENU --}}

                {{-- PRODUCT MENU --}}
                @if(Auth()->user()->can('Daftar Variasi Produk') == true || Auth()->user()->can('Daftar Produk') == true || Auth()->user()->can('Tambah Produk') == true || Auth()->user()->can('Produk Label') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/product*') ? 'mm-active' : '' }}  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-cubes"></i>
                        <span>{{ __('sidebar.product') }}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/product*') ? 'mm-active' : '' }}">
                        @can("Daftar Variasi Produk")
                        <li class="submenu-item {{ request()->is('pos-admin/product/variant*') ? 'mm-active' : '' }}">
                            <a href="{{ route('variant.index') }}">{{ __('sidebar.v_product') }}</a>
                        </li>
                        @endcan
                        @can("Tambah Produk")
                        <li class="submenu-item {{ request()->is('pos-admin/product/create') ? 'mm-active' : '' }}">
                            <a href="{{ route('product.create') }}">{{ __('sidebar.add_product') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Produk")
                        <li class="submenu-item {{ request()->is('pos-admin/product') || request()->is('pos-admin/product/update*') || request()->is('pos-admin/product/opening-stock*') ? 'mm-active' : '' }}">
                            <a href="{{ route('product.index') }}"> {{ __('sidebar.product') }}</a>
                        </li>
                        @endcan
                        @can("Produk Label")
                        <li class="submenu-item {{ request()->is('pos-admin/product/print-barcode*') || request()->is('pos-admin/product/purchase-label*') ? 'mm-active' : '' }}">
                            <a href="{{ route('product.barcode') }}">{{__('sidebar.print_barcode')}}</a>
                        </li>
                        @endcan
                        <li class="submenu-item">
                            <a href="{{route('product.import')}}">Import Product</a>
                        </li> 
                    </ul>
                </li>
                @endif
                {{-- END PRODUCT MENU --}}

                {{-- PURCHASE MENU --}}
                @if(Auth()->user()->can('Daftar Purchase') == true || Auth()->user()->can('Tambah Purchase') == true || Auth()->user()->can('Daftar Return') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/purchase*') || request()->is('pos-admin/return/index*') || 
                request()->is('pos-admin/return/detail*') || request()->is('pos-admin/return/by-purchase*')  ? 'mm-active' : '' }}  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-truck"></i>
                        <span>{{__('sidebar.purchase')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/purchase*') || request()->is('pos-admin/return/index*') ||  request()->is('pos-admin/return/detail*') || request()->is('pos-admin/return/by-purchase*') ? 'mm-active' : '' }}">
                        @can("Daftar Purchase")
                        <li class="submenu-item {{ request()->is('pos-admin/purchase/index') || request()->is('pos-admin/purchase/detail*') ? 'mm-active' : '' }}">
                            <a href="{{ route('purchase.index') }}">{{ __('sidebar.purchase') }}</a>
                        </li>
                        @endcan
                        @can("Tambah Purchase")
                        <li class="submenu-item {{ request()->is('pos-admin/purchase/create') ? 'mm-active' : '' }}">
                            <a href="{{ route('purchase.create') }}">{{ __('sidebar.add_purchase') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Return")
                        <li class="submenu-item {{ request()->is('pos-admin/return/index*') || request()->is('pos-admin/return/detail*') || request()->is('pos-admin/return/by-purchase*') ? 'mm-active' : '' }}">
                            <a href="{{ route('return.index') }}">{{__('sidebar.return')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END PURCHASE MENU --}}

                {{-- STOCK ADJUSTMENT MENU --}}
                @if(Auth()->user()->can('Daftar Adjustment') == true || Auth()->user()->can('Tambah Adjustment') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/stock-adjustment*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="far fa-check-circle"></i>
                        <span>{{__('sidebar.stock_adjs')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/stock-adjustment*') ? 'mm-active' : '' }}">
                        @can("Daftar Adjustment")
                        <li class="submenu-item {{ request()->is('pos-admin/stock-adjustment/index') || request()->is('pos-admin/stock-adjustment/detail*')  ? 'mm-active' : '' }}">
                            <a href="{{ route('adjustment.index') }}">{{__('sidebar.list_adjs')}}</a>
                        </li>
                        @endcan
                        @can("Tambah Adjustment")
                        <li class="submenu-item {{ request()->is('pos-admin/stock-adjustment/create') ? 'mm-active' : '' }}">
                            <a href="{{ route('adjustment.create') }}">{{__('sidebar.create_adjs')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END STOCK ADJUSTMENT MENU --}}

                {{-- STOCK TRANSFER MENU --}}
                @if(Auth()->user()->can('Daftar Stock Transfer') == true || Auth()->user()->can('Tambah Stock Transfer') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/stock-transfer*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="far fa-share-square"></i>
                        <span>{{__('sidebar.stock_transfer')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/stock-transfer*') ? 'mm-active' : '' }}">
                        @can("Daftar Stock Transfer")
                        <li class="submenu-item {{ request()->is('pos-admin/stock-transfer/index') || request()->is('pos-admin/stock-transfer/detail*') ? 'mm-active' : '' }}">
                            <a href="{{ route('transfer.index') }}">{{__('sidebar.stock_transfer')}}</a>
                        </li>
                        @endcan
                        @can("Tambah Stock Transfer")
                        <li class="submenu-item {{ request()->is('pos-admin/stock-transfer/create') ? 'mm-active' : '' }}">
                            <a href="{{ route('transfer.create') }}">{{__('sidebar.add_stock_transfer')}} </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END STOCK TRANSFER MENU --}}

                {{-- EXPENSE MENU --}}
                @if(Auth()->user()->can('Daftar Kategori Pengeluaran') == true || Auth()->user()->can('Daftar Pengeluaran') == true || Auth()->user()->can('Daftar Subkategori Pengeluaran') == true || Auth()->user()->can('Tambah Pengeluaran') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/expense-category*') || request()->is('pos-admin/expense*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-money-bill"></i>
                        <span>{{ __('sidebar.expense') }}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/expense-category*') || request()->is('pos-admin/expense*') ? 'mm-active' : '' }}">
                        @can("Daftar Kategori Pengeluaran")
                        <li class="submenu-item {{ request()->is('pos-admin/expense-category/category') || request()->is('pos-admin/expense-category/category-update*') || request()->is('pos-admin/expense-category/category-create')  ? 'mm-active' : '' }}">
                            <a href="{{ route('exca.index') }}">{{ __('sidebar.expense_category') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Subkategori Pengeluaran")
                        <li class="submenu-item {{ request()->is('pos-admin/expense-category/subcategory') || request()->is('pos-admin/expense-category/subcategory-create') || request()->is('pos-admin/expense-category/subcategory-update*') ? 'mm-active' : '' }}">
                            <a href="{{ route('exsub.index') }}">{{ __('sidebar.expense_subcategory') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Pengeluaran")
                        <li class="submenu-item {{ request()->is('pos-admin/expense/index') || request()->is('pos-admin/expense/update*') || request()->is('pos-admin/expense/detail*') ? 'mm-active' : '' }}">
                            <a href="{{ route('expense.index') }}">{{ __('sidebar.expense') }}</a>
                        </li>
                        @endcan
                        @can("Tambah Pengeluaran")
                        <li class="submenu-item {{ request()->is('pos-admin/expense/create') ? 'mm-active' : '' }}">
                            <a href="{{ route('expense.create') }}">{{ __('sidebar.add_expense') }}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END EXPENSE MENU --}}

                <li class="menu-title">{{__('sidebar.human_resource')}}</li>

                {{-- MASTER HRM MENU --}}
                @if(Auth()->user()->can('Daftar Department') == true || Auth()->user()->can('Daftar Designation') == true || Auth()->user()->can('Daftar Tunjangan') == true || Auth()->user()->can('Daftar Potongan') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/hrm*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-id-card-alt"></i>
                        <span>{{__('sidebar.hrm_master')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/hrm*') ? 'mm-active' : '' }} ">
                        @can("Daftar Department")
                        <li class="submenu-item {{ request()->is('pos-admin/hrm/department') ? 'mm-active' : '' }} ">
                            <a href="{{route('department.index')}}">{{__('sidebar.department')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Designation")
                        <li class="submenu-item {{ request()->is('pos-admin/hrm/designation*') ? 'mm-active' : '' }} ">
                            <a href="{{route('designation.index')}}">{{__('sidebar.designation')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Tunjangan")
                        <li class="submenu-item {{ request()->is('pos-admin/hrm/allowance*') ? 'mm-active' : '' }}">
                            <a href="{{route('allowance.index')}}">{{ __('sidebar.e_allowance')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Potongan")
                        <li class="submenu-item {{ request()->is('pos-admin/hrm/cutting-salary*') || request()->is('pos-admin/hrm/cutting-update*') || request()->is('pos-admin/hrm/cutting-create')  ? 'mm-active' : '' }}">
                            <a href="{{route('cutting.index')}}">{{__('sidebar.deduction')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END MASTER HRM MENU --}}

                {{-- EMPLOYEE MENU --}}
                @if(Auth()->user()->can('Daftar Stock Transfer') == true || Auth()->user()->can('Tambah Stock Transfer') == true)
                <li class="sidebar-item {{ request()->is('pos-admin/employee/employee*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-users"></i>
                        <span>{{__('sidebar.employee')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/employee/employee*') ? 'mm-active' : '' }}">
                        @can("Daftar Pegawai")
                        <li class="submenu-item {{ request()->is('pos-admin/employee/employee') ? 'mm-active' : '' }}">
                            <a href="{{ route('employee.index') }}">{{__('sidebar.employee')}}</a>
                        </li>
                        @endcan
                        @can("Tambah Pegawai")
                        <li class="submenu-item {{ request()->is('pos-admin/employee/employee-create') ? 'mm-active' : '' }}">
                            <a href="{{ route('employee.create') }}">{{__('sidebar.add_employee')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END EMPLOYEE MENU --}}

                {{-- TODAY ATTENDANCE MENU --}}
                @can("Absensi Hari ini")
                <li class="sidebar-item {{ request()->is('pos-admin/attendance*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-calendar-check"></i>
                        <span>{{ __('sidebar.attendance') }}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/attendance*') ? 'mm-active' : '' }}">
                        <li class="submenu-item {{ request()->is('pos-admin/attendance/today*') ? 'mm-active' : '' }}">
                            <a href="{{ route('attendance.today') }}">{{ __('sidebar.today_attendance') }}</a>
                        </li>
                    </ul>
                </li>
                @endcan
                {{-- END TODAY ATTENDANCE MENU --}}

                {{-- SALARY MENU --}}
                @if(Auth()->user()->can('Generate Slip') == true || Auth()->user()->can('Daftar Slip Gaji') == true)
                <li class="sidebar-item has-sub {{ request()->is('pos-admin/salary*') ? 'mm-active' : '' }}">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-money-bill-alt"></i>
                        <span>{{__('sidebar.salary')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/salary*') ? 'mm-active' : '' }}">
                        @can("Generate Slip")
                        <li class="submenu-item {{ request()->is('pos-admin/salary/index*') ? 'mm-active' : '' }}">
                            <a href="{{ route('generate.salary') }}">{{__('sidebar.generate_slip')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Slip Gaji")
                        <li class="submenu-item {{ request()->is('pos-admin/salary/list*') || request()->is('pos-admin/salary/detail*') ? 'mm-active' : '' }}">
                            <a href="{{ route('salary.list') }}">{{__('sidebar.salary_list')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END SALARY MENU --}}

                <li class="menu-title">{{__('sidebar.reports')}}</li>

                {{-- TRANSACTION REPORTS --}}
                @if(Auth()->user()->can('Daftar Penjualan') || Auth()->user()->can('Laporan Purchase') || Auth()->user()->can('Laporan Return')
                || Auth()->user()->can('Laporan Hutang') || Auth()->user()->can('Daftar Laporan Pengeluaran') || Auth()->user()->can('Profit Loss Report') )
                <li class="sidebar-item has-sub  {{ request()->is('pos-admin/report/transaction/sell*') || request()->is('pos-admin/sell*')  || request()->is('pos-admin/report/transaction/purchase*')
                 || request()->is('pos-admin/report/transaction/return*') || request()->is('pos-admin/report/transaction/due*') || request()->is('pos-admin/report/transaction/expense*') || request()->is('pos-admin/report/transaction/profit-loss*') ? 'mm-active' : '' }}">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-chart-area"></i>
                        <span>{{__('sidebar.transaction_reports')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/report/transaction/sell*') || request()->is('pos-admin/sell*') || request()->is('pos-admin/report/transaction/purchase*')
                    || request()->is('pos-admin/report/transaction/return*') || request()->is('pos-admin/report/transaction/due*') || request()->is('pos-admin/report/transaction/expense*') 
                    || request()->is('pos-admin/report/transaction/profit-loss*') || request()->is('pos-admin/return-sell*') ? 'mm-active' : '' }}">
                        @can("Daftar Penjualan")
                        <li class="submenu-item  {{ request()->is('pos-admin/report/transaction/sell*') || request()->is('pos-admin/sell*') ? 'mm-active' : '' }}">
                            <a href="{{ route('sell.report') }}">{{__('sidebar.sell_report')}}</a>
                        </li>
                        @endcan
                        @can("Return Penjualan")
                        <li class="submenu-item  {{ request()->is('pos-admin/return-sell*')  ? 'mm-active' : '' }}">
                            <a href="{{ route('returnsell.index') }}">{{__('sell.return_sell')}}</a>
                        </li>
                        @endcan
                        @can("Laporan Purchase")
                        <li class="submenu-item {{ request()->is('pos-admin/report/transaction/purchase*') ? 'mm-active' : '' }}">
                            <a href="{{ route('purchase.report') }}">{{__('sidebar.purchase_report')}}</a>
                        </li>
                        @endcan
                        @can("Laporan Return")
                        <li class="submenu-item {{ request()->is('pos-admin/report/transaction/return*') ? 'mm-active' : '' }} ">
                            <a href="{{ route('return.report') }}">{{__('sidebar.return_report')}}</a>
                        </li>
                        @endcan
                        @can('Laporan Hutang')
                        <li class="submenu-item {{ request()->is('pos-admin/report/transaction/due*') ? 'mm-active' : '' }}">
                            <a href="{{ route('due.report') }}">{{__('sidebar.debt_book')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Laporan Pengeluaran")
                        <li class="submenu-item {{ request()->is('pos-admin/report/transaction/expense*') ? 'mm-active' : '' }}">
                            <a href="{{ route('expense.report') }}">{{__('sidebar.expense_report')}}</a>
                        </li>
                        @endcan
                        @can("Profit Loss Report")
                        <li class="submenu-item {{ request()->is('pos-admin/report/transaction/profit-loss*') ? 'mm-active' : '' }}">
                            <a href="{{ route('profit.loss') }}">{{__('sidebar.profit_loss')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END TRANSACTION REPORT MENU --}}

                {{-- STOCK AND PRODUCT MENU --}}
                @if(Auth()->user()->can('Top Product') || Auth()->user()->can('Peringatan Stock') || Auth()->user()->can('Laporan Stock Adjustment') || Auth()->user()->can('Laporan Stock Transfer') )
                <li class="sidebar-item {{ request()->is('pos-admin/report/stock-product/top-product*') || request()->is('pos-admin/report/stock-product/stock-alert*') 
                || request()->is('pos-admin/report/stock-product/transfer*') || request()->is('pos-admin/report/stock-product/adjustment*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-chart-bar"></i>
                        <span>{{ __('sidebar.stock_n_product')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/report/stock-product/top-product*') || request()->is('pos-admin/report/stock-product/stock-alert*')
                     || request()->is('pos-admin/report/stock-product/transfer*') || request()->is('pos-admin/report/stock-product/adjustment*')
                     || request()->is('pos-admin/report/stock-product/all-stock*') ? 'mm-active' : '' }}">
                        @can("Top Product")
                        <li class="submenu-item {{ request()->is('pos-admin/report/stock-product/top-product*') ? 'mm-active' : '' }}">
                            <a href="{{ route('top.product') }}">{{ __('sidebar.top_product')}}</a>
                        </li>
                        @endcan
                        @can("Peringatan Stock")
                        <li class="submenu-item {{ request()->is('pos-admin/report/stock-product/stock-alert*')  ? 'mm-active' : '' }}">
                            <a href="{{ route('stock.alert') }}">{{ __('sidebar.stock_alert')}}</a>
                        </li>
                        <li class="submenu-item {{ request()->is('pos-admin/report/stock-product/all-stock*')  ? 'mm-active' : '' }}">
                            <a href="{{ route('all.stock') }}">{{ __('sidebar.all_stock')}}</a>
                        </li>
                        @endcan
                        {{-- <li class="submenu-item">
                            <a href="javascript:void(0)">Log Stok Keluar</a>
                        </li>
                        <li class="submenu-item">
                            <a href="javascript:void(0)">Log Stok Masuk</a>
                        </li>
                        <li class="submenu-item">
                            <a href="javascript:void(0)">Produk & Stok</a>
                        </li> --}}
                        @can("Laporan Stock Adjustment")
                        <li class="submenu-item {{ request()->is('pos-admin/report/stock-product/adjustment*') ? 'mm-active' : '' }}">
                            <a href="{{route('stock.adjustment')}}">{{ __('sidebar.stock_adjs')}}</a>
                        </li>
                        @endcan
                        @can("Laporan Stock Transfer")
                        <li class="submenu-item {{ request()->is('pos-admin/report/stock-product/transfer*') ? 'mm-active' : '' }}">
                            <a href="{{ route('stock.transfer') }}">{{ __('sidebar.r_stock_transfer')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END STOCK AND PRODUCT MENU --}}

                {{-- ATTENDANCE REPORT MENU --}}
                @if(Auth()->user()->can('Absensi Harian') || Auth()->user()->can('Absensi Bulanan') || Auth()->user()->can('Total Absensi') )
                <li class="sidebar-item {{ request()->is('pos-admin/report/attendance*') ? 'mm-active' : '' }} has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-chart-line"></i>
                        <span>{{ __('sidebar.attendance') }}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/report/attendance*') ? 'mm-active' : '' }}">
                        @can("Absensi Harian")
                        <li class="submenu-item {{ request()->is('pos-admin/report/attendance/today*') ? 'mm-active' : '' }}">
                            <a href="{{ route('attendance.today_report') }}">{{ __('sidebar.r_today_attendance') }}</a>
                        </li>
                        @endcan
                        @can("Absensi Bulanan")
                        <li class="submenu-item {{ request()->is('pos-admin/report/attendance/month*') ? 'mm-active' : '' }}">
                            <a href="{{ route('attendance.month_report') }}">{{ __('sidebar.month_attendance') }}</a>
                        </li>
                        @endcan
                        @can("Total Absensi")
                        <li class="submenu-item {{ request()->is('pos-admin/report/attendance/total*') ? 'mm-active' : '' }} ">
                            <a href="{{ route('attendance.total') }}">{{ __('sidebar.attendance_total') }}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END ATTENDANCE REPORT MENU --}}


                <li class="menu-title">{{__('sidebar.system_setting')}}</li>

                {{-- USER MANAGER MENU --}}
                @if(Auth()->user()->can('Daftar Permission') || Auth()->user()->can('Daftar Role') || Auth()->user()->can('Daftar Users') )
                <li class="sidebar-item {{ request()->is('pos-admin/user-manager*') ? 'mm-active' : '' }}  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-user-shield"></i>
                        <span>{{__('sidebar.user_manager')}}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/user-manager*') ? 'mm-active' : '' }} ">
                        @can("Daftar Permission")
                        <li class="submenu-item {{ request()->is('pos-admin/system/user-manager/permission*') ? 'mm-active' : '' }} ">
                            <a href="{{ route('permission.index') }}">{{__('sidebar.permission')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Role")
                        <li class="submenu-item {{ request()->is('pos-admin/system/user-manager/role*') || request()->is('pos-admin/system/user-manager/role-create*') ? 'mm-active' : '' }} ">
                            <a href="{{ route('role.index') }}">{{__('sidebar.role')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Users")
                        <li class="submenu-item {{ request()->is('pos-admin/system/user-manager/user*') ? 'mm-active' : '' }} ">
                            <a href="{{ route('user.index') }}">{{__('sidebar.user')}}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                {{-- END USER MANAGER MENU --}}

                {{-- SYSTEM SETTING MENU --}}
                @if(Auth()->user()->can('Setting') || Auth()->user()->can('HRM Setting') || Auth()->user()->can('Daftar Negara')
                || Auth()->user()->can('Daftar Mata Uang') || Auth()->user()->can('Daftar Bank') || Auth()->user()->can('Daftar Printer')
                || Auth()->user()->can('Daftar Pajak') || Auth()->user()->can('Daftar Box') || Auth()->user()->can('Daftar Unit') || Auth()->user()->can('Daftar Brand') )
                <li class="sidebar-item {{ request()->is('pos-admin/system*') ? 'mm-active' : '' }}  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-cogs"></i>
                        <span> {{__('sidebar.system_setting')}} </span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/system*') ? 'mm-active' : '' }} ">
                        @can("Setting")
                        <li class="submenu-item {{ request()->is('pos-admin/system/settings') ? 'mm-active' : '' }} ">
                            <a href="{{ route('sett.index') }}">{{__('sidebar.general')}}</a>
                        </li>
                        @endcan
                        @can("HRM Setting")
                        <li class="submenu-item {{ request()->is('pos-admin/system/hrm-setting') ? 'mm-active' : '' }}">
                            <a href="{{ route('hrm.setting') }}">{{__('sidebar.hrm')}}</a>
                        </li>
                        @endcan
                        @can("Daftar Negara")
                        <li class="submenu-item {{ request()->is('pos-admin/system/countries') ? 'mm-active' : '' }}">
                            <a href="{{ route('country.index') }}">{{ __('sidebar.country') }}</a>
                        </li>
                        @endcan

                        @can("Daftar Mata Uang")
                        <li class="submenu-item {{ request()->is('pos-admin/system/currency') ? 'mm-active' : '' }}">
                            <a href="{{ route('currency.index') }}">{{ __('sidebar.currency') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Bank")
                        <li class="submenu-item {{ request()->is('pos-admin/system/bank') ? 'mm-active' : '' }}">
                            <a href="{{ route('bank.index') }}">{{ __('sidebar.bank') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Printer")
                        <li class="submenu-item {{ request()->is('pos-admin/system/printer*') ? 'mm-active' : '' }}">
                            <a href="{{ route('printer.index') }}">{{ __('sidebar.printer') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Pajak")
                        <li class="submenu-item {{ request()->is('pos-admin/system/taxrate*') ? 'mm-active' : '' }}">
                            <a href="{{ route('taxrate.index') }}">{{ __('sidebar.tax_persentation') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Box")
                        <li class="submenu-item {{ request()->is('pos-admin/system/box*') ? 'mm-active' : '' }}">
                            <a href="{{ route('box.index') }}">{{ __('sidebar.box') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Unit")
                        <li class="submenu-item {{ request()->is('pos-admin/system/unit*') ? 'mm-active' : '' }}">
                            <a href="{{ route('unit.index') }}">{{ __('sidebar.unit') }}</a>
                        </li>
                        @endcan
                        @can("Daftar Brand")
                        <li class="submenu-item {{ request()->is('pos-admin/system/brand*') ? 'mm-active' : '' }}">
                            <a href="{{ route('brand.index') }}">{{ __('sidebar.brand') }}</a>
                        </li>
                        @endcan


                        <li class="submenu-item">
                            <a href="{{ route('setting.import') }}">Import Master Data</a>
                        </li>
                    </ul>
                </li>
                @endif
                {{-- END SYSTEM SETTING MENU --}}

                {{-- STORE MENU --}}
                @if(Auth()->user()->can('Tambah Toko') || Auth()->user()->can('Update Toko') || Auth()->user()->can('Pilih Toko') )
                <li class="sidebar-item {{ request()->is('pos-admin/store*') ? 'mm-active' : '' }}  has-sub">
                    <a href="#" class='sidebar-link has-arrow'>
                        <i class="fas fa-store"></i>
                        <span>{{ __('sidebar.store') }}</span>
                    </a>
                    <ul class="sub-menu {{ request()->is('pos-admin/store*') ? 'mm-active' : '' }} ">
                        @can("Tambah Toko")
                        <li class="submenu-item {{ request()->is('pos-admin/store/create') ? 'mm-active' : '' }} ">
                            <a href="{{ route('store.create') }}">{{ __('sidebar.add_store') }}</a>
                        </li>
                        @endcan
                        @can("Update Toko")
                        <li class="submenu-item {{ request()->is('pos-admin/store/update') ? 'mm-active' : '' }}">
                            <a href="{{ route('store.update') }}">{{ __('sidebar.update_store') }}</a>
                        </li>
                        @endcan
                        @can("Pilih Toko")
                        <li class="submenu-item">
                            <a href="{{ route('store.choose') }}">{{ __('sidebar.choose_store') }} </a>
                        </li>
                        @endcan
                        <li class="submenu-item {{ request()->is('pos-admin/system/store-tokens*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.store-tokens.index') }}">Token Toko</a>
                        </li>
                    </ul>
                </li>
                @endif
                {{-- END STORE MENU --}}
        </div>
        <!-- Sidebar -->
    </div>
</div>