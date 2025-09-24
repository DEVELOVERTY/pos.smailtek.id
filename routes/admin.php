<?php

use App\Http\Controllers\Account\ExpenseCategoryController;
use App\Http\Controllers\Account\ExpenseController;
use App\Http\Controllers\Account\ProfitController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PrinterController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SettingsHrmController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\StoreTokenController;
use App\Http\Controllers\Admin\TaxrateController;
use App\Http\Controllers\Admin\TimezoneController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Hrm\AttendanceController;
use App\Http\Controllers\Hrm\DepartmentController;
use App\Http\Controllers\Hrm\DesignationController;
use App\Http\Controllers\Hrm\EmployeeController;
use App\Http\Controllers\Product\BoxController;
use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\UnitController;
use App\Http\Controllers\Product\VariantController;
use App\Http\Controllers\Salary\AllowanceController;
use App\Http\Controllers\Salary\CuttingSalaryController;
use App\Http\Controllers\Salary\SalaryController;
use App\Http\Controllers\Stock\StockAdjustmentController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Stock\StockTransferController;
use App\Http\Controllers\Stock\SupplierController;
use App\Http\Controllers\Transaction\DueController;
use App\Http\Controllers\Transaction\PurchaseController;
use App\Http\Controllers\Transaction\ReturnController;
use App\Http\Controllers\Transaction\SalesReturnController;
use App\Http\Controllers\Transaction\SellController;
use App\Models\Account\ExpenseCategory;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // Store Route
    Route::prefix('store')->group(function () {
        Route::get('choose-store', [StoreController::class, 'index'])->name('store.choose');
        Route::get('choose/{id}', [StoreController::class, 'choose'])->name('choose.store');
        Route::middleware('store')->group(function () {
            Route::get('create', [StoreController::class, 'create'])->name('store.create');
            Route::post('store/{any}', [StoreController::class, 'store'])->name('store.store');
            Route::get('update', [StoreController::class, 'update'])->name('store.update');
        });
    });

    Route::middleware('store')->group(function () {
        Route::get('/home', [AdminController::class, 'index'])->name('index');

        Route::prefix('auth')->group(function () {
            Route::get("profile", [AdminController::class, 'myProfile'])->name('profile');
            Route::post("change-profile", [AdminController::class, 'changeProfile'])->name('change.profile');
            Route::post("change-pass", [AdminController::class, 'changePassword'])->name('change.password');
        });

        Route::get('income-expense', [AdminController::class, 'incomeAndExpense']);
        Route::get("transaction-data", [AdminController::class, 'transactionData']);
        Route::get('sell-month', [AdminController::class, 'sellmonth']);

        // Settings Route
        Route::prefix('system')->group(function () {

            // settings
            Route::get('settings', [SettingController::class, 'index'])->name('sett.index');
            Route::post('settings-store', [SettingController::class, 'store'])->name('sett.store');
            Route::post('bg-login-store', [SettingController::class, 'bg_login_store'])->name('sett.bg_login_store');

            // HRM SETTINGS
            Route::get('hrm-setting', [SettingsHrmController::class, 'index'])->name('hrm.setting');
            Route::post("hrm-store", [SettingsHrmController::class, 'store'])->name('hrm.store');

            // countries
            Route::get('countries', [CountryController::class, 'index'])->name('country.index');
            Route::post('countries-store/{any}', [CountryController::class, 'store'])->name('country.store');
            Route::get('countries-delete/{id}', [CountryController::class, 'delete'])->name('country.delete');

            // timezone
            Route::get('timezone', [TimezoneController::class, 'index'])->name('timezone.index');
            Route::get('timezone-delete/{id}', [TimezoneController::class, 'delete'])->name('timezone.delete');
            Route::post('timezone-store/{any}', [TimezoneController::class, 'store'])->name('timezone.store');

            // currency
            Route::get('currency', [CurrencyController::class, 'index'])->name('currency.index');
            Route::get('currency-delete/{id}', [CurrencyController::class, 'delete'])->name('currency.delete');
            Route::post('currency-store/{any}', [CurrencyController::class, 'store'])->name('currency.store');

            // Bank
            Route::get('bank', [BankController::class, 'index'])->name('bank.index');
            Route::get('bank-delete/{id}', [BankController::class, 'delete'])->name('bank.delete');
            Route::post('bank-store/{any}', [BankController::class, 'store'])->name('bank.store');
            Route::get('get-bank', [BankController::class, 'getbank']);

            // Printer
            Route::get('printer', [PrinterController::class, 'index'])->name('printer.index');
            Route::get('printer-create', [PrinterController::class, 'create'])->name('printer.create');
            Route::get('printer-update/{id}', [PrinterController::class, 'update'])->name('printer.update');
            Route::get('printer-delete/{id}', [PrinterController::class, 'delete'])->name('printer.delete');
            Route::post('printer-store/{any}', [PrinterController::class, 'store'])->name('printer.store');

            // Taxrate
            Route::get('taxrate', [TaxrateController::class, 'index'])->name('taxrate.index');
            Route::get('taxrate-create', [TaxrateController::class, 'create'])->name('taxrate.create');
            Route::get('taxrate-update/{id}', [TaxrateController::class, 'update'])->name('taxrate.update');
            Route::get('taxrate-delete/{id}', [TaxrateController::class, 'delete'])->name('taxrate.delete');
            Route::post('taxrate-store/{any}', [TaxrateController::class, 'store'])->name('taxrate.store');

            // Box
            Route::get('box', [BoxController::class, 'index'])->name('box.index');
            Route::get('box-create', [BoxController::class, 'create'])->name('box.create');
            Route::get('box-update/{id}', [BoxController::class, 'update'])->name('box.update');
            Route::get('box-delete/{id}', [BoxController::class, 'delete'])->name('box.delete');
            Route::post('box-store/{any}', [BoxController::class, 'store'])->name('box.store');

            // Unit
            Route::get('unit', [UnitController::class, 'index'])->name('unit.index');
            Route::get('unit-create', [UnitController::class, 'create'])->name('unit.create');
            Route::get('unit-update/{id}', [UnitController::class, 'update'])->name('unit.update');
            Route::get('unit-delete/{id}', [UnitController::class, 'delete'])->name('unit.delete');
            Route::post('unit-store/{any}', [UnitController::class, 'store']);

            // Brand
            Route::get('brand', [BrandController::class, 'index'])->name('brand.index');
            Route::get('brand-create', [BrandController::class, 'create'])->name('brand.create');
            Route::get('brand-update/{id}', [BrandController::class, 'update'])->name('brand.update');
            Route::get('brand-delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');
            Route::post('brand-store/{any}', [BrandController::class, 'store'])->name('brand.store');

            // Store Tokens
            Route::get('store-tokens', [StoreTokenController::class, 'index'])->name('admin.store-tokens.index');
            Route::get('store-tokens/{store}/edit', [StoreTokenController::class, 'edit'])->name('admin.store-tokens.edit');
            Route::put('store-tokens/{store}', [StoreTokenController::class, 'update'])->name('admin.store-tokens.update');
            Route::get('store-tokens/generate', [StoreTokenController::class, 'generateToken'])->name('admin.store-tokens.generate');

            // Import Master Data
            Route::get("import",[SettingController::class,'import'])->name('setting.import');
            Route::post("import-store",[SettingController::class,'importStore'])->name('setting.import_store');
            
            
        });

        Route::prefix('hrm')->group(function () {

            // department
            Route::get('department', [DepartmentController::class, 'index'])->name('department.index');
            Route::get('department-delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');
            Route::post('department-store/{any}', [DepartmentController::class, 'store'])->name('department.store');

            // designation
            Route::get('designation', [DesignationController::class, 'index'])->name('designation.index');
            Route::get('designation-create', [DesignationController::class, 'create'])->name('designation.create');
            Route::get('designation-update/{id}', [DesignationController::class, 'update'])->name('designation.update');
            Route::get('designation-delete/{id}', [DesignationController::class, 'delete'])->name('designation.delete');
            Route::post('designation-store/{any}', [DesignationController::class, 'store'])->name('designation.store');

            // Allowance Route
            Route::get('allowance', [AllowanceController::class, 'index'])->name('allowance.index');
            Route::get('allowance-create', [AllowanceController::class, 'create'])->name('allowance.create');
            Route::get('allowance-update/{id}', [AllowanceController::class, 'update'])->name('allowance.update');
            Route::get('allowance-delete/{id}', [AllowanceController::class, 'delete'])->name('allowance.delete');
            Route::post('allowance-store/{any}', [AllowanceController::class, 'store'])->name('allowance.store');
            Route::get('get-designation/{id}', [AllowanceController::class, 'getDesignation']);

            // CUTTING SALARY
            Route::get('cutting-salary', [CuttingSalaryController::class, 'index'])->name('cutting.index');
            Route::get('cutting-create', [CuttingSalaryController::class, 'create'])->name('cutting.create');
            Route::get('cutting-update/{id}', [CuttingSalaryController::class, 'update'])->name('cutting.update');
            Route::get('cutting-delete/{id}', [CuttingSalaryController::class, 'delete'])->name('cutting.delete');
            Route::post('cutting-store/{any}', [CuttingSalaryController::class, 'store'])->name('cutting.store');

            // ATTENDANCE
            Route::get('checkint', [AttendanceController::class, 'checkint'])->name('attendance.check');
            Route::get('checkout', [AttendanceController::class, 'checkout'])->name('attendance.checkout');
        });

        Route::prefix('attendance')->group(function () {
            Route::get('today', [AttendanceController::class, 'today'])->name('attendance.today');
        });

        Route::prefix('salary')->group(function () {
            Route::get("index", [SalaryController::class, 'generate'])->name('generate.salary');
            Route::get('get-employee/{id}', [SalaryController::class, 'getEmployee']);
            Route::post('store', [SalaryController::class, 'store'])->name('salary.store');
            Route::get('list', [SalaryController::class, 'list'])->name('salary.list');
            Route::post('update-status', [SalaryController::class, 'updatePayment'])->name('salary.status');
            Route::get('detail/{id}', [SalaryController::class, 'detail'])->name('salary.detail');
            Route::get('print/{id}', [SalaryController::class, 'print'])->name('salary.print');
        });

        Route::prefix('employee')->group(function () {
            // employee
            Route::get('employee', [EmployeeController::class, 'index'])->name('employee.index');
            Route::get('employee-create', [EmployeeController::class, 'create'])->name('employee.create');
            Route::get('employee-update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
            Route::get('employee-delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
            Route::post('employee-store/{any}', [EmployeeController::class, 'store'])->name('employee.store');
        });

        /**
         * Category Product Route
         */
        Route::prefix('category')->group(function () {
            Route::get('category', [CategoryController::class, 'index'])->name('category.index');
            Route::get('category-create', [CategoryController::class, 'create'])->name('category.create');
            Route::get('category-update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::get('category-delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
            Route::post('category-store/{any}', [CategoryController::class, 'store'])->name('category.store');

            // Subcategory
            Route::get('subcategory', [CategoryController::class, 'subcategory'])->name('subcategory.index');
            Route::get('subcategory-create', [CategoryController::class, 'subCreate'])->name('subcategory.create');
            Route::get('subcategory-update/{id}', [CategoryController::class, 'updateSub'])->name('subcategory.update');
            Route::get('by-category/{id}', [CategoryController::class, 'byCat'])->name('subcategory.byCat');

            // Import Category & Subcategory
            Route::get("/import",[CategoryController::class,'import'])->name('category.import');
            
            Route::post("/post-category",[CategoryController::class,'importStore'])->name('category.import_store');
        });

        /**
         * Supplier Route
         */
        Route::prefix('supplier')->group(function () {
            Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
            Route::get('supplier-create', [SupplierController::class, 'create'])->name('supplier.create');
            Route::get('supplier-update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
            Route::get('supplier-delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
            Route::post('supplier-store/{any}', [SupplierController::class, 'store'])->name('supplier.store');
        });

        /**
         * Customer Route
         */
        Route::prefix('customer')->group(function () {
            Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
            Route::get('customer-create', [CustomerController::class, 'create'])->name('customer.create');
            Route::get('customer-update/{id}', [CustomerController::class, 'update'])->name('customer.update');
            Route::get('customer-delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
            Route::post('customer-store/{any}', [CustomerController::class, 'store'])->name('customer.store');
        });

        /**
         *  Product Route
         */

        Route::prefix('product')->group(function () {
            Route::get('create', [ProductController::class, 'create'])->name('product.create');
            Route::get('getSub/{id}', [ProductController::class, 'getSubcategory']);
            Route::get('getVariant/{id}', [ProductController::class, 'getVariation']);
            Route::get('/', [ProductController::class, 'index'])->name('product.index');
            Route::get('/auto', [ProductController::class, 'autoload']);
            Route::get('update/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
            Route::get('variation-delete/{id}', [ProductController::class, 'deleteVariation']);
            Route::post('store/{any}', [ProductController::class, 'store'])->name('product.store');
            Route::get("opening-stock/{id}", [ProductController::class, 'openStock'])->name("product.opening");
            Route::post("store-opening/{any}", [ProductController::class, 'openStockStore'])->name("store.opening");

            // Barcode Product
            Route::get('print-barcode', [ProductController::class, 'printBarcode'])->name('product.barcode');
            Route::post('barcode-print', [ProductController::class, 'printBar'])->name('barcode.print');
            Route::get('purchase-label/{id}', [ProductController::class, 'poLabel'])->name('barcode.purchase');

            // export Product
            Route::get("export-product",[ProductController::class,'product_export'])->name('product.export');

            // Import Product
            Route::get("import-product",[ProductController::class,'productimport'])->name('product.import');
            Route::post('import',[ProductController::class,'import'])->name('product.import_store');
            Route::post('import-variant',[ProductController::class,'import_variant'])->name('product.import_variant_store');
            /**
             *  Variant Route
             */
            Route::prefix('variant')->group(function () {
                Route::get('index', [VariantController::class, 'index'])->name('variant.index');
                Route::get('variant-create', [VariantController::class, 'create'])->name('variant.create');
                Route::get('variant-update/{id}', [VariantController::class, 'update'])->name('variant.update');
                Route::get('variant-delete/{id}', [VariantController::class, 'delete'])->name('variant.delete');
                Route::post('variant-store/{any}', [VariantController::class, 'store'])->name('variant.store');
                Route::post('variant-value-delete/{id}', [VariantController::class, 'deleteValue']);
            });
        });

        /**
         *  Purchase Route
         */
        Route::prefix('purchase')->group(function () {
            Route::get('index', [PurchaseController::class, 'index'])->name('purchase.index');
            Route::get('create', [PurchaseController::class, 'create'])->name('purchase.create');

            Route::get('getProduct', [PurchaseController::class, 'getProduct']);
            Route::get('get-dom-item/{id}', [PurchaseController::class, 'domVariantItem']);
            Route::get('update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
            Route::get('delete/{id}', [PurchaseController::class, 'delete'])->name('purchase.delete');
            Route::post('store', [PurchaseController::class, 'store'])->name('purchase.store');
            Route::get('detail/{id}', [PurchaseController::class, 'detail'])->name('purchase.detail');
            Route::get('get-tax/{id}', [PurchaseController::class, 'getTax']);
            Route::get('print-invoice/{id}', [PurchaseController::class, 'printInvoice'])->name('purchase.print');
            Route::post('update-status', [PurchaseController::class, 'updateStatus'])->name('purchase.status');
            Route::post('add-pay', [PurchaseController::class, 'purchasePay'])->name('purchase.payment');
            Route::post("update-payment", [PurchaseController::class, 'updatePayment'])->name("purchase.payment_status");
        });

        /**
         *  Sell Route
         */
        Route::prefix('sell')->group(function () {
            Route::get('detail/{id}', [SellController::class, 'detail'])->name('sell.detail');
            Route::get('print/{id}', [SellController::class, 'print'])->name('sell.print');
        });


        /**
         *  Return Route
         */
        Route::prefix('return')->group(function () {
            Route::get('index', [ReturnController::class, 'index'])->name('return.index');
            Route::get('by-purchase/{id}', [ReturnController::class, 'byPo'])->name('return.po');
            Route::post('store', [ReturnController::class, 'store'])->name('return.store');

            Route::get('detail/{id}', [ReturnController::class, 'detail'])->name('return.detail');
            Route::get('print-return/{id}', [ReturnController::class, 'print'])->name('return.print');
        });

        /**
         *  Return Sell Route
         */
        Route::prefix('return-sell')->group(function () {
            Route::get("create/{id}", [SalesReturnController::class, 'bysell'])->name("returnsell.create");
            Route::post("store", [SalesReturnController::class, 'store'])->name("returnsell.store");
            Route::get("sell-return/{id}", [SalesReturnController::class, 'getProduct']);
            Route::get("return-dom/{id}", [SalesReturnController::class, 'domItem']);
            Route::get("/", [SalesReturnController::class, 'index'])->name('returnsell.index');
            Route::get("download",[SalesReturnController::class,'download'])->name("returnsell.download");
            Route::get("detail/{id}",[SalesReturnController::class,'detail'])->name("returnsell.detail");
            Route::get("print/{id}",[SalesReturnController::class,'print'])->name("returnsell.print");
        });

        /**
         *  Stock Transfer
         */
        Route::prefix('stock-transfer')->group(function () {
            Route::get('index', [StockTransferController::class, 'index'])->name('transfer.index');
            Route::get('detail/{id}', [StockTransferController::class, 'detail'])->name('transfer.detail');
            Route::get('create', [StockTransferController::class, 'create'])->name('transfer.create');
            Route::get('print/{id}', [StockTransferController::class, 'print'])->name('transfer.print');
            Route::post('store', [StockTransferController::class, 'store'])->name('transfer.store');
            Route::post('change-status', [StockTransferController::class, 'changeStatus'])->name('transfer.status');
            Route::get('get-store/{id}', [StockTransferController::class, 'getStore']);
            Route::get('getProduct', [StockTransferController::class, 'getProduct']);
        });

        /**
         *  Stock Adjustment
         */
        Route::prefix('stock-adjustment')->group(function () {
            Route::get('index', [StockAdjustmentController::class, 'index'])->name('adjustment.index');
            Route::get('create', [StockAdjustmentController::class, 'create'])->name('adjustment.create');
            Route::get('detail/{id}', [StockAdjustmentController::class, 'detail'])->name('adjustment.detail');
            Route::get('print/{id}', [StockAdjustmentController::class, 'print'])->name('adjustment.print');
            Route::post('store', [StockAdjustmentController::class, 'store'])->name('adjustment.store');
        });

        /**
         *  Route For Expense Category
         */
        Route::prefix('expense-category')->group(function () {
            Route::get('category', [ExpenseCategoryController::class, 'index'])->name('exca.index');
            Route::get('category-create', [ExpenseCategoryController::class, 'create'])->name('exca.create');
            Route::get('category-update/{id}', [ExpenseCategoryController::class, 'update'])->name('exca.update');
            Route::get('category-delete/{id}', [ExpenseCategoryController::class, 'delete'])->name('exca.delete');
            Route::post('category-store/{any}', [ExpenseCategoryController::class, 'store'])->name('exca.store');

            // Subcategory
            Route::get('subcategory', [ExpenseCategoryController::class, 'subcategory'])->name('exsub.index');
            Route::get('subcategory-create', [ExpenseCategoryController::class, 'subCreate'])->name('exsub.create');
            Route::get('subcategory-update/{id}', [ExpenseCategoryController::class, 'updateSub'])->name('exsub.update');
            Route::get('by-category/{id}', [ExpenseCategoryController::class, 'byCat'])->name('exsub.byCat');
        });

        /**
         *  Route For Expense
         */
        Route::prefix('expense')->group(function () {
            Route::get('index', [ExpenseController::class, 'index'])->name('expense.index');
            Route::get('create', [ExpenseController::class, 'create'])->name('expense.create');
            Route::get('update/{id}', [ExpenseController::class, 'update'])->name('expense.update');
            Route::get('delete/{id}', [ExpenseController::class, 'delete'])->name('expense.delete');
            Route::get('detail/{id}', [ExpenseController::class, 'detail'])->name('expense.detail');
            Route::get('getSub/{id}', [ExpenseController::class, 'getSubcategory']);
            Route::post('store/{any}', [ExpenseController::class, 'store'])->name('expense.store');
        });

        /**
         *  Route For Reports
         */
        Route::prefix('report')->group(function () {

            // Transaction Report
            Route::prefix('transaction')->group(function () {
                Route::get('sell', [SellController::class, 'report'])->name('sell.report');
                Route::get('purchase', [PurchaseController::class, 'report'])->name('purchase.report');
                Route::get('return', [ReturnController::class, 'report'])->name('return.report');
                Route::get('due', [DueController::class, 'index'])->name('due.report');
                Route::get('due/detail/{id}', [DueController::class, 'detail'])->name('due.detail');
                Route::get('due/print/{id}', [DueController::class, 'print'])->name('due.print');
                Route::get('due/payment/{id}', [DueController::class, 'listPembayaran'])->name('due.payment');
                Route::get('expense', [ExpenseController::class, 'report'])->name('expense.report');
                Route::get('profit-loss', [ProfitController::class, 'index'])->name('profit.loss');
            });

            Route::prefix('stock-product')->group(function () {
                Route::get('top-product', [ProductController::class, 'topProduct'])->name('top.product');
                Route::get('stock-alert', [StockController::class, 'stock_alert'])->name('stock.alert');
                Route::get('transfer', [StockTransferController::class, 'report'])->name('stock.transfer');
                Route::get('adjustment', [StockAdjustmentController::class, 'report'])->name('stock.adjustment');
                Route::get("all-stock", [ProductController::class, 'stockReport'])->name("all.stock");
            });

            // Attendance Report
            Route::prefix('attendance')->group(function () {
                Route::get('today', [AttendanceController::class, 'report_today'])->name('attendance.today_report');
                Route::get('month', [AttendanceController::class, 'report_month'])->name('attendance.month_report');
                Route::get('total', [AttendanceController::class, 'report_total'])->name('attendance.total');
            });
        });


        Route::prefix('download')->group(function () {
            Route::get("selling", [SellController::class, 'download'])->name('sell.download');
            Route::get("purchase", [PurchaseController::class, 'download'])->name('purchase.download');
            Route::get('return', [ReturnController::class, 'download'])->name('return.download');
            Route::get("due", [DueController::class, 'download'])->name('due.download');
            Route::get('stock-adjusment', [StockAdjustmentController::class, 'download'])->name('adjusment.download');
            Route::get("transfer", [StockTransferController::class, 'download'])->name('transfer.download');
        });

        /**
         *  Route For User Manager
         */
        Route::prefix('user-manager')->group(function () {

            // Permission
            Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
            Route::get('permission-delete/{id}', [PermissionController::class, 'delete'])->name('permission.delete');
            Route::post('permission-store/{any}', [PermissionController::class, 'store'])->name('permission.store');

            // Role
            Route::get('role', [RoleController::class, 'index'])->name('role.index');
            Route::get('role-create', [RoleController::class, 'create'])->name('role.create');
            Route::get('role-update/{id}', [RoleController::class, 'update'])->name('role.update');
            Route::post('role-store/{any}', [RoleController::class, 'store'])->name('role.store');
            Route::get("role-delete/{id}",[RoleController::class,'delete'])->name("role.delete");

            // Users
            Route::get('user', [UsersController::class, 'index'])->name('user.index');
            Route::get('user-create', [UsersController::class, 'create'])->name('user.create');
            Route::get('user-update/{id}', [UsersController::class, 'update'])->name('user.update');
            Route::get('user-delete/{id}', [UsersController::class, 'delete'])->name('user.delete');
            Route::post('user-store', [UsersController::class, 'store'])->name('user.store');
            Route::post('user-supdate', [UsersController::class, 'edit'])->name('user.edit');
            Route::get('role-permission-delete/{id}/{any}', [RoleController::class, 'deletePermission']);
        });
    });
});
