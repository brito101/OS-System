<?php

use App\Http\Controllers\Admin\{
    AcademicController,
    ActivityController,
    AdminController,
    ClientController,
    ProviderController,
    ServiceOrderController,
    SubsidiaryController,
    UserController,
    SiteController,
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

        /** Providers */
        Route::get('/providers/destroy/{id}', [ProviderController::class, 'destroy']);
        Route::resource('providers', ProviderController::class);
        Route::get('providers-pdf/{id}', [ProviderController::class, 'pdf'])->name('providers.pdf');
        Route::post('providers-import', [ProviderController::class, 'fileImport'])->name('providers.import');

        /** Service Orders */
        Route::get('/service-orders/destroy/{id}', [ServiceOrderController::class, 'destroy']);
        Route::resource('service-orders', ServiceOrderController::class);
        Route::get('service-orders-pdf/{id}', [ServiceOrderController::class, 'pdf'])->name('service-orders.pdf');

        /** Finance */
        /** Incomes */
        Route::get('/finance-incomes/destroy/{id}', [IncomeController::class, 'destroy']);
        Route::get('/finance-incomes/pay/{id}', [IncomeController::class, 'pay']);
        Route::get('/finance-incomes/receive/{id}', [IncomeController::class, 'receive']);
        Route::get('finance-incomes-pdf/{id}', [IncomeController::class, 'pdf'])->name('finance-incomes.pdf');
        Route::resource('finance-incomes', IncomeController::class);

        /** Expenses */
        Route::get('/finance-expenses/destroy/{id}', [ExpenseController::class, 'destroy']);
        Route::get('/finance-expenses/pay/{id}', [ExpenseController::class, 'pay']);
        Route::get('/finance-expenses/receive/{id}', [ExpenseController::class, 'receive']);
        Route::get('finance-expenses-pdf/{id}', [ExpenseController::class, 'pdf'])->name('finance-expenses.pdf');
        Route::resource('finance-expenses', ExpenseController::class);

        /** Refunds */
        Route::get('/finance-refunds/destroy/{id}', [RefoundController::class, 'destroy']);
        Route::get('/finance-refunds/pay/{id}', [RefoundController::class, 'pay']);
        Route::get('/finance-refunds/receive/{id}', [RefoundController::class, 'receive']);
        Route::get('finance-refunds-pdf/{id}', [RefoundController::class, 'pdf'])->name('finance-refunds.pdf');
        Route::resource('finance-refunds', RefoundController::class);

        /** Purchase Orders */
        Route::get('/finance-purchase-orders/destroy/{id}', [PurchaseOrderController::class, 'destroy']);
        Route::get('/finance-purchase-orders/unexecuted/{id}', [PurchaseOrderController::class, 'unexecuted']);
        Route::get('/finance-purchase-orders/executed/{id}', [PurchaseOrderController::class, 'executed']);
        Route::get('finance-purchase-orders-pdf/{id}', [PurchaseOrderController::class, 'pdf'])->name('finance-purchase-orders.pdf');
        Route::resource('finance-purchase-orders', PurchaseOrderController::class);

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

Auth::routes();

Route::fallback(function () {
    return view('404');
});
