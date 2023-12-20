<?php

use App\Http\Controllers\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Admin\AdminManagement\PermissionController;
use App\Http\Controllers\Admin\AdminManagement\RoleController;
use App\Http\Controllers\Admin\Auth\LoginContorller as AdminLoginController;
use App\Http\Controllers\Admin\UserManagementController as AdminUserManagementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
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


// Overwrite Default Routes

Route::prefix('user')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

	Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

	Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset']);
});












Route::group(['middleware' => ['admin', 'permission'],'prefix'=>'admin'], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard');

	Route::get('/export-permissions', function () {
		$filename = 'permissions.csv';
		$filePath = createCSV($filename);

		return Response::download($filePath, $filename);
	})->name('export.permissions');

	Route::group(['as' => 'am.', 'prefix' => 'admin-management'], function () {
		Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
			Route::get('index', [AdminController::class, 'index'])->name('admin_list');
			Route::get('details/{id}', [AdminController::class, 'details'])->name('details.admin_list');
			Route::get('create', [AdminController::class, 'create'])->name('admin_create');
			Route::post('create', [AdminController::class, 'store'])->name('admin_create');
			Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin_edit');
			Route::put('edit/{id}', [AdminController::class, 'update'])->name('admin_edit');
			Route::get('status/{id}', [AdminController::class, 'status'])->name('status.admin_edit');
			Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin_delete');
		});
		Route::group(['as' => 'permission.', 'prefix' => 'permission'], function () {
			Route::get('index', [PermissionController::class, 'index'])->name('permission_list');
			Route::get('details/{id}', [PermissionController::class, 'details'])->name('details.permission_list');
			Route::get('create', [PermissionController::class, 'create'])->name('permission_create');
			Route::post('create', [PermissionController::class, 'store'])->name('permission_create');
			Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permission_edit');
			Route::put('edit/{id}', [PermissionController::class, 'update'])->name('permission_edit');
		});
		Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
			Route::get('index', [RoleController::class, 'index'])->name('role_list');
			Route::get('details/{id}', [RoleController::class, 'details'])->name('details.role_list');
			Route::get('create', [RoleController::class, 'create'])->name('role_create');
			Route::post('create', [RoleController::class, 'store'])->name('role_create');
			Route::get('edit/{id}', [RoleController::class, 'edit'])->name('role_edit');
			Route::put('edit/{id}', [RoleController::class, 'update'])->name('role_edit');
			Route::get('delete/{id}', [RoleController::class, 'delete'])->name('role_delete');
		});

	});

	Route::group(['as' => 'um.', 'prefix' => 'user-management'], function () {
		Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
			Route::get('index', [AdminUserManagementController::class, 'index'])->name('user_list');
			Route::get('details/{id}', [AdminUserManagementController::class, 'details'])->name('details.user_list');
			Route::get('create', [AdminUserManagementController::class, 'create'])->name('user_create');
			Route::post('create', [AdminUserManagementController::class, 'store'])->name('user_create');
			Route::get('edit/{id}', [AdminUserManagementController::class, 'edit'])->name('user_edit');
			Route::put('edit/{id}', [AdminUserManagementController::class, 'update'])->name('user_edit');
			Route::get('status/{id}', [AdminUserManagementController::class, 'status'])->name('status.user_edit');
			Route::get('delete/{id}', [AdminUserManagementController::class, 'delete'])->name('user_delete');
		});
	});
	
});
Route::group(['middleware' => 'auth','prefix'=>'user'], function () {
	Route::get('/profile', function () {
		return view('user.profile');
	})->name('user.profile');
});

