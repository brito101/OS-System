<?php

use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ServiceOrderController;
use App\Http\Controllers\Admin\SubsidiaryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
        Route::get('/subsidiaries/destroy/{id}', [SubsidiaryController::class, 'destroy']);
        Route::resource('subsidiaries', SubsidiaryController::class);

        /** Clients */
        Route::get('/clients/destroy/{id}', [ClientController::class, 'destroy']);
        Route::resource('clients', ClientController::class);
        Route::post('clients-import', [ClientController::class, 'fileImport'])->name('clients.import');

        /** Service Orders */
        Route::get('/clients/service-orders/{id}', [ServiceOrderController::class, 'destroy']);
        Route::resource('service-orders', ServiceOrderController::class);

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
