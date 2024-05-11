<?php

use App\Http\Controllers\Admin\{
    AcademicController,
    ActivityController,
    AdminController,
    ClientController,
    CommissionController,
    ConstructionBudgetController,
    EmployeeController,
    InventoryController,
    ProductController,
    ProviderController,
    SalesFunnelController,
    ScheduleController,
    SellerController,
    ServiceOrderController,
    SubsidiaryController,
    UserController,
    SiteController,
    TicketPaymentController,
    WorkItemController,
};
use App\Http\Controllers\Admin\ACL\{
    PermissionController,
    RoleController,
};
use App\Http\Controllers\Admin\Finance\{
    ExpenseController,
    IncomeController,
    PurchaseOrderController,
    RefoundController
};
use Illuminate\Support\Facades\{
    Auth,
    Route
};

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.home');
    Route::prefix('admin')->name('admin.')->group(function () {
        /** Chart home */
        Route::get('/chart', [AdminController::class, 'chart'])->name('home.chart');

        /** Users */
        Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::get('/users/destroy/{id}', [UserController::class, 'destroy']);
        Route::resource('users', UserController::class);

        /** Activities */
        Route::get('/activities/destroy/{id}', [ActivityController::class, 'destroy']);
        Route::resource('activities', ActivityController::class);

        /** Subsidiaries */
        Route::get('/subsidiaries/managers', [SubsidiaryController::class, 'managers']);
        Route::post('/subsidiaries/managers', [SubsidiaryController::class, 'managers'])->name('managers.search');
        Route::get('/subsidiaries/collaborators', [SubsidiaryController::class, 'collaborators']);
        Route::post('/subsidiaries/collaborators', [SubsidiaryController::class, 'collaborators'])->name('collaborators.search');
        Route::get('/subsidiaries/financiers', [SubsidiaryController::class, 'financiers']);
        Route::post('/subsidiaries/financiers', [SubsidiaryController::class, 'financiers'])->name('financiers.search');
        Route::get('/subsidiaries/destroy/{id}', [SubsidiaryController::class, 'destroy']);
        Route::resource('subsidiaries', SubsidiaryController::class);

        /** Clients */
        Route::get('/clients/timeline/{id}', [ClientController::class, 'timeline']);
        Route::get('/clients/destroy/{id}', [ClientController::class, 'destroy']);
        Route::resource('clients', ClientController::class);
        Route::get('clients-pdf/{id}', [ClientController::class, 'pdf'])->name('clients.pdf');
        Route::post('clients-import', [ClientController::class, 'fileImport'])->name('clients.import');
        Route::post('/clients/file-delete', [ClientController::class, 'fileDelete'])->name('clients-file-delete');

        /** Providers */
        Route::get('/providers/destroy/{id}', [ProviderController::class, 'destroy']);
        Route::resource('providers', ProviderController::class);
        Route::get('providers-pdf/{id}', [ProviderController::class, 'pdf'])->name('providers.pdf');
        Route::post('providers-import', [ProviderController::class, 'fileImport'])->name('providers.import');

        /** Service Orders */
        Route::get('/service-orders/models', [ServiceOrderController::class, 'models'])->name('service-orders.models');
        Route::get('/service-orders/create-model/{model}', [ServiceOrderController::class, 'create'])->name('service-orders.create-model');
        Route::get('/service-orders/destroy/{id}', [ServiceOrderController::class, 'destroy']);
        Route::get('service-orders-pending', [ServiceOrderController::class, 'pending'])->name('service-orders-pending');
        Route::resource('service-orders', ServiceOrderController::class);
        Route::get('service-orders-pdf/{id}', [ServiceOrderController::class, 'pdf'])->name('service-orders.pdf');
        Route::get('service-orders-pdf-print/{id}', [ServiceOrderController::class, 'print'])->name('service-orders.pdf-print');

        Route::post('/service-orders/photo-delete', [ServiceOrderController::class, 'photoDelete'])->name('service-orders-photo-delete');
        Route::post('/service-orders/file-delete', [ServiceOrderController::class, 'fileDelete'])->name('service-orders-file-delete');

        /** Finance */
        /** Incomes */
        Route::post('/finance-incomes/changeStatus', [IncomeController::class, 'changeStatus'])->name('finance-incomes.changeStatus');
        Route::post('/finance-incomes/batchDelete', [IncomeController::class, 'batchDelete'])->name('finance-incomes.batchDelete');
        Route::post('/finance-incomes/changeValue', [IncomeController::class, 'changeValue'])->name('finance-incomes.changeValue');
        Route::get('/finance-incomes/destroy/{id}', [IncomeController::class, 'destroy']);
        Route::get('/finance-incomes/pay/{id}', [IncomeController::class, 'pay']);
        Route::get('/finance-incomes/receive/{id}', [IncomeController::class, 'receive']);
        Route::get('finance-incomes-pdf/{id}', [IncomeController::class, 'pdf'])->name('finance-incomes.pdf');
        Route::get('finance-incomes-pending', [IncomeController::class, 'pending'])->name('finance-incomes.pending');
        Route::resource('finance-incomes', IncomeController::class);

        /** Expenses */
        Route::post('/finance-expenses/changeStatus', [ExpenseController::class, 'changeStatus'])->name('finance-expenses.changeStatus');
        Route::post('/finance-expenses/batchDelete', [ExpenseController::class, 'batchDelete'])->name('finance-expenses.batchDelete');
        Route::post('/finance-expenses/changeValue', [ExpenseController::class, 'changeValue'])->name('finance-expenses.changeValue');
        Route::get('/finance-expenses/destroy/{id}', [ExpenseController::class, 'destroy']);
        Route::get('/finance-expenses/pay/{id}', [ExpenseController::class, 'pay']);
        Route::get('/finance-expenses/receive/{id}', [ExpenseController::class, 'receive']);
        Route::get('finance-expenses-pdf/{id}', [ExpenseController::class, 'pdf'])->name('finance-expenses.pdf');
        Route::get('finance-expenses-pending', [ExpenseController::class, 'pending'])->name('finance-expenses.pending');
        Route::resource('finance-expenses', ExpenseController::class);

        /** Refunds */
        Route::post('/finance-refunds/changeStatus', [RefoundController::class, 'changeStatus'])->name('finance-refunds.changeStatus');
        Route::post('/finance-refunds/batchDelete', [RefoundController::class, 'batchDelete'])->name('finance-refunds.batchDelete');
        Route::post('/finance-refunds/changeValue', [RefoundController::class, 'changeValue'])->name('finance-refunds.changeValue');
        Route::get('/finance-refunds/destroy/{id}', [RefoundController::class, 'destroy']);
        Route::get('/finance-refunds/pay/{id}', [RefoundController::class, 'pay']);
        Route::get('/finance-refunds/receive/{id}', [RefoundController::class, 'receive']);
        Route::get('finance-refunds-pdf/{id}', [RefoundController::class, 'pdf'])->name('finance-refunds.pdf');
        Route::get('finance-refunds-pending', [RefoundController::class, 'pending'])->name('finance-refunds.pending');
        Route::resource('finance-refunds', RefoundController::class);

        /** Purchase Orders */
        Route::post('/finance-purchase-orders/changeStatus', [PurchaseOrderController::class, 'changeStatus'])->name('finance-purchase-orders.changeStatus');
        Route::post('/finance-purchase-orders/batchDelete', [PurchaseOrderController::class, 'batchDelete'])->name('finance-purchase-orders.batchDelete');
        Route::post('/finance-purchase-orders/changeValue', [PurchaseOrderController::class, 'changeValue'])->name('finance-purchase-orders.changeValue');
        Route::get('/finance-purchase-orders/destroy/{id}', [PurchaseOrderController::class, 'destroy']);
        Route::get('/finance-purchase-orders/unexecuted/{id}', [PurchaseOrderController::class, 'unexecuted']);
        Route::get('/finance-purchase-orders/executed/{id}', [PurchaseOrderController::class, 'executed']);
        Route::get('finance-purchase-orders-pdf/{id}', [PurchaseOrderController::class, 'pdf'])->name('finance-purchase-orders.pdf');
        Route::get('finance-purchase-orders-pending', [PurchaseOrderController::class, 'pending'])->name('finance-purchase-orders.pending');
        Route::resource('finance-purchase-orders', PurchaseOrderController::class);

        /** Sellers */
        Route::get('/sellers/destroy/{id}', [SellerController::class, 'destroy']);
        Route::get('/sellers/commissions/{id}', [SellerController::class, 'commissions'])->name('sellers.commissions');
        Route::resource('sellers', SellerController::class);

        /** Employees */
        Route::get('employees-pdf/{id}', [EmployeeController::class, 'pdf'])->name('employees.pdf');
        Route::get('/employees/destroy/{id}', [EmployeeController::class, 'destroy']);
        Route::resource('employees', EmployeeController::class);
        Route::post('employees-import', [EmployeeController::class, 'fileImport'])->name('employees.import');

        /** Comissions */
        Route::get('/commissions/receipt/{id}', [CommissionController::class, 'receipt'])->name('commissions.receipt');
        Route::post('/commissions/changeStatus', [CommissionController::class, 'changeStatus'])->name('commissions.changeStatus');
        Route::get('commissions-pdf/{id}', [CommissionController::class, 'pdf'])->name('commissions.pdf');
        Route::get('/commissions/pay/{id}', [CommissionController::class, 'pay']);
        Route::get('/commissions/receive/{id}', [CommissionController::class, 'receive']);
        Route::get('/commissions/destroy/{id}', [CommissionController::class, 'destroy']);
        Route::resource('commissions', CommissionController::class);

        /** Ticket Payments */
        Route::get('/ticket-payments/receipt/{id}', [TicketPaymentController::class, 'receipt'])->name('ticketPayments.receipt');
        Route::post('/ticket-payments/changeStatus', [TicketPaymentController::class, 'changeStatus'])->name('ticket-payments.changeStatus');
        Route::post('/ticket-payments/batchDelete', [TicketPaymentController::class, 'batchDelete'])->name('ticket-payments.batchDelete');
        Route::post('/ticket-payments/changeValue', [TicketPaymentController::class, 'changeValue'])->name('ticket-payments.changeValue');
        Route::get('ticket-payments-pdf/{id}', [TicketPaymentController::class, 'pdf'])->name('ticket-payments.pdf');
        Route::get('/ticket-payments/pay/{id}', [TicketPaymentController::class, 'pay']);
        Route::get('/ticket-payments/receive/{id}', [TicketPaymentController::class, 'receive']);
        Route::get('/ticket-payments/destroy/{id}', [TicketPaymentController::class, 'destroy']);
        Route::resource('ticket-payments', TicketPaymentController::class);

        /** Inventory */
        /** Products */
        Route::get('/products/destroy/{id}', [ProductController::class, 'destroy']);
        Route::resource('products', ProductController::class);
        Route::post('products-import', [ProductController::class, 'fileImport'])->name('products.import');
        /** Stocks  */
        Route::match(['get', 'post'], 'stocks/consolidated', [InventoryController::class, 'consolidated'])->name('stocks.consolidated');
        Route::get('stocks-pdf/{id}', [InventoryController::class, 'pdf'])->name('stocks.pdf');
        Route::get('/stocks/destroy/{id}', [InventoryController::class, 'destroy']);
        Route::resource('stocks', InventoryController::class);

        /** Schedule */
        Route::get('schedule-day/{day?}', [ScheduleController::class, 'day']);
        Route::resource('schedule', ScheduleController::class);

        /** Sales Funnel */
        Route::post('sales-funnel-search-seller', [SalesFunnelController::class, 'index'])->name('sales-funnel.search-seller');
        Route::post('sales-funnel-ajax-update', [SalesFunnelController::class, 'update'])->name('sales-funnel-ajax.update');
        Route::delete('sales-funnel-ajax-destroy', [SalesFunnelController::class, 'destroy'])->name('sales-funnel-ajax.destroy');
        Route::resource('sales-funnel', SalesFunnelController::class);
        Route::post('sales-funnel-import', [SalesFunnelController::class, 'fileImport'])->name('sales-funnel.import');

        /** Budgets  */
        Route::get('/construction-budget/destroy/{id}', [ConstructionBudgetController::class, 'destroy']);
        Route::resource('construction-budget', ConstructionBudgetController::class);
        /** Work Items */
        Route::get('/budgets/work-items/destroy/{id}', [WorkItemController::class, 'destroy']);
        Route::resource('budgets/work-items', WorkItemController::class);

        /**
         * ACL
         * */
        /** Permissions */
        Route::get('/permission/destroy/{id}', [PermissionController::class, 'destroy']);
        Route::resource('permission', PermissionController::class);
        /** Roles */
        Route::get('/role/destroy/{id}', [RoleController::class, 'destroy']);
        Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permissions');
        Route::put('role/{role}/permission/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
        Route::resource('role', RoleController::class);
    });
});

/** Web */
/** Home */
// Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect('admin');
});

Auth::routes([
    'register' => false,
]);

Route::fallback(function () {
    return view('404');
});
