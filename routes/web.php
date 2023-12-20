<?php

use App\Http\Controllers\Backend\AdminLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Backend\AdminManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login');

});


Auth::routes();
Route::get('/admin/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'adminLoginCheck'])->name('admin.login');


Route::group(['middleware' => ['admin', 'permission'],'prefix'=>'admin'], function () {
    Route::get('/dashboard', function () {
        return view('backend.dashboard.dashboard');
    })->name('dashboard');

	Route::get('/export-permissions', function () {
		$filename = 'permissions.csv';
		$filePath = createCSV($filename);
	
		return Response::download($filePath, $filename);
	})->name('export.permissions');

	Route::group(['as' => 'um.', 'prefix' => 'user-management'], function () {
		Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
			Route::get('index', [AdminManagementController::class, 'index'])->name('user_list');
			Route::get('details/{id}', [AdminManagementController::class, 'details'])->name('details.user_list');
			Route::get('create', [AdminManagementController::class, 'create'])->name('user_create');
			Route::post('create', [AdminManagementController::class, 'store'])->name('user_create');
			Route::get('edit/{id}', [AdminManagementController::class, 'edit'])->name('user_edit');
			Route::put('edit/{id}', [AdminManagementController::class, 'update'])->name('user_edit');
			Route::get('status/{id}', [AdminManagementController::class, 'status'])->name('status.user_edit');
			Route::get('delete/{id}', [AdminManagementController::class, 'delete'])->name('user_delete');
		});
		Route::group(['as' => 'permission.', 'prefix' => 'permission'], function () {
			Route::get('index', [AdminManagementController::class, 'p_index'])->name('permission_list');
			Route::get('details/{id}', [AdminManagementController::class, 'p_details'])->name('details.permission_list');
			Route::get('create', [AdminManagementController::class, 'P_create'])->name('permission_create');
			Route::post('create', [AdminManagementController::class, 'p_store'])->name('permission_create');
			Route::get('edit/{id}', [AdminManagementController::class, 'p_edit'])->name('permission_edit');
			Route::put('edit/{id}', [AdminManagementController::class, 'p_update'])->name('permission_edit');
		});
		Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
			Route::get('index', [AdminManagementController::class, 'r_index'])->name('role_list');
			Route::get('details/{id}', [AdminManagementController::class, 'r_details'])->name('details.role_list');
			Route::get('create', [AdminManagementController::class, 'r_create'])->name('role_create');
			Route::post('create', [AdminManagementController::class, 'r_store'])->name('role_create');
			Route::get('edit/{id}', [AdminManagementController::class, 'r_edit'])->name('role_edit');
			Route::put('edit/{id}', [AdminManagementController::class, 'r_update'])->name('role_edit');
			Route::get('delete/{id}', [AdminManagementController::class, 'r_delete'])->name('role_delete');
		});

	});

	
});
