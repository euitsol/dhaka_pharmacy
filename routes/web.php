<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Admin\AdminManagement\PermissionController;
use App\Http\Controllers\Admin\AdminManagement\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\Auth\LoginContorller as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagement\KycSettingsController as UserKycController;
use App\Http\Controllers\Admin\UserManagement\SubmittedKycController;
use App\Http\Controllers\Admin\UserManagement\UserController as AdminUserController;
use App\Http\Controllers\User\ProfileController;

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
	Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

	Route::get('/export-permissions', function () {
		$filename = 'permissions.csv';
		$filePath = createCSV($filename);
		return Response::download($filePath, $filename);
	})->name('export.permissions');

	Route::group(['as' => 'am.', 'prefix' => 'admin-management'], function () {
		Route::controller(AdminController::class, 'admin')->prefix('admin')->name('admin.')->group(function () {
			Route::get('index', 'index')->name('admin_list');
			Route::get('details/{id}', 'details')->name('details.admin_list');
			Route::get('create', 'create')->name('admin_create');
			Route::post('create', 'store')->name('admin_create');
			Route::get('edit/{id}', 'edit')->name('admin_edit');
			Route::put('edit/{id}', 'update')->name('admin_edit');
			Route::get('status/{id}', 'status')->name('status.admin_edit');
			Route::get('delete/{id}', 'delete')->name('admin_delete');
		});
		Route::controller(PermissionController::class, 'permission')->prefix('permission')->name('permission.')->group(function () {
			Route::get('index', 'index')->name('permission_list');
			Route::get('details/{id}', 'details')->name('details.permission_list');
			Route::get('create', 'create')->name('permission_create');
			Route::post('create', 'store')->name('permission_create');
			Route::get('edit/{id}', 'edit')->name('permission_edit');
			Route::put('edit/{id}', 'update')->name('permission_edit');
		});
		Route::controller(AdminRoleController::class, 'role')->prefix('role')->name('role.')->group(function () {
			Route::get('index', 'index')->name('role_list');
			Route::get('details/{id}', 'details')->name('details.role_list');
			Route::get('create', 'create')->name('role_create');
			Route::post('create', 'store')->name('role_create');
			Route::get('edit/{id}', 'edit')->name('role_edit');
			Route::put('edit/{id}', 'update')->name('role_edit');
			Route::get('delete/{id}', 'delete')->name('role_delete');
		});

	});

	Route::group(['as' => 'um.', 'prefix' => 'user-management'], function () {

		Route::controller(AdminUserController::class, 'user')->prefix('user')->name('user.')->group(function () {
			Route::get('index', 'index')->name('user_list');
			Route::get('details/{id}', 'details')->name('details.user_list');
			Route::get('create', 'create')->name('user_create');
			Route::post('create', 'store')->name('user_create');
			Route::get('edit/{id}', 'edit')->name('user_edit');
			Route::put('edit/{id}', 'update')->name('user_edit');
			Route::get('status/{id}', 'status')->name('status.user_edit');
			Route::get('delete/{id}', 'delete')->name('user_delete');
		});

		// KYC ROUTES 
		Route::group(['as' => 'user_kyc.', 'prefix' => 'user-kyc'], function () {
			Route::controller(SubmittedKycController::class, 'kyc-list')->prefix('kyc-list')->name('kyc_list.')->group(function () {
				Route::get('index', 'index')->name('user_kyc_list');
				Route::get('details/{id}', 'details')->name('details.user_kyc_list');
				Route::get('create', 'create')->name('user_kyc_create');
				Route::post('create', 'store')->name('user_kyc_create');
				Route::get('edit/{id}', 'edit')->name('user_kyc_edit');
				Route::put('edit/{id}', 'update')->name('user_kyc_edit');
				Route::get('status/{id}', 'status')->name('status.user_kyc_edit');
				Route::get('delete/{id}', 'delete')->name('user_kyc_delete');
			});
			
			Route::get('/settings', [UserKycController::class, 'kycSettings'])->name('user_kyc_settings');
			Route::post('/settings', [UserKycController::class, 'kycSettingsUpdate'])->name('user_kyc_settings');

		});
	});




	
});
Route::group(['middleware' => 'auth','prefix'=>'user'], function () {
	Route::get('/profile', [ProfileController::class, 'profile'])->name('user.profile');
});

