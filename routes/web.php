<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Admin\AdminManagement\PermissionController;
use App\Http\Controllers\Admin\AdminManagement\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\Auth\LoginContorller as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistributedOrder\DistributedOrderController;
use App\Http\Controllers\Admin\DM_Management\DistrictManagerController;
use App\Http\Controllers\Admin\DM_Management\DmKycController;
use App\Http\Controllers\Admin\DM_Management\DmKycSettingsController;
use App\Http\Controllers\Admin\LAM_Management\LamKycController;
use App\Http\Controllers\Admin\LAM_Management\LamKycSettingsController;
use App\Http\Controllers\Admin\LAM_Management\LocalAreaManagerController;
use App\Http\Controllers\Admin\UserManagement\UserKycSettingsController;
use App\Http\Controllers\Admin\UserManagement\UserKycController;
use App\Http\Controllers\Admin\UserManagement\UserController as AdminUserController;
use App\Http\Controllers\Admin\PharmacyManagement\PharmacyController as AdminPharmacyController;
use App\Http\Controllers\Admin\PharmacyManagement\PharmacyKycController;
use App\Http\Controllers\Admin\PharmacyManagement\PharmacyKycSettingsController;
use App\Http\Controllers\Admin\ProductManagement\ProductCategoryController;
use App\Http\Controllers\Admin\ProductManagement\ProductSubCategoryController;
use App\Http\Controllers\Admin\OperationalArea\OperationAreaController;
use App\Http\Controllers\Admin\OperationalArea\OperationSubAreaController;
use App\Http\Controllers\Admin\OrderManagement\OrderManagementController;
use App\Http\Controllers\Admin\PushNotification\SettingController as PushNotificationSetting;
use App\Http\Controllers\Admin\PaymentGateway\SettingController as PaymentGatewaySetting;
use App\Http\Controllers\Admin\PaymentManagement\PaymentManagementController;
use App\Http\Controllers\Admin\ProductManagement\CompanyNameController;
use App\Http\Controllers\Admin\ProductManagement\GenericNameController;
use App\Http\Controllers\Admin\ProductManagement\MedicineCategoryController;
use App\Http\Controllers\Admin\ProductManagement\MedicineController;
use App\Http\Controllers\Admin\ProductManagement\MedicineStrengthController;
use App\Http\Controllers\Admin\ProductManagement\MedicineUnitController;
use App\Http\Controllers\Admin\RiderManagement\RiderKycController;
use App\Http\Controllers\Admin\RiderManagement\RiderKycSettingsController;
use App\Http\Controllers\Admin\RiderManagement\RiderManagementController;
use App\Http\Controllers\Admin\SiteSettingsController;

use App\Http\Controllers\DM\Auth\LoginController as DmLoginController;
use App\Http\Controllers\DM\DashboardController as DmDashboardController;
use App\Http\Controllers\DM\DmProfileController;
use App\Http\Controllers\DM\LAM_management\LamManagementController;
use App\Http\Controllers\DM\UserManagement\UserManagementController as DmUserController;
use App\Http\Controllers\DM\KYC\KycVerificationController as DmKycVerificationController;
use App\Http\Controllers\DM\LAM_management\OparetionalAreaController as DmOparetionalAreaController;

use App\Http\Controllers\LAM\Auth\LoginController as LamLoginController;
use App\Http\Controllers\LAM\DashboardController as LamDashboardController;
use App\Http\Controllers\LAM\UserManagement\UserManagementController as LamUserController;
use App\Http\Controllers\LAM\LamProfileController;
use App\Http\Controllers\LAM\KYC\KycVerificationController as LamKycVerificationController;
use App\Http\Controllers\LAM\OperationalAreaController as LamOperationalAreaController;

use App\Http\Controllers\Rider\Auth\LoginController as RiderLoginController;
use App\Http\Controllers\Rider\DashboardController as RiderDashboardController;
use App\Http\Controllers\Rider\RiderProfileController;
use App\Http\Controllers\Rider\KYC\KycVerificationController as RiderKycVerificationController;
use App\Http\Controllers\Rider\OrderManagementController as RiderOrderManagementController;

use App\Http\Controllers\Pharmacy\DashboardController as PharmacyDashboardController;
use App\Http\Controllers\Pharmacy\Auth\LoginController as PharmacyLoginController;
use App\Http\Controllers\Pharmacy\PharmacyProfileController;
use App\Http\Controllers\Pharmacy\KYC\KycVerificationController as PharmacyKycVerificationController;
use App\Http\Controllers\Pharmacy\OperationalAreaController as PharmacyOperationalAreaController;
use App\Http\Controllers\Pharmacy\OrderManagementController as PharmacyOrderManagementController;

use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController as UserForgotPasswordController;

use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\Product\SingleProductController;
use App\Http\Controllers\Frontend\PaymentGateway\SslCommerzController;
use App\Http\Controllers\Frontend\BaseController as FrontendBaseController;
use App\Http\Controllers\Frontend\Product\ProductPageController;
use App\Http\Controllers\Frontend\ProductOrder\CheckoutController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\AddressController as UserAddressController;

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

// Route::get('/', function () {
//     return redirect()->route('admin.login');
// });


Auth::routes();
// Admin Login Routes
Route::get('/admin/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'adminLoginCheck'])->name('admin.login');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Pharmacy Login Routes
Route::get('/pharmacy/login', [PharmacyLoginController::class, 'pharmacyLogin'])->name('pharmacy.login');
Route::post('/pharmacy/login', [PharmacyLoginController::class, 'pharmacyLoginCheck'])->name('pharmacy.login');
Route::post('/pharmacy/logout', [PharmacyLoginController::class, 'logout'])->name('pharmacy.logout');


// DM Login Routes
Route::get('/district-manager/login', [DmLoginController::class, 'dmLogin'])->name('district_manager.login');
Route::post('/district-manager/login', [DmLoginController::class, 'dmLoginCheck'])->name('district_manager.login');
Route::post('/district-manager/logout', [DmLoginController::class, 'logout'])->name('district_manager.logout');
// LAM Login Routes
Route::get('/local-area-manager/login', [LamLoginController::class, 'lamLogin'])->name('local_area_manager.login');
Route::post('/local-area-manager/login', [LamLoginController::class, 'lamLoginCheck'])->name('local_area_manager.login');
Route::post('/local-area-manager/logout', [LamLoginController::class, 'logout'])->name('local_area_manager.logout');
Route::post('local-area-manager/register', [LamLoginController::class, 'lamRegister'])->name('local_area_manager.register');
Route::get('local-area-manager/reference/{id}', [LamLoginController::class, 'reference'])->name('local_area_manager.reference');

// Rider Login Routes
Route::get('/rider/login', [RiderLoginController::class, 'riderLogin'])->name('rider.login');
Route::post('/rider/login', [RiderLoginController::class, 'riderLoginCheck'])->name('rider.login');
Route::post('/rider/logout', [RiderLoginController::class, 'logout'])->name('rider.logout');


// Google Login
Route::get('/google-redirect', [UserLoginController::class, 'googleRedirect'])->name('login_with_google');
Route::get('/auth/google/callback', [UserLoginController::class, 'googleCallback']);

// Github Login
Route::get('/github-redirect', [UserLoginController::class, 'githubRedirect'])->name('login_with_github');
Route::get('/auth/github/callback', [UserLoginController::class, 'githubCallback']);

// Facebook Login
Route::get('/facebook-redirect', [UserLoginController::class, 'facebookRedirect'])->name('login_with_facebook');
Route::get('/auth/facebook/callback', [UserLoginController::class, 'facebookCallback']);

// Overwrite Default Authentication Routes
Route::prefix('user')->group(function () {
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserLoginController::class, 'login']);

    Route::post('/otp-varify', [UserLoginController::class, 'send_otp'])->name('use.send_otp');
    Route::get('/otp-varify', [UserLoginController::class, 'verify'])->name('use.send_otp');
    Route::get('/send-otp/again', [UserLoginController::class, 'send_otp_again'])->name('use.send_otp.again');
    Route::post('/otp/verify', [UserLoginController::class, 'otp_verify'])->name('use.otp.verify');


    Route::get('/registration', [UserRegisterController::class, 'register'])->name('use.register');
    Route::post('/registration', [UserRegisterController::class, 'rStore'])->name('use.register');
    Route::get('/register/phone/validation/{phone}', [UserRegisterController::class, 'phoneValidation'])->name('use.register.phone.validation');

    Route::get('/password/forgot', [UserForgotPasswordController::class, 'forgotPassword'])->name('user.forgot.password');
    Route::post('/password/forgot', [UserForgotPasswordController::class, 'forgotPasswordOtp'])->name('user.forgot.password');
    Route::get('/reset/password', [UserForgotPasswordController::class, 'resetPassword'])->name('user.reset.password');
    Route::post('/reset/password', [UserForgotPasswordController::class, 'resetPasswordStore'])->name('user.reset.password');
});




//SSL Commerz Routes

Route::controller(SslCommerzController::class)->prefix('payment')->name('payment.')->group(function () {
    // Route::get('/example1', 'exampleEasyCheckout')->name('checkout1');
    // Route::get('/example2', 'exampleHostedCheckout')->name('checkout2');
    Route::get('/ssl/{order_id}', 'index')->name('index');
    // Route::post('/pay-via-ajax', 'payViaAjax'])->name('index_ajax');
    Route::post('/success', 'success')->name('success');
    Route::post('/fail', 'fail')->name('fail');
    Route::post('/cancel', 'cancel')->name('cancel');
    Route::post('/ipn', 'ipn')->name('ipn');
});












Route::group(['middleware' => ['admin', 'permission'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/export-permissions', function () {
        $filename = 'permissions.csv';
        $filePath = createCSV($filename);
        return Response::download($filePath, $filename);
    })->name('export.permissions');

    // Admin Management Routes
    Route::group(['as' => 'am.', 'prefix' => 'admin-management'], function () {
        Route::controller(AdminController::class)->prefix('admin')->name('admin.')->group(function () {
            Route::get('index', 'index')->name('admin_list');
            Route::get('details/{id}', 'details')->name('details.admin_list');
            Route::get('profile/{id}', 'profile')->name('admin_profile');
            Route::get('create', 'create')->name('admin_create');
            Route::post('create', 'store')->name('admin_create');
            Route::get('edit/{id}', 'edit')->name('admin_edit');
            Route::put('edit/{id}', 'update')->name('admin_edit');
            Route::get('status/{id}', 'status')->name('status.admin_edit');
            Route::get('delete/{id}', 'delete')->name('admin_delete');
        });
        Route::controller(PermissionController::class)->prefix('permission')->name('permission.')->group(function () {
            Route::get('index', 'index')->name('permission_list');
            Route::get('details/{id}', 'details')->name('details.permission_list');
            Route::get('create', 'create')->name('permission_create');
            Route::post('create', 'store')->name('permission_create');
            Route::get('edit/{id}', 'edit')->name('permission_edit');
            Route::put('edit/{id}', 'update')->name('permission_edit');
        });
        Route::controller(AdminRoleController::class)->prefix('role')->name('role.')->group(function () {
            Route::get('index', 'index')->name('role_list');
            Route::get('details/{id}', 'details')->name('details.role_list');
            Route::get('create', 'create')->name('role_create');
            Route::post('create', 'store')->name('role_create');
            Route::get('edit/{id}', 'edit')->name('role_edit');
            Route::put('edit/{id}', 'update')->name('role_edit');
            Route::get('delete/{id}', 'delete')->name('role_delete');
        });
    });

    // Admin User Management Routes
    Route::group(['as' => 'um.', 'prefix' => 'user-management'], function () {

        Route::controller(AdminUserController::class)->prefix('user')->name('user.')->group(function () {
            Route::get('index', 'index')->name('user_list');
            Route::get('details/{id}', 'details')->name('details.user_list');
            Route::get('profile/{id}', 'profile')->name('user_profile');
            Route::get('create', 'create')->name('user_create');
            Route::post('create', 'store')->name('user_create');
            Route::get('edit/{id}', 'edit')->name('user_edit');
            Route::put('edit/{id}', 'update')->name('user_edit');
            Route::get('status/{id}', 'status')->name('status.user_edit');
            Route::get('delete/{id}', 'delete')->name('user_delete');
        });

        // KYC ROUTES
        Route::group(['as' => 'user_kyc.', 'prefix' => 'user-kyc'], function () {
            Route::controller(UserKycController::class)->prefix('kyc-list')->name('kyc_list.')->group(function () {
                Route::get('index', 'index')->name('user_kyc_list');
                Route::get('details/{id}', 'details')->name('details.user_kyc_list');
                Route::get('create', 'create')->name('user_kyc_create');
                Route::post('create', 'store')->name('user_kyc_create');
                Route::get('edit/{id}', 'edit')->name('user_kyc_edit');
                Route::put('edit/{id}', 'update')->name('user_kyc_edit');
                Route::get('status/{id}', 'status')->name('status.user_kyc_edit');
                Route::get('delete/{id}', 'delete')->name('user_kyc_delete');
            });

            Route::get('/settings', [UserKycSettingsController::class, 'kycSettings'])->name('user_kyc_settings');
            Route::post('/settings', [UserKycSettingsController::class, 'kycSettingsUpdate'])->name('user_kyc_settings');
        });
    });


    // Admin Pharmacy Management Routes
    Route::group(['as' => 'pm.', 'prefix' => 'pharmacy-management'], function () {

        Route::controller(AdminPharmacyController::class)->prefix('pharmacy')->name('pharmacy.')->group(function () {
            Route::get('index', 'index')->name('pharmacy_list');
            Route::get('details/{id}', 'details')->name('details.pharmacy_list');
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.pharmacy_profile');
            Route::get('profile/{id}', 'profile')->name('pharmacy_profile');
            Route::get('create', 'create')->name('pharmacy_create');
            Route::post('create', 'store')->name('pharmacy_create');
            Route::get('edit/{id}', 'edit')->name('pharmacy_edit');
            Route::put('edit/{id}', 'update')->name('pharmacy_edit');
            Route::get('status/{id}', 'status')->name('status.pharmacy_edit');
            Route::get('delete/{id}', 'delete')->name('pharmacy_delete');
            Route::get('discount/{id}', 'pharmacyDiscount')->name('pharmacy_discount');
            Route::post('discount/update/{id}', 'pharmacyDiscountUpdate')->name('update.pharmacy_discount');
        });

        // KYC ROUTES
        Route::group(['as' => 'pharmacy_kyc.', 'prefix' => 'pharmacy-kyc'], function () {
            Route::controller(PharmacyKycController::class)->prefix('kyc-list')->name('kyc_list.')->group(function () {
                Route::get('index', 'index')->name('pharmacy_kyc_list');
                Route::get('details/{id}', 'details')->name('pharmacy_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.pharmacy_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.pharmacy_kyc_status');
                Route::put('declained/{id}', 'declained')->name('declined.pharmacy_kyc_status');
                Route::get('delete/{id}', 'delete')->name('pharmacy_kyc_delete');
            });

            Route::get('/settings', [PharmacyKycSettingsController::class, 'kycSettings'])->name('pharmacy_kyc_settings');
            Route::post('/settings', [PharmacyKycSettingsController::class, 'kycSettingsUpdate'])->name('pharmacy_kyc_settings');
        });
    });
    //Admin District Manager Management Routes
    Route::group(['as' => 'opa.', 'prefix' => 'operational-areas'], function () {
        //Oparetaion Area Route
        Route::controller(OperationAreaController::class)->prefix('operation-area')->name('operation_area.')->group(function () {
            Route::get('index', 'index')->name('operation_area_list');
            Route::get('details/{id}', 'details')->name('details.operation_area_list');
            Route::get('create', 'create')->name('operation_area_create');
            Route::post('create', 'store')->name('operation_area_create');
            Route::get('edit/{slug}', 'edit')->name('operation_area_edit');
            Route::put('edit/{id}', 'update')->name('operation_area_edit');
            Route::get('status/{id}', 'status')->name('status.operation_area_edit');
            Route::get('delete/{id}', 'delete')->name('operation_area_delete');
        });
        //Oparetaion Sub Area Route
        Route::controller(OperationSubAreaController::class)->prefix('operation-sub-area')->name('operation_sub_area.')->group(function () {
            Route::get('index', 'index')->name('operation_sub_area_list');
            Route::get('details/{id}', 'details')->name('details.operation_sub_area_list');
            Route::get('create', 'create')->name('operation_sub_area_create');
            Route::post('create', 'store')->name('operation_sub_area_create');
            Route::get('edit/{slug}', 'edit')->name('operation_sub_area_edit');
            Route::put('edit/{id}', 'update')->name('operation_sub_area_edit');
            Route::get('status/{id}/{status}', 'status')->name('status.operation_sub_area_edit');
            Route::get('delete/{id}', 'delete')->name('operation_sub_area_delete');
        });
    });

    //Admin District Manager Management Routes
    Route::group(['as' => 'dm_management.', 'prefix' => 'dm-management'], function () {
        Route::controller(DistrictManagerController::class)->prefix('district-manager')->name('district_manager.')->group(function () {
            Route::get('index', 'index')->name('district_manager_list');
            Route::get('details/{id}', 'details')->name('details.district_manager_list');
            Route::get('profile/{id}', 'profile')->name('district_manager_profile');
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.district_manager_profile');
            Route::get('create', 'create')->name('district_manager_create');
            Route::post('create', 'store')->name('district_manager_create');
            Route::get('edit/{id}', 'edit')->name('district_manager_edit');
            Route::put('edit/{id}', 'update')->name('district_manager_edit');
            Route::get('status/{id}', 'status')->name('status.district_manager_edit');
            Route::get('delete/{id}', 'delete')->name('district_manager_delete');
        });





        // KYC ROUTES
        Route::group(['as' => 'dm_kyc.', 'prefix' => 'district-manager-kyc'], function () {
            Route::controller(DmKycController::class)->prefix('kyc-list')->name('kyc_list.')->group(function () {
                Route::get('index', 'index')->name('district_manager_kyc_list');
                Route::get('details/{id}', 'details')->name('district_manager_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.district_manager_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.district_manager_kyc_status');
                Route::put('declained/{id}', 'declained')->name('declined.district_manager_kyc_status');
                Route::get('delete/{id}', 'delete')->name('district_manager_kyc_delete');
            });

            Route::get('/settings', [DmKycSettingsController::class, 'kycSettings'])->name('district_manager_kyc_settings');
            Route::post('/settings', [DmKycSettingsController::class, 'kycSettingsUpdate'])->name('district_manager_kyc_settings');
        });
    });

    //Admin Local Area Manager Management Routes
    Route::group(['as' => 'lam_management.', 'prefix' => 'lam-management'], function () {
        Route::controller(LocalAreaManagerController::class)->prefix('local-area-manager')->name('local_area_manager.')->group(function () {
            Route::get('index', 'index')->name('local_area_manager_list');
            Route::get('details/{id}', 'details')->name('details.local_area_manager_list');
            Route::get('profile/{id}', 'profile')->name('local_area_manager_profile');
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.local_area_manager_profile');
            Route::get('create', 'create')->name('local_area_manager_create');
            Route::post('create', 'store')->name('local_area_manager_create');
            Route::get('edit/{id}', 'edit')->name('local_area_manager_edit');
            Route::put('edit/{id}', 'update')->name('local_area_manager_edit');
            Route::get('status/{id}', 'status')->name('status.local_area_manager_edit');
            Route::get('delete/{id}', 'delete')->name('local_area_manager_delete');

            Route::get('get-operation-area/{dm_id}', 'get_operation_area')->name('operation_area.local_area_manager_list');
        });

        // KYC ROUTES
        Route::group(['as' => 'lam_kyc.', 'prefix' => 'local-area-manager-kyc'], function () {
            Route::controller(LamKycController::class)->prefix('kyc-list')->name('kyc_list.')->group(function () {
                Route::get('index', 'index')->name('local_area_manager_kyc_list');
                Route::get('details/{id}', 'details')->name('local_area_manager_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.local_area_manager_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.local_area_manager_kyc_status');
                Route::put('declained/{id}', 'declained')->name('declined.local_area_manager_kyc_status');
                Route::get('delete/{id}', 'delete')->name('local_area_manager_kyc_delete');

            });

            Route::get('/settings', [LamKycSettingsController::class, 'kycSettings'])->name('local_area_manager_kyc_settings');
            Route::post('/settings', [LamKycSettingsController::class, 'kycSettingsUpdate'])->name('local_area_manager_kyc_settings');
        });
    });

    //Admin Rider Management Routes
    Route::group(['as' => 'rm.', 'prefix' => 'rider-management'], function () {
        Route::controller(RiderManagementController::class)->prefix('rider')->name('rider.')->group(function () {
            Route::get('index', 'index')->name('rider_list');
            Route::get('details/{id}', 'details')->name('details.rider_list');
            Route::get('profile/{id}', 'profile')->name('rider_profile');
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.rider_profile');
            Route::get('create', 'create')->name('rider_create');
            Route::post('create', 'store')->name('rider_create');
            Route::get('edit/{id}', 'edit')->name('rider_edit');
            Route::put('edit/{id}', 'update')->name('rider_edit');
            Route::get('status/{id}', 'status')->name('status.rider_edit');
            Route::get('delete/{id}', 'delete')->name('rider_delete');
            Route::get('get-operational-sub-area/{oa_id}', 'get_operational_sub_area')->name('operation_sub_area.rider_list');
        });

        // KYC ROUTES
        Route::group(['as' => 'rider_kyc.', 'prefix' => 'rider-kyc'], function () {
            Route::controller(RiderKycController::class)->prefix('kyc-list')->name('kyc_list.')->group(function () {
                Route::get('index', 'index')->name('rider_kyc_list');
                Route::get('details/{id}', 'details')->name('rider_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.rider_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.rider_kyc_status');
                Route::put('declained/{id}', 'declained')->name('declined.rider_kyc_status');
                Route::get('delete/{id}', 'delete')->name('rider_kyc_delete');
            });

            Route::get('/settings', [RiderKycSettingsController::class, 'kycSettings'])->name('rider_kyc_settings');
            Route::post('/settings', [RiderKycSettingsController::class, 'kycSettingsUpdate'])->name('rider_kyc_settings');
        });
    });

    // Product Management Routes
    Route::group(['as' => 'product.', 'prefix' => 'product-management'], function () {
        Route::controller(GenericNameController::class)->prefix('generic-name')->name('generic_name.')->group(function () {
            Route::get('index', 'index')->name('generic_name_list');
            Route::get('details/{id}', 'details')->name('details.generic_name_list');
            Route::get('create', 'create')->name('generic_name_create');
            Route::post('create', 'store')->name('generic_name_create');
            Route::get('edit/{slug}', 'edit')->name('generic_name_edit');
            Route::put('edit/{id}', 'update')->name('generic_name_edit');
            Route::get('status/{id}', 'status')->name('status.generic_name_edit');
            Route::get('delete/{id}', 'delete')->name('generic_name_delete');
        });
        Route::controller(CompanyNameController::class)->prefix('company-name')->name('company_name.')->group(function () {
            Route::get('index', 'index')->name('company_name_list');
            Route::get('details/{id}', 'details')->name('details.company_name_list');
            Route::get('create', 'create')->name('company_name_create');
            Route::post('create', 'store')->name('company_name_create');
            Route::get('edit/{slug}', 'edit')->name('company_name_edit');
            Route::put('edit/{id}', 'update')->name('company_name_edit');
            Route::get('status/{id}', 'status')->name('status.company_name_edit');
            Route::get('delete/{id}', 'delete')->name('company_name_delete');
        });
        Route::controller(MedicineCategoryController::class)->prefix('medicine-category')->name('medicine_category.')->group(function () {
            Route::get('index', 'index')->name('medicine_category_list');
            Route::get('details/{slug}', 'details')->name('details.medicine_category_list');
            Route::get('create', 'create')->name('medicine_category_create');
            Route::post('create', 'store')->name('medicine_category_create');
            Route::get('edit/{slug}', 'edit')->name('medicine_category_edit');
            Route::put('edit/{id}', 'update')->name('medicine_category_edit');
            Route::get('status/{id}', 'status')->name('status.medicine_category_edit');
            Route::get('featured/{id}', 'featured')->name('featured.medicine_category_edit');
            Route::get('delete/{id}', 'delete')->name('medicine_category_delete');
        });

        Route::controller(MedicineUnitController::class)->prefix('medicine-unit')->name('medicine_unit.')->group(function () {
            Route::get('index', 'index')->name('medicine_unit_list');
            Route::get('details/{id}', 'details')->name('details.medicine_unit_list');
            Route::get('create', 'create')->name('medicine_unit_create');
            Route::post('create', 'store')->name('medicine_unit_create');
            Route::get('edit/{id}', 'edit')->name('medicine_unit_edit');
            Route::put('edit/{id}', 'update')->name('medicine_unit_edit');
            Route::get('status/{id}', 'status')->name('status.medicine_unit_edit');
            Route::get('delete/{id}', 'delete')->name('medicine_unit_delete');
        });
        Route::controller(MedicineStrengthController::class)->prefix('medicine-strength')->name('medicine_strength.')->group(function () {
            Route::get('index', 'index')->name('medicine_strength_list');
            Route::get('details/{id}', 'details')->name('details.medicine_strength_list');
            Route::get('create', 'create')->name('medicine_strength_create');
            Route::post('create', 'store')->name('medicine_strength_create');
            Route::get('edit/{id}', 'edit')->name('medicine_strength_edit');
            Route::put('edit/{id}', 'update')->name('medicine_strength_edit');
            Route::get('status/{id}', 'status')->name('status.medicine_strength_edit');
            Route::get('delete/{id}', 'delete')->name('medicine_strength_delete');
        });

        Route::controller(ProductCategoryController::class)->prefix('product-category')->name('product_category.')->group(function () {
            Route::get('index', 'index')->name('product_category_list');
            Route::get('details/{id}', 'details')->name('details.product_category_list');
            Route::get('create', 'create')->name('product_category_create');
            Route::post('create', 'store')->name('product_category_create');
            Route::get('edit/{slug}', 'edit')->name('product_category_edit');
            Route::put('edit/{id}', 'update')->name('product_category_edit');
            Route::get('status/{id}', 'status')->name('status.product_category_edit');
            Route::get('featured/{id}', 'featured')->name('featured.product_category_edit');
            Route::get('menu/{id}', 'menu')->name('menu.product_category_edit');
            Route::get('delete/{id}', 'delete')->name('product_category_delete');
        });
        Route::controller(ProductSubCategoryController::class)->prefix('product-sub-category')->name('product_sub_category.')->group(function () {
            Route::get('index', 'index')->name('product_sub_category_list');
            Route::get('details/{id}', 'details')->name('details.product_sub_category_list');
            Route::get('create', 'create')->name('product_sub_category_create');
            Route::post('create', 'store')->name('product_sub_category_create');
            Route::get('edit/{slug}', 'edit')->name('product_sub_category_edit');
            Route::put('edit/{id}', 'update')->name('product_sub_category_edit');
            Route::get('status/{id}', 'status')->name('status.product_sub_category_edit');
            Route::get('menu/{id}', 'menu')->name('menu.product_sub_category_edit');
            Route::get('delete/{id}', 'delete')->name('product_sub_category_delete');
        });
        Route::controller(MedicineController::class)->prefix('medicine')->name('medicine.')->group(function () {
            Route::get('index', 'index')->name('medicine_list');
            Route::get('get-sub-category/{id}', 'get_sub_cat')->name('sub_cat.medicine_list');
            Route::get('details/{slug}', 'details')->name('details.medicine_list');
            Route::get('create', 'create')->name('medicine_create');
            Route::post('create', 'store')->name('medicine_create');
            Route::get('edit/{slug}', 'edit')->name('medicine_edit');
            Route::put('edit/{id}', 'update')->name('medicine_edit');
            Route::get('status/{id}', 'status')->name('status.medicine_edit');
            Route::get('best-selling/{id}', 'best_selling')->name('best_selling.medicine_edit');
            Route::get('featured/{id}', 'featured')->name('featured.medicine_edit');
            Route::get('delete/{id}', 'delete')->name('medicine_delete');
        });
    });



    // Notification Settings
    Route::controller(PushNotificationSetting::class)->prefix('push-notification')->name('push.')->group(function () {
        Route::get('index', 'index')->name('ns');
        Route::post('update', 'store')->name('update.ns');
        Route::get('template/edit/{id}', 'edit_nt')->name('nt.ns');
        Route::put('template/edit/{id}', 'update_nt')->name('nt.ns');
        Route::get('template/status/{id}', 'status_nt')->name('nt.status.ns');
    });

    // Payment Gateway Settings
    Route::controller(PaymentGatewaySetting::class)->prefix('payment-gateway-settings')->name('payment_gateway.')->group(function () {
        Route::get('index', 'ssl_commerz')->name('pg_ssl_commerz');
        Route::post('update', 'store')->name('update.pg_settings');
    });

    // Admin Order Management
    Route::group(['as' => 'om.', 'prefix' => 'order-management'], function () {
        Route::controller(OrderManagementController::class)->prefix('order')->name('order.')->group(function () {
            Route::get('/{status}', 'index')->name('order_list');
            Route::get('/details/{id}', 'details')->name('order_details');
            Route::get('/order-distribution/{id}', 'order_distribution')->name('order_distribution');
            Route::post('/order-distribution/{order_id}', 'order_distribution_store')->name('order_distribution');
        });

    });

    // Admin Distributed Order
    Route::controller(DistributedOrderController::class)->prefix('distributed-order')->name('do.')->group(function () {
        Route::get('/{status}', 'index')->name('do_list');
        Route::get('/{status}/orders', 'dispute')->name('dispute.do_list');
        Route::get('/details/{do_id}', 'details')->name('do_details');
        Route::get('/edit/{do_id}/{pid}', 'edit')->name('do_edit');
        Route::post('/update', 'update')->name('do_update');

        Route::post('/rider/{do_id}', 'do_rider')->name('do_rider');
    });



    // Admin Payment Management
    Route::group(['as' => 'pym.', 'prefix' => 'payment-management'], function () {
        Route::controller(PaymentManagementController::class)->prefix('payment')->name('payment.')->group(function () {
            Route::get('/{status}', 'index')->name('payment_list');
            Route::get('/details/{id}', 'details')->name('payment_details');
        });

    });

    // Site Settings
    Route::controller(SiteSettingsController::class)->prefix('site-settings')->name('settings.')->group(function () {
        Route::get('index', 'index')->name('site_settings');
        Route::post('update', 'store')->name('update.site_settings');
        Route::post('index', 'notification')->name('notification.site_settings');
        Route::get('email-template/edit/{id}', 'et_edit')->name('email_templates.site_settings');
        Route::put('email-template/edit/{id}', 'et_update')->name('email_templates.site_settings');
    });

});




// Pharmacy Auth Routes
Route::group(['middleware' => 'pharmacy','as' => 'pharmacy.', 'prefix' => 'pharmacy'], function () {
    Route::get('/profile', [PharmacyProfileController::class, 'profile'])->name('profile');


    Route::get('/dashboard', [PharmacyDashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(PharmacyKycVerificationController::class)->prefix('kyc')->name('kyc.')->group(function () {
        Route::post('/store', 'kyc_store')->name('store');
        Route::get('/verification', 'kyc_verification')->name('verification');
        Route::post('/kyc/file/upload', 'file_upload')->name('file.upload');
        Route::get('/kyc/file/delete', 'delete')->name('file.delete');
    });

    Route::controller(PharmacyProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::post('/address/store', 'address')->name('address');
        Route::put('/update/password', 'updatePassword')->name('update.password');
        Route::post('/update/image', 'updateImage')->name('update.image');

        Route::get('/get-operation-sub-area/{oa_id}', 'get_osa')->name('get_osa');
    });

    Route::controller(PharmacyOrderManagementController::class)->prefix('order-management')->name('order_management.')->group(function () {
        Route::get('/{status}', 'index')->name('index');
        Route::get('details/{do_id}/{status}', 'details')->name('details');
        Route::post('update/{do_id}', 'update')->name('update');
    });


    Route::controller(PharmacyOperationalAreaController::class)->prefix('operational-area')->name('operational_area.')->group(function () {
        Route::get('index', 'index')->name('list');
    });
});


// DM Auth Routes
Route::group(['middleware' => 'dm', 'as' => 'dm.', 'prefix' => 'district-manager'], function () {

    Route::get('/dashboard', [DmDashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(DmKycVerificationController::class)->prefix('kyc')->name('kyc.')->group(function () {
        Route::post('/store', 'kyc_store')->name('store');
        Route::get('/verification', 'kyc_verification')->name('verification');
        Route::post('/kyc/file/upload', 'file_upload')->name('file.upload');
        Route::get('/kyc/file/delete', 'delete')->name('file.delete');
    });



    Route::controller(DmProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::put('/update/password', 'updatePassword')->name('update.password');
        Route::post('/update/image', 'updateImage')->name('update.image');
    });

    //LAM Route
    Route::controller(LamManagementController::class)->prefix('lam-management')->name('lam.')->group(function () {
        Route::get('index', 'index')->name('list');
        Route::get('details/{id}', 'details')->name('details.list');
        Route::get('profile/{id}', 'profile')->name('profile');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('edit/{id}', 'update')->name('edit');
        Route::get('status/{id}', 'status')->name('status.edit');
        Route::get('delete/{id}', 'delete')->name('delete');
    });

    //User Route
    Route::controller(DmUserController::class)->prefix('user-management')->name('user.')->group(function () {
        Route::get('index', 'index')->name('list');
        Route::get('details/{id}', 'details')->name('details.list');
        Route::get('profile/{id}', 'profile')->name('profile');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('edit/{id}', 'update')->name('edit');
        Route::get('status/{id}', 'status')->name('status.edit');
        Route::get('delete/{id}', 'delete')->name('delete');
    });
    Route::controller(DmOparetionalAreaController::class)->prefix('operational-area')->name('lam_area.')->group(function () {
        Route::get('index', 'index')->name('list');
        Route::get('details/{id}', 'details')->name('details.list');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('create');
        Route::get('edit/{slug}', 'edit')->name('edit');
        Route::put('edit/{id}', 'update')->name('edit');
    });
});


// LAM Auth Routes
Route::group(['middleware' => 'lam', 'as' => 'lam.', 'prefix' => 'local-area-manager'], function () {
    Route::get('/dashboard', [LamDashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(LamKycVerificationController::class)->prefix('kyc')->name('kyc.')->group(function () {
        Route::post('/store', 'kyc_store')->name('store');
        Route::get('/verification', 'kyc_verification')->name('verification');
        Route::post('/kyc/file/upload', 'file_upload')->name('file.upload');
        Route::get('/kyc/file/delete', 'delete')->name('file.delete');
    });

    Route::controller(LamProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::put('/update/password', 'updatePassword')->name('update.password');
        Route::post('/update/image', 'updateImage')->name('update.image');
    });

    Route::controller(LamOperationalAreaController::class)->prefix('operational-area')->name('operational_area.')->group(function () {
        Route::get('index', 'index')->name('list');
    });



    Route::controller(LamUserController::class)->prefix('user-management')->name('user.')->group(function () {
        Route::get('index', 'index')->name('list');
        Route::get('details/{id}', 'details')->name('details.list');
        Route::get('profile/{id}', 'profile')->name('profile');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('edit/{id}', 'update')->name('edit');
        Route::get('status/{id}', 'status')->name('status.edit');
        Route::get('delete/{id}', 'delete')->name('delete');
    });


});
// Rider Auth Routes
Route::group(['middleware' => 'rider', 'as' => 'rider.', 'prefix' => 'rider'], function () {
    Route::get('/dashboard', [RiderDashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(RiderKycVerificationController::class)->prefix('kyc')->name('kyc.')->group(function () {
        Route::post('/store', 'kyc_store')->name('store');
        Route::get('/verification', 'kyc_verification')->name('verification');
        Route::post('/kyc/file/upload', 'file_upload')->name('file.upload');
        Route::get('/kyc/file/delete', 'delete')->name('file.delete');
    });
    Route::controller(RiderOrderManagementController::class)->prefix('order-management')->name('order_management.')->group(function () {
        Route::get('/{status}', 'index')->name('index');
        Route::get('/details/{dor_id}', 'details')->name('details');
        Route::post('/pharmacy/otp-verify', 'pOtpVerify')->name('pharmacy.otp_verify');
        Route::post('/customer/otp-verify/{od_id}', 'cOtpVerify')->name('customer.otp_verify');
        Route::post('/dispute/{od_id}', 'dispute')->name('dispute');
    });

    Route::controller(RiderProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::put('/update/password', 'updatePassword')->name('update.password');
        Route::post('/update/image', 'updateImage')->name('update.image');

        Route::get('/get-operation-sub-area/{oa_id}', 'get_osa')->name('get_osa');
    });
});



// User Routes
Route::group(['middleware' => ['auth','user_phone_verify'], 'prefix' => 'user'], function () {
    Route::get('/profile', [UserProfileController::class, 'profile'])->name('user.profile');
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');

    // Add To Cart Routes
    Route::get('/add-to-cart', [FrontendBaseController::class, 'add_to_cart'])->name('product.add_to_cart');
    Route::get('/remove-to-cart', [FrontendBaseController::class, 'remove_to_cart'])->name('product.remove_to_cart');
    Route::get('/clear-cart/{uid}', [FrontendBaseController::class, 'clearCart'])->name('product.clear_cart');

    Route::get('/item/check/{id}', [FrontendBaseController::class, 'itemCheck'])->name('cart.item.check');
    Route::get('/item/quantity/{id}/{type}', [FrontendBaseController::class, 'itemQuantity'])->name('cart.item.quantity');
    Route::get('/item/unit/{unit_id}/{cart_id}', [FrontendBaseController::class, 'itemUnit'])->name('cart.item.unit');

    // Checkout Routes
    Route::post('/product/single-order', [CheckoutController::class, 'single_order'])->name('product.single_order');
    Route::get('/order/intermediate/{multiple?}', [CheckoutController::class, 'int_order'])->name('product.int');
    Route::get('/product/checkout/{order_id}', [CheckoutController::class, 'checkout'])->name('product.checkout');
    Route::post('/product/order/confirm/{order_id}', [CheckoutController::class, 'order_confirm'])->name('product.order.confirm');
    Route::get('/product/order/success/{order_id}', [CheckoutController::class, 'order_success'])->name('product.order.success');
    Route::get('/product/order/failed/{order_id}', [CheckoutController::class, 'order_failed'])->name('product.order.failed');
    Route::get('/product/order/cancel/{order_id}', [CheckoutController::class, 'order_cancel'])->name('product.order.cancel');

    Route::controller(CheckoutController::class)->prefix('checkout')->name('u.ck.')->group(function () {
        Route::get('/address/{id}', 'address')->name('address');
    });

    //Address
    Route::controller(UserAddressController::class)->prefix('address')->name('u.as.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::post('store', 'store')->name('store');
        Route::get('details/{id}', 'details')->name('details');
        Route::put('update', 'update')->name('update');

        Route::get('delete/{id}', 'delete')->name('delete');
    });
});

// Frontend Routes
Route::get('/', [HomePageController::class, 'home'])->name('home');
Route::get('/product-search/{search_value}/{category}', [HomePageController::class, 'productSearch'])->name('home.product.search');
Route::get('/featured-products/{id?}', [HomePageController::class, 'updateFeaturedProducts'])->name('home.featured_products');

Route::get('/product-details/{slug}', [SingleProductController::class, 'singleProduct'])->name('product.single_product');
Route::get('/products', [ProductPageController::class, 'products'])->name('category.products');

