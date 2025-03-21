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
use App\Http\Controllers\Admin\DocumentationController;
use App\Http\Controllers\Admin\LAM_Management\LamKycController;
use App\Http\Controllers\Admin\LAM_Management\LamKycSettingsController;
use App\Http\Controllers\Admin\LAM_Management\LocalAreaManagerController;
use App\Http\Controllers\Admin\User\LatestOfferController;
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
use App\Http\Controllers\Admin\OrderByPrescription\OrderByPrescriptionController as AdminOrderByPrescriptionController;
use App\Http\Controllers\Admin\User\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\VoucherManagement\VoucherController as AdminVoucherController;
use App\Http\Controllers\Admin\Delivery\ZonesController as AdminDeliveryZonesController;

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

use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController as UserForgotPasswordController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PaymentGateway\SslCommerzController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\AddressController as UserAddressController;
use App\Http\Controllers\User\CartAjaxController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\WishlistController as UserWishlistController;
use App\Http\Controllers\User\ReviewController as UserReviewController;
use App\Http\Controllers\User\OrderByPrescriptionController as UserOrderByPrescriptionController;

use App\Http\Controllers\Frontend\AboutPageController;
use App\Http\Controllers\Frontend\ContactPageController;
use App\Http\Controllers\Frontend\DataDeletionController;
use App\Http\Controllers\Frontend\FaqPageController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\Product\SingleProductController;
use App\Http\Controllers\Frontend\Product\ProductPageController;
use App\Http\Controllers\Frontend\ProductSearchController;
use App\Http\Controllers\Frontend\PrivacyPolicyPageController;
use App\Http\Controllers\Frontend\TermsAndConditionsPageController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Pharmacy\FeedbackController as PharmacyFeedbackController;
use App\Http\Controllers\User\FeedbackController as UserFeedbackController;
use App\Http\Controllers\DM\FeedbackController as DmFeedbackController;
use App\Http\Controllers\LAM\FeedbackController as LamFeedbackController;
use App\Http\Controllers\Rider\FeedbackController as RiderFeedbackController;
use App\Http\Controllers\Admin\Feedback\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\HubManagement\HubController;
use App\Http\Controllers\Admin\HubManagement\HubStaffController;
use App\Http\Controllers\Admin\MapboxSettingsController;
use App\Http\Controllers\Admin\PaymentClearanceController;
use App\Http\Controllers\Admin\ProductManagement\MedicineDosesController;
use App\Http\Controllers\Admin\Support\TicketController as SupportTicketController;
use App\Http\Controllers\Admin\User\TipsController;
use App\Http\Controllers\Admin\WithdrawMethodController as AdminWithdrawMethodController;
use App\Http\Controllers\Admin\WithdrawController as AdminWithdrawController;
use App\Http\Controllers\DM\EarningController as DmEarningController;
use App\Http\Controllers\DM\WithdrawMethodController as DmWithdrawMethodController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LAM\EarningContorller as LamEarningContorller;
use App\Http\Controllers\LAM\WithdrawMethodController as LamWithdrawMethodController;
use App\Http\Controllers\Pharmacy\Auth\EmailVerificationController as PharmacyEmailVerificationController;
use App\Http\Controllers\Pharmacy\EarningController as PharmacyEarningController;
use App\Http\Controllers\Pharmacy\WithdrawMethodController as PharmacyWithdrawMethodController;
use App\Http\Controllers\Rider\EarningController as RiderEarningController;
use App\Http\Controllers\Rider\OperationalAreaController as RiderOperationalAreaController;
use App\Http\Controllers\Rider\WithdrawMethodController as RiderWithdrawMethodController;
use App\Http\Controllers\Hub\Auth\LoginController as StaffLoginController;
use App\Http\Controllers\Hub\DashboardController as HubDashboardController;
use App\Http\Controllers\Hub\Order\OrderManagementController as HubOrderManagementController;
use App\Http\Controllers\User\KYC\KycVerificationController as UserKycVerificationController;
use App\Http\Controllers\User\NotificationController as UserNotificationController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use Illuminate\Support\Facades\Broadcast;

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


Broadcast::routes();

Route::controller(CartAjaxController::class)->prefix('cart')->middleware('auth:web')->name('cart.')->group(function () {
    Route::post('add', 'add')->name('add');
    Route::get('products', 'products')->name('products');
    Route::post('update', 'update')->name('update');
    Route::post('delete', 'delete')->name('delete');
});

Auth::routes();
//File pond file upload
Route::controller(FileUploadController::class)->prefix('file-upload')->name('file.')->group(function () {
    Route::post('/uploads', 'uploads')->name('upload');
    Route::delete('/delete-temp-file', 'deleteTempFile')->name('delete');
    Route::post('/reset', 'resetFilePond')->name('reset');
    Route::post('/content-image/upload', 'content_image_upload')->name('ci_upload');
});

// Admin Login Routes
Route::controller(AdminLoginController::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', 'adminLogin')->name('login');
    Route::post('/login', 'adminLoginCheck')->name('login');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot/sent-otp', 'send_otp')->name('forgot.send_otp');
    Route::get('/forgot/verify-otp/{admin_id}', 'otp')->name('otp.verify');
    Route::post('/forgot/verify-otp/{admin_id}', 'verify')->name('otp.verify');
    Route::get('/password/reset/{admin_id}', 'resetPassword')->name('reset.password');
    Route::post('/password/reset/{admin_id}', 'resetPasswordStore')->name('reset.password');
});

// Staff Login Routes
Route::controller(StaffLoginController::class)->prefix('hub')->name('staff.')->group(function () {
    Route::get('/login', 'staffLogin')->name('login');
    Route::post('/login', 'staffLoginCheck')->name('login');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot/sent-otp', 'send_otp')->name('forgot.send_otp');
    Route::get('/forgot/verify-otp/{staff_id}', 'otp')->name('otp.verify');
    Route::post('/forgot/verify-otp/{staff_id}', 'verify')->name('otp.verify');
    Route::get('/password/reset/{staff_id}', 'resetPassword')->name('reset.password');
    Route::post('/password/reset/{staff_id}', 'resetPasswordStore')->name('reset.password');
});




// Pharmacy Login Routes
Route::controller(PharmacyLoginController::class)->prefix('pharmacy')->name('pharmacy.')->group(function () {
    Route::get('/login', 'pharmacyLogin')->name('login');
    Route::post('/login', 'pharmacyLoginCheck')->name('login');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot/sent-otp', 'send_otp')->name('forgot.send_otp');
    Route::get('/forgot/verify-otp/{pid}', 'otp')->name('otp.verify');
    Route::post('/forgot/verify-otp/{pid}', 'verify')->name('otp.verify');
    Route::get('/password/reset/{pid}', 'resetPassword')->name('reset.password');
    Route::post('/password/reset/{pid}', 'resetPasswordStore')->name('reset.password');
});



// DM Login Routes
Route::controller(DmLoginController::class)->prefix('district-manager')->name('district_manager.')->group(function () {
    Route::get('/login', 'dmLogin')->name('login');
    Route::post('/login', 'dmLoginCheck')->name('login');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/phone-verify-notice', 'phoneVerifyNotice')->name('phone.verify.notice');
    Route::get('/phone-verify/{id}', 'phoneVerify')->name('phone.verify');

    Route::get('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot/sent-otp', 'send_otp')->name('forgot.send_otp');
    Route::get('/forgot/verify-otp/{id}', 'otp')->name('otp.verify');
    Route::post('/forgot/verify-otp/{id}', 'verify')->name('otp.verify');
    Route::get('/password/reset/{id}', 'resetPassword')->name('reset.password');
    Route::post('/password/reset/{id}', 'resetPasswordStore')->name('reset.password');
});

// LAM Login Routes
Route::controller(LamLoginController::class)->prefix('local-area-manager')->name('local_area_manager.')->group(function () {
    Route::get('/login', 'lamLogin')->name('login');
    Route::post('/login', 'lamLoginCheck')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/register', 'lamRegister')->name('register');
    Route::get('/reference/{id}', 'reference')->name('reference');

    Route::get('/phone-verify-notice', 'phoneVerifyNotice')->name('phone.verify.notice');
    Route::get('/phone-verify/{id}', 'phoneVerify')->name('phone.verify');

    Route::get('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot/sent-otp', 'send_otp')->name('forgot.send_otp');
    Route::get('/forgot/verify-otp/{id}', 'otp')->name('otp.verify');
    Route::post('/forgot/verify-otp/{id}', 'verify')->name('otp.verify');
    Route::get('/password/reset/{id}', 'resetPassword')->name('reset.password');
    Route::post('/password/reset/{id}', 'resetPasswordStore')->name('reset.password');
});


// Rider Login Routes
Route::controller(RiderLoginController::class)->prefix('rider')->name('rider.')->group(function () {
    Route::get('/login', 'riderLogin')->name('login');
    Route::post('/login', 'riderLoginCheck')->name('login');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot/sent-otp', 'send_otp')->name('forgot.send_otp');
    Route::get('/forgot/verify-otp/{rider_id}', 'otp')->name('otp.verify');
    Route::post('/forgot/verify-otp/{rider_id}', 'verify')->name('otp.verify');
    Route::get('/password/reset/{rider_id}', 'resetPassword')->name('reset.password');
    Route::post('/password/reset/{rider_id}', 'resetPasswordStore')->name('reset.password');
});



// Google Login
Route::get('/google-redirect', [UserLoginController::class, 'googleRedirect'])->name('google.redirect');
Route::get('/auth/google/callback', [UserLoginController::class, 'googleCallback'])->name('google.callback');


// Facebook Login
Route::get('/facebook-redirect', [UserLoginController::class, 'facebookRedirect'])->name('fb.redirect');
Route::get('/auth/facebook/callback', [UserLoginController::class, 'facebookCallback'])->name('fb.callback');
Route::post('/facebook/user-deletion', [UserLoginController::class, 'fb_delete'])->name('fb.deletion');

// Overwrite Default Authentication Routes
Route::controller(UserLoginController::class)->prefix('user')->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/otp-verify', 'send_otp')->name('use.send_otp');
    Route::get('/otp/{user_id}', 'otp')->name('use.otp');


    // Route::get('/otp-verify', 'verify')->name('use.send_otp');
    Route::get('/send-otp/again/{user_id}', 'send_otp_again')->name('use.send_otp.again');
    Route::post('/otp/verify', 'otp_verify')->name('use.otp.verify');
});

// Route::controller(UserRegisterController::class)->prefix('user')->group(function () {

//     Route::get('/registration', 'register')->name('use.register');
//     Route::post('/registration', 'rStore')->name('use.register');
//     Route::get('/register/phone/validation/{phone}', 'phoneValidation')->name('use.register.phone.validation');
// });

Route::controller(UserForgotPasswordController::class)->prefix('user')->group(function () {
    Route::get('/password/forgot', 'forgotPassword')->name('user.forgot.password');
    Route::post('/password/forgot', 'forgotPasswordOtp')->name('user.forgot.password');
    Route::get('/reset/password/{user_id}', 'resetPassword')->name('user.reset.password');
    Route::post('/reset/password/{user_id}', 'resetPasswordStore')->name('user.reset.password');
});
//Admin Auth Routes
Route::group(['middleware' => ['auth:admin', 'permission'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/chart-update', [DashboardController::class, 'chartUpdate'])->name('admin.chart.update');

    // Documentaiton Routes
    Route::controller(DocumentationController::class)->prefix('documentation')->name('doc.')->group(function () {
        Route::get('index', 'index')->name('doc_list');
        Route::get('details/{id}', 'details')->name('details.doc_list');
        Route::get('create', 'create')->name('doc_create');
        Route::post('create', 'store')->name('doc_create');
        Route::get('edit/{id}', 'edit')->name('doc_edit');
        Route::put('edit/{id}', 'update')->name('doc_edit');
        Route::get('delete/{id}', 'delete')->name('doc_delete');
    });



    // Admin Management Routes
    Route::group(['as' => 'am.', 'prefix' => 'admin-management'], function () {
        Route::controller(AdminController::class)->prefix('admin')->name('admin.')->group(function () {
            Route::get('index', 'index')->name('admin_list');
            Route::get('details/{id}', 'details')->name('details.admin_list');
            Route::get('profile/{id}', 'profile')->name('admin_profile');
            Route::put('profile/update', 'u_profile')->name('update.admin_profile');
            Route::put('profile/password/update', 'profile_pu')->name('pupdate.admin_profile');
            Route::post('profile/image/update', 'profile_imgupdate')->name('imgupdate.admin_profile');
            Route::get('profile/download/{file_url}', 'view_or_download')->name('download.admin_profile');
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
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.user_profile');
            Route::get('profile/{id}', 'profile')->name('user_profile');
            Route::get('profile/download/{file_url}', 'view_or_download')->name('download.user_profile');
            Route::get('create', 'create')->name('user_create');
            Route::post('create', 'store')->name('user_create');
            Route::get('edit/{id}', 'edit')->name('user_edit');
            Route::put('edit/{id}', 'update')->name('user_edit');
            Route::get('status/{id}', 'status')->name('status.user_edit');
            Route::get('delete/{id}', 'delete')->name('user_delete');
        });
        // KYC ROUTES
        Route::group(['as' => 'user_kyc.', 'prefix' => 'user-kyc'], function () {
            Route::controller(UserKycController::class)->prefix('submitted-kyc')->name('submitted_kyc.')->group(function () {
                Route::get('index', 'index')->name('us_kyc_list');
                Route::get('details/{id}', 'details')->name('us_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.us_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.us_kyc_status');
                Route::put('declined/{id}', 'declined')->name('declined.us_kyc_status');
                Route::get('delete/{id}', 'delete')->name('us_kyc_delete');
            });
            Route::controller(UserKycSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
                Route::get('/create', 'create')->name('u_kyc_create');
                Route::post('/create', 'store')->name('u_kyc_create');
                Route::get('/details/{id}', 'details')->name('u_kyc_details');
                // Route::get('/status/{id}', 'status')->name('u_kyc_status');
            });
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
            Route::get('file-download/{url}', 'view_or_download')->name('download.pharmacy_list');
        });

        // KYC ROUTES
        Route::group(['as' => 'pharmacy_kyc.', 'prefix' => 'pharmacy-kyc'], function () {
            Route::controller(PharmacyKycController::class)->prefix('submitted-kyc')->name('submitted_kyc.')->group(function () {
                Route::get('index', 'index')->name('ps_kyc_list');
                Route::get('details/{id}', 'details')->name('ps_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.ps_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.ps_kyc_status');
                Route::put('declined/{id}', 'declined')->name('declined.ps_kyc_status');
                Route::get('delete/{id}', 'delete')->name('ps_kyc_delete');
            });
            Route::controller(PharmacyKycSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
                Route::get('/create', 'create')->name('p_kyc_create');
                Route::post('/create', 'store')->name('p_kyc_create');
                Route::get('/details/{id}', 'details')->name('p_kyc_details');
                // Route::get('/status/{id}', 'status')->name('p_kyc_status');
            });
        });
    });

    // Admin Hub Management Routes
    Route::group(['as' => 'hm.', 'prefix' => 'hub-management'], function () {

        Route::controller(HubController::class)->prefix('hub')->name('hub.')->group(function () {
            Route::get('index', 'index')->name('hub_list');
            Route::get('details/{id}', 'details')->name('details.hub_list');
            Route::get('create', 'create')->name('hub_create');
            Route::post('create', 'store')->name('hub_create');
            Route::get('edit/{id}', 'edit')->name('hub_edit');
            Route::put('edit/{id}', 'update')->name('hub_edit');
            Route::get('status/{id}', 'status')->name('status.hub_edit');
            Route::get('delete/{id}', 'delete')->name('hub_delete');
        });

        Route::controller(HubStaffController::class)->prefix('hub-staff')->name('hub_staff.')->group(function () {
            Route::get('index', 'index')->name('hub_staff_list');
            Route::get('details/{id}', 'details')->name('details.hub_staff_list');
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.hub_staff_profile');
            Route::get('profile/{id}', 'profile')->name('hub_staff_profile');
            Route::get('create', 'create')->name('hub_staff_create');
            Route::post('create', 'store')->name('hub_staff_create');
            Route::get('edit/{id}', 'edit')->name('hub_staff_edit');
            Route::put('edit/{id}', 'update')->name('hub_staff_edit');
            Route::get('status/{id}', 'status')->name('status.hub_staff_edit');
            Route::get('delete/{id}', 'delete')->name('hub_staff_delete');
        });
    });
    //Admin Operational Area Management Routes
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
            Route::get('profile/{id}', 'profile')->name('district_manager_profile');
            Route::get('file/download/{url}', 'view_or_download')->name('download.district_manager_profile');
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
            Route::controller(DmKycController::class)->prefix('submitted-kyc')->name('submitted_kyc.')->group(function () {
                Route::get('index', 'index')->name('dms_kyc_list');
                Route::get('details/{id}', 'details')->name('dms_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.dms_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.dms_kyc_status');
                Route::put('declined/{id}', 'declined')->name('declined.dms_kyc_status');
                Route::get('delete/{id}', 'delete')->name('dms_kyc_delete');
            });
            Route::controller(DmKycSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
                Route::get('/create', 'create')->name('dm_kyc_create');
                Route::post('/create', 'store')->name('dm_kyc_create');
                Route::get('/details/{id}', 'details')->name('dm_kyc_details');
                // Route::get('/status/{id}', 'status')->name('dm_kyc_status');
            });
        });
    });
    //Admin Local Area Manager Management Routes
    Route::group(['as' => 'lam_management.', 'prefix' => 'lam-management'], function () {
        Route::controller(LocalAreaManagerController::class)->prefix('local-area-manager')->name('local_area_manager.')->group(function () {
            Route::get('index', 'index')->name('local_area_manager_list');
            Route::get('details/{id}', 'details')->name('details.local_area_manager_list');
            Route::get('profile/{id}', 'profile')->name('local_area_manager_profile');
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.local_area_manager_profile');
            Route::get('file/download/{url}', 'view_or_download')->name('download.local_area_manager_profile');
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
            Route::controller(LamKycController::class)->prefix('submitted-kyc')->name('submitted_kyc.')->group(function () {
                Route::get('index', 'index')->name('lams_kyc_list');
                Route::get('details/{id}', 'details')->name('lams_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.lams_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.lams_kyc_status');
                Route::put('declined/{id}', 'declined')->name('declined.lams_kyc_status');
                Route::get('delete/{id}', 'delete')->name('lams_kyc_delete');
            });
            Route::controller(LamKycSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
                Route::get('/create', 'create')->name('lam_kyc_create');
                Route::post('/create', 'store')->name('lam_kyc_create');
                Route::get('/details/{id}', 'details')->name('lam_kyc_details');
                // Route::get('/status/{id}', 'status')->name('lam_kyc_status');
            });
        });
    });

    //Admin Rider Management Routes
    Route::group(['as' => 'rm.', 'prefix' => 'rider-management'], function () {
        Route::controller(RiderManagementController::class)->prefix('rider')->name('rider.')->group(function () {
            Route::get('index', 'index')->name('rider_list');
            Route::get('details/{id}', 'details')->name('details.rider_list');
            Route::get('profile/{id}', 'profile')->name('rider_profile');
            Route::get('dashboard/{id}', 'loginAs')->name('login_as.rider_profile');
            Route::get('file/download/{url}', 'view_or_download')->name('download.rider_profile');
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
            Route::controller(RiderKycController::class)->prefix('submitted-kyc')->name('submitted_kyc.')->group(function () {
                Route::get('index', 'index')->name('rs_kyc_list');
                Route::get('details/{id}', 'details')->name('rs_kyc_details');
                Route::get('file-download/{url}', 'view_or_download')->name('download.rs_kyc_details');
                Route::get('accept/{id}', 'accept')->name('accept.rs_kyc_status');
                Route::put('declined/{id}', 'declined')->name('declined.rs_kyc_status');
                Route::get('delete/{id}', 'delete')->name('rs_kyc_delete');
            });
            Route::controller(RiderKycSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
                Route::get('/create', 'create')->name('r_kyc_create');
                Route::post('/create', 'store')->name('r_kyc_create');
                Route::get('/details/{id}', 'details')->name('r_kyc_details');
                // Route::get('/status/{id}', 'status')->name('r_kyc_status');
            });
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
            Route::get('search', 'search')->name('search.generic_name_list'); //ajax search route
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
            Route::get('/search', 'search')->name('search.company_name_list'); //ajax search route
        });
        //Not used
        // Route::controller(MedicineCategoryController::class)->prefix('medicine-category')->name('medicine_category.')->group(function () {
        //     Route::get('index', 'index')->name('medicine_category_list');
        //     Route::get('details/{slug}', 'details')->name('details.medicine_category_list');
        //     Route::get('create', 'create')->name('medicine_category_create');
        //     Route::post('create', 'store')->name('medicine_category_create');
        //     Route::get('edit/{slug}', 'edit')->name('medicine_category_edit');
        //     Route::put('edit/{id}', 'update')->name('medicine_category_edit');
        //     Route::get('status/{id}', 'status')->name('status.medicine_category_edit');
        //     Route::get('featured/{id}', 'featured')->name('featured.medicine_category_edit');
        //     Route::get('delete/{id}', 'delete')->name('medicine_category_delete');
        // });

        Route::controller(MedicineUnitController::class)->prefix('medicine-unit')->name('medicine_unit.')->group(function () {
            Route::get('index', 'index')->name('medicine_unit_list');
            Route::get('details/{id}', 'details')->name('details.medicine_unit_list');
            Route::get('create', 'create')->name('medicine_unit_create');
            Route::post('create', 'store')->name('medicine_unit_create');
            Route::get('edit/{id}', 'edit')->name('medicine_unit_edit');
            Route::put('edit/{id}', 'update')->name('medicine_unit_edit');
            Route::get('status/{id}', 'status')->name('status.medicine_unit_edit');
            Route::get('delete/{id}', 'delete')->name('medicine_unit_delete');
            Route::get('search', 'search')->name('search.medicine_unit_list'); //ajax search route
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
        Route::controller(MedicineDosesController::class)->prefix('medicine-dose')->name('medicine_dose.')->group(function () {
            Route::get('index', 'index')->name('medicine_dose_list');
            Route::get('details/{id}', 'details')->name('details.medicine_dose_list');
            Route::get('create', 'create')->name('medicine_dose_create');
            Route::post('create', 'store')->name('medicine_dose_create');
            Route::get('edit/{slug}', 'edit')->name('medicine_dose_edit');
            Route::put('edit/{id}', 'update')->name('medicine_dose_edit');
            Route::get('status/{id}', 'status')->name('status.medicine_dose_edit');
            Route::get('delete/{id}', 'delete')->name('medicine_dose_delete');
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
            Route::get('/search', 'search')->name('search.product_category_list'); //ajax search route
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
            Route::get('search', 'search')->name('search.product_sub_category_list'); //ajax search route
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
            Route::get('bulk-entry', 'bulkEntry')->name('index.bulk_entry');
            Route::post('bulk-import', 'bulkImport')->name('store.bulk_entry');
            Route::get('sub-cat/{id}', 'get_sub_cat')->name('sub_cat.medicine_list');
        });
    });

    // Voucher Management

    Route::group(['as' => 'vm.', 'prefix' => 'voucher-management'], function () {
        Route::controller(AdminVoucherController::class)->prefix('vouchers')->name('vouchers.')->group(function () {
            Route::get('index', 'index')->name('voucher_list');
            Route::get('create', 'create')->name('voucher_create');
            Route::post('create', 'store')->name('voucher_create');
            Route::get('edit/{id}', 'edit')->name('voucher_edit');
            Route::put('edit/{id}', 'update')->name('voucher_edit');
            Route::get('status/{id}', 'status')->name('status.voucher_edit');
            Route::get('delete/{id}', 'delete')->name('voucher_delete');
            Route::get('details/{id}', 'details')->name('details.voucher_list');
        });
    });

    //Delivery zones
    Route::group(['as' => 'delivery.', 'prefix' => 'delivery-management'], function () {
        Route::controller(AdminDeliveryZonesController::class)->prefix('zones')->name('zones.')->group(function () {
            Route::get('index', 'index')->name('delivery_zones_list');
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
            Route::post('/hub-assign', 'hubAssign')->name('hub_assign');





            Route::get('/order-distribution/{id}', 'order_distribution')->name('order_distribution');
            Route::post('/order-distribution/{order_id}', 'order_distribution_store')->name('order_distribution');
            Route::get('/distribution/details/{do_id}', 'distribution_details')->name('details.order_distribution');
            Route::post('/distribution/assign-order/{do_id}', 'assign_order')->name('assign_order');
            Route::post('/distribution/dispute-update', 'disputeUpdate')->name('dispute_update');
        });
    });

    // Admin Distributed Order
    // Route::controller(DistributedOrderController::class)->prefix('distributed-order')->name('do.')->group(function () {
    //     Route::get('/{status}', 'index')->name('do_list');
    //     Route::get('/{status}/orders', 'dispute')->name('dispute.do_list');
    //     // Route::get('/details/{do_id}', 'details')->name('do_details');
    //     Route::get('/edit/{do_id}/{pid}', 'edit')->name('do_edit');
    //     Route::post('/update', 'update')->name('do_update');

    //     Route::post('/rider/{do_id}', 'do_rider')->name('do_rider');
    // });


    // Admin Payment Management
    Route::group(['as' => 'pym.', 'prefix' => 'payment-management'], function () {
        Route::controller(PaymentManagementController::class)->prefix('payment')->name('payment.')->group(function () {
            Route::get('/{status}', 'index')->name('payment_list');
            Route::get('/details/{id}', 'details')->name('payment_details');
        });
    });

    // Withdraw Method Request
    Route::controller(AdminWithdrawMethodController::class)->prefix('withdraw-method')->name('withdraw_method.')->group(function () {
        Route::get('/list/{status}', 'list')->name('wm_list');
        Route::get('/details/{id}', 'details')->name('wm_details');
        Route::get('/accept/{id}', 'accept')->name('wm_accept');
        Route::post('/declined/{id}', 'declined')->name('wm_declined');
    });
    // Withdraw Request
    Route::controller(AdminWithdrawController::class)->prefix('withdraw')->name('withdraw.')->group(function () {
        Route::get('/list/{status}', 'list')->name('w_list');
        Route::get('/details/{id}', 'details')->name('w_details');
        Route::get('/accept/{id}', 'accept')->name('w_accept');
        Route::post('/declined/{id}', 'declined')->name('w_declined');
    });
    // Payment Clearance
    Route::controller(PaymentClearanceController::class)->prefix('payment-clearance')->name('pc.')->group(function () {
        Route::get('/list/{status}', 'list')->name('pc_list');
        Route::get('/details/{id}', 'details')->name('pc_details');
        Route::get('/accept/{id}', 'accept')->name('pc_accept');
        Route::post('/declined/{id}', 'declined')->name('pc_declined');
    });
    // Site Settings
    Route::controller(SiteSettingsController::class)->prefix('site-settings')->name('settings.')->group(function () {
        Route::get('index', 'index')->name('site_settings');
        Route::post('update', 'store')->name('update.site_settings');
        Route::post('sms/update', 'sms_store')->name('update.sms.site_settings');
        Route::post('index', 'notification')->name('notification.site_settings');
        Route::get('email-template/edit/{id}', 'et_edit')->name('email_templates.site_settings');
        Route::put('email-template/edit/{id}', 'et_update')->name('email_templates.site_settings');
        Route::post('point-setting/update', 'ps_update')->name('ps_update');
    });
    Route::controller(MapboxSettingsController::class)->prefix('mapbox-settings')->name('mbx_settings.')->group(function () {
        Route::post('update', 'store')->name('update.site_settings');
    });

    // Order by Prescription
    Route::controller(AdminOrderByPrescriptionController::class)->prefix('order-by-prescrition')->name('obp.')->group(function () {
        Route::get('/list/{status}', 'list')->name('obp_list');
        Route::get('/details/{id}', 'details')->name('obp_details');
        // Route::get('/details/order/{order_id}', 'orderDetails')->name('order.obp_details');
        // Route::get('/get-unit/{mid}', 'getUnit')->name('get_unit.obp_details');
        // Route::get('/get-select-medicine', 'getSelectMedicine')->name('get_select_medicine.obp_details');
        // Route::post('/order/create/{up_id}', 'order_create')->name('obp_order_create');
        // Route::get('/status-update/{status}/{id}', 'statusUpdate')->name('status_update');
        Route::post('/store', 'store')->name('store.obp_details');
        Route::get('/product-search', 'productSearch')->name('search.obp_details');
        Route::get('/delivery-address/list', 'addressList')->name('delivery.list.obp_details');
        Route::post('/delivery-address/create', 'storeAddressDetails')->name('delivery.create.obp_details');
        Route::get('/cancel/{id}', 'cancel')->name('obp_cancel');
    });

    // Latest Offer
    Route::controller(LatestOfferController::class)->prefix('latest-offer')->name('latest_offer.')->group(function () {
        Route::get('index', 'index')->name('lf_list');
        Route::get('details/{id}', 'details')->name('details.lf_list');
        Route::get('create', 'create')->name('lf_create');
        Route::post('create', 'store')->name('lf_create');
        Route::get('edit/{id}', 'edit')->name('lf_edit');
        Route::put('edit/{id}', 'update')->name('lf_edit');
        Route::get('status/{id}', 'status')->name('status.lf_edit');
        Route::get('delete/{id}', 'delete')->name('lf_delete');
    });
    // User Tips
    Route::controller(TipsController::class)->prefix('user-tips')->name('user_tips.')->group(function () {
        Route::get('index', 'index')->name('tips_list');
        Route::get('details/{id}', 'details')->name('details.tips_list');
        Route::get('create', 'create')->name('tips_create');
        Route::post('create', 'store')->name('tips_create');
        Route::get('edit/{id}', 'edit')->name('tips_edit');
        Route::put('edit/{id}', 'update')->name('tips_edit');
        Route::get('status/{id}', 'status')->name('status.tips_edit');
        Route::get('delete/{id}', 'delete')->name('tips_delete');
    });

    // Feedback
    Route::controller(AdminFeedbackController::class)->prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/list', 'list')->name('fdk_list');
        Route::get('/details/{id}', 'details')->name('fdk_details');
        Route::get('file-download/{url}', 'view_or_download')->name('download.fdk_details');
    });
    // Review
    Route::controller(AdminReviewController::class)->prefix('review')->name('review.')->group(function () {
        Route::get('/products', 'products')->name('review_products');
        Route::get('/list/{slug}', 'list')->name('review_list');
        Route::get('/details/{id}', 'details')->name('details.review_list');
        Route::get('/edit/{id}', 'edit')->name('review_edit');
        Route::put('/edit/{id}', 'update')->name('review_edit');
        Route::get('/status/{id}', 'status')->name('status.review_edit');
        Route::get('/delete/{id}', 'delete')->name('review_delete');
    });


    // Support
    Route::controller(SupportTicketController::class)->prefix('ticket')->name('st.')->group(function () {
        Route::get('/support/ticket', 'index')->name('ticket_list');
        Route::get('/support/ticket/chat/{ticket_id}', 'chat')->name('ticket_chat');
        Route::post('/support/ticket/message/send/{ticket_id}', 'message_send')->name('message_send.ticket_chat');
    });
});


// KYC FILE DELETE
Route::get('/kyc/file/delete', [FileUploadController::class, 'kycFileDelete'])->name('kyc.file.delete');

// Pharmacy Auth Routes
Route::group(['middleware' => 'pharmacy', 'as' => 'pharmacy.', 'prefix' => 'pharmacy'], function () {
    Route::get('/profile', [PharmacyProfileController::class, 'profile'])->name('profile');
    Route::get('/dashboard', [PharmacyDashboardController::class, 'dashboard'])->name('dashboard');

    // KYC Notice
    Route::get('/kyc-notice', function () {
        return view('pharmacy.kyc_notice');
    })->name('kyc.notice');

    Route::controller(PharmacyKycVerificationController::class)->prefix('kyc')->name('kyc.')->group(function () {
        Route::post('/store', 'kyc_store')->name('store');
        Route::get('/verification', 'kyc_verification')->name('verification');
        Route::post('/file/upload', 'file_upload')->name('file.upload');
        // Route::get('/file/delete', 'delete')->name('file.delete');
    });

    Route::controller(PharmacyEmailVerificationController::class)->prefix('email')->name('email.')->group(function () {
        Route::get('/send-otp', 'send_otp')->name('send.otp');
        Route::post('/verification', 'verify')->name('verify');
    });

    Route::controller(PharmacyProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::post('/address/store', 'address')->name('address');
        Route::put('/update/password', 'updatePassword')->name('update.password');
        Route::post('/update/image', 'updateImage')->name('update.image');
        Route::get('file/download/{url}', 'view_or_download')->name('file.download');

        Route::get('/get-operation-sub-area/{oa_id}', 'get_osa')->name('get_osa');
    });

    Route::controller(PharmacyOrderManagementController::class)->prefix('order-management')->middleware('check_kyc:pharmacy')->name('order_management.')->group(function () {
        Route::get('/{status}', 'index')->name('index');
        Route::get('details/{od_id}/', 'details')->name('details');
        Route::post('update/{do_id}', 'update')->name('update');
        Route::post('verify-otp', 'verify')->name('verify');
    });


    Route::controller(PharmacyOperationalAreaController::class)->prefix('operational-area')->name('operational_area.')->group(function () {
        Route::get('index', 'index')->name('list');
    });

    //Pharmacy Feedback
    Route::controller(PharmacyFeedbackController::class)->prefix('feedback')->name('fdk.')->middleware('check_kyc:pharmacy')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
    //Pharmacy Earning
    Route::controller(PharmacyEarningController::class)->prefix('my-earning')->name('earning.')->middleware('check_kyc:pharmacy')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/report', 'report')->name('report');
        Route::get('/withdraw', 'withdraw')->name('withdraw');
        Route::post('/withdraw', 'withdrawConfirm')->name('withdraw');
    });

    //Pharmacy Withdraw Method
    Route::controller(PharmacyWithdrawMethodController::class)->prefix('withdraw-method')->name('wm.')->middleware('check_kyc:pharmacy')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/details/{id}', 'details')->name('details');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('create');
    });
});


// DM Auth Routes
Route::group(['middleware' => ['auth:dm', 'dm_phone_verify'], 'as' => 'dm.', 'prefix' => 'district-manager'], function () {

    Route::get('/dashboard', [DmDashboardController::class, 'dashboard'])->name('dashboard');

    // KYC Notice
    Route::get('/kyc-notice', function () {
        return view('district_manager.kyc_notice');
    })->name('kyc.notice');

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
        Route::post('/update/image', 'updateImage')->name('update.image');
        Route::get('file/download/{url}', 'view_or_download')->name('file.download');
    });

    //LAM Route
    Route::controller(LamManagementController::class)->prefix('lam-management')->middleware('check_kyc:dm')->name('lam.')->group(function () {
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
    Route::controller(DmUserController::class)->prefix('user-management')->middleware('check_kyc:dm')->name('user.')->group(function () {
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
        Route::group(['middleware' => 'check_kyc:dm'], function () {
            Route::get('details/{id}', 'details')->name('details.list');
            Route::get('create', 'create')->name('create');
            Route::post('create', 'store')->name('create');
            Route::get('edit/{slug}', 'edit')->name('edit');
            Route::put('edit/{id}', 'update')->name('edit');
        });
    });

    //DM Feedback
    Route::controller(DmFeedbackController::class)->prefix('feedback')->middleware('check_kyc:dm')->name('fdk.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
    //DM Earning
    Route::controller(DmEarningController::class)->prefix('my-earning')->middleware('check_kyc:dm')->name('earning.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/report', 'report')->name('report');
        Route::get('/withdraw', 'withdraw')->name('withdraw');
        Route::post('/withdraw', 'withdrawConfirm')->name('withdraw');
    });

    //DM Withdraw Method
    Route::controller(DmWithdrawMethodController::class)->prefix('withdraw-method')->middleware('check_kyc:dm')->name('wm.')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/details/{id}', 'details')->name('details');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('create');
    });
});


// LAM Auth Routes
Route::group(['middleware' => ['auth:lam', 'lam_phone_verify'], 'as' => 'lam.', 'prefix' => 'local-area-manager'], function () {
    Route::get('/dashboard', [LamDashboardController::class, 'dashboard'])->name('dashboard');

    // KYC Notice
    Route::get('/kyc-notice', function () {
        return view('local_area_manager.kyc_notice');
    })->name('kyc.notice');

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
        Route::get('file/download/{url}', 'view_or_download')->name('file.download');
    });

    Route::controller(LamOperationalAreaController::class)->prefix('operational-area')->name('operational_area.')->group(function () {
        Route::get('index', 'index')->name('list');
    });



    Route::controller(LamUserController::class)->prefix('user-management')->middleware('check_kyc:lam')->name('user.')->group(function () {
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
    //LAM Feedback
    Route::controller(LamFeedbackController::class)->prefix('feedback')->middleware('check_kyc:lam')->name('fdk.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
    //LAM Earning
    Route::controller(LamEarningContorller::class)->prefix('my-earning')->middleware('check_kyc:lam')->name('earning.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/report', 'report')->name('report');
        Route::get('/withdraw', 'withdraw')->name('withdraw');
        Route::post('/withdraw', 'withdrawConfirm')->name('withdraw');
    });
    //LAM Withdraw Method
    Route::controller(LamWithdrawMethodController::class)->prefix('withdraw-method')->middleware('check_kyc:lam')->name('wm.')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/details/{id}', 'details')->name('details');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('create');
    });
});
// Rider Auth Routes
Route::group(['middleware' => 'rider', 'as' => 'rider.', 'prefix' => 'rider'], function () {
    Route::get('/dashboard', [RiderDashboardController::class, 'dashboard'])->name('dashboard');

    // KYC Notice
    Route::get('/kyc-notice', function () {
        return view('rider.kyc_notice');
    })->name('kyc.notice');

    Route::controller(RiderKycVerificationController::class)->prefix('kyc')->name('kyc.')->group(function () {
        Route::post('/store', 'kyc_store')->name('store');
        Route::get('/verification', 'kyc_verification')->name('verification');
        Route::post('/kyc/file/upload', 'file_upload')->name('file.upload');
        Route::get('/kyc/file/delete', 'delete')->name('file.delete');
    });
    Route::controller(RiderOrderManagementController::class)->prefix('order-management')->middleware('check_kyc:rider')->name('order_management.')->group(function () {
        Route::get('/{status}', 'index')->name('index');
        Route::get('/details/{dor_id}', 'details')->name('details');
        Route::post('/pharmacy/otp-verify', 'pOtpVerify')->name('pharmacy.otp_verify');
        Route::post('/user/otp-verify', 'uOtpVerify')->name('user.otp_verify');
        // Route::post('/customer/otp-verify/{od_id}', 'cOtpVerify')->name('customer.otp_verify');
        // Route::post('/dispute/{od_id}', 'dispute')->name('dispute');



        Route::get('get/otp', 'get_otp')->name('get_otp');
    });

    Route::controller(RiderProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::put('/update/password', 'updatePassword')->name('update.password');
        Route::post('/update/image', 'updateImage')->name('update.image');
        Route::get('file/download/{url}', 'view_or_download')->name('file.download');

        Route::get('/get-operation-sub-area/{oa_id}', 'get_osa')->name('get_osa');
    });
    //Rider Feedback
    Route::controller(RiderFeedbackController::class)->prefix('feedback')->middleware('check_kyc:rider')->name('fdk.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });

    //Rider Earning
    Route::controller(RiderEarningController::class)->prefix('my-earning')->middleware('check_kyc:rider')->name('earning.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/report', 'report')->name('report');
        Route::get('/withdraw', 'withdraw')->name('withdraw');
        Route::post('/withdraw', 'withdrawConfirm')->name('withdraw');
    });
    //Rider Withdraw Method
    Route::controller(RiderWithdrawMethodController::class)->prefix('withdraw-method')->middleware('check_kyc:rider')->name('wm.')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/details/{id}', 'details')->name('details');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('create');
    });

    Route::controller(RiderOperationalAreaController::class)->prefix('operational-area')->name('operational_area.')->group(function () {
        Route::get('index', 'index')->name('list');
    });
});

//Order By Prescription Auth Check
Route::get('/order-by-prescrition/check-auth', [UserOrderByPrescriptionController::class, 'check_auth'])->name('u.obp.check.auth');


// User Auth Routes
Route::group(['middleware' => ['auth', 'user_phone_verify'], 'prefix' => 'customer'], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');

    // KYC Notice
    Route::get('/kyc-notice', function () {
        return view('user.kyc_notice');
    })->name('web.kyc.notice');


    // Profile Routes
    Route::controller(UserProfileController::class)->prefix('profile')->name('u.profile.')->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::put('/update/password', 'updatePassword')->name('update.password');
        Route::post('/update/image', 'updateImage')->name('update.img');
        Route::get('file/download/{url}', 'view_or_download')->name('file.download');
    });

    // KYC Verification Center Routes
    Route::controller(UserKycVerificationController::class)->prefix('kyc')->name('u.kyc.')->group(function () {
        Route::post('/store', 'kyc_store')->name('store');
        Route::get('/verification', 'kyc_verification')->name('verification');
        Route::post('/file/upload', 'file_upload')->name('file.upload');
        // Route::get('/file/delete', 'delete')->name('file.delete');
    });

    Route::controller(CheckoutController::class)->prefix('checkout')->name('u.ck.')->group(function () {
        Route::post('init', 'int_order')->name('init');
        Route::post('single-order', 'single_order')->name('single');
        Route::get('order/{o_id}', 'checkout')->name('index');
        Route::get('address/{id}', 'address')->name('address');
        Route::post('order-confirm', 'confirm_order')->name('product.order.confirm');
        Route::post('voucher/check', 'voucher_check')->name('voucher.check');
    });

    Route::controller(UserPaymentController::class)->prefix('payment')->name('u.payment.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('details/{id}', 'details')->name('details');

        Route::get('/intermediate/{payment_id}', 'int_payment')->name('int');
        Route::get('/success/{payment_id}', 'success')->name('payment_success');
        Route::get('/failed/{payment_id}', 'failed')->name('payment_failed');
        Route::get('/cancel/{payment_id}', 'cancel')->name('payment_cancel');
    });


    //Order By Prescriptios

    //Address
    Route::controller(UserAddressController::class)->prefix('address')->name('u.as.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::post('store', 'store')->name('store');
        Route::get('details/{id}', 'details')->name('details');
        Route::put('update', 'update')->name('update');
        Route::get('delete/{id}', 'delete')->name('delete');
        Route::get('cities', 'cities')->name('cities');
    });
    //User Feedback
    Route::controller(UserFeedbackController::class)->prefix('feedback')->name('u.fdk.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
    Route::controller(UserOrderController::class)->prefix('order')->name('u.order.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('details/{id}', 'details')->name('details');
        Route::get('cancel/{id}', 'cancel')->name('cancel');
        Route::post('pay-now', 'pay_now')->name('pay');
        Route::get('summary', 'getOrderSummary')->name('summary');
        Route::get('re-order/{order_id}', 're_order')->name('reorder');
    });

    Route::controller(UserWishlistController::class)->prefix('wishlist')->name('u.wishlist.')->group(function () {
        Route::get('/update/{pid}', 'update')->name('update');
        Route::get('/refresh', 'refresh')->name('refresh');
        Route::get('/list', 'list')->name('list');
    });
    Route::controller(UserReviewController::class)->prefix('review')->name('u.review.')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::post('/store', 'store')->name('store');
    });

    Route::controller(UserNotificationController::class)->prefix('notification')->name('u.notification.')->group(function () {
        Route::get('/read-all', 'read_all')->name('read_all');
    });


    // // Live Chat
    // Route::controller(UserTicketController::class)->prefix('ticket')->name('u.ticket.')->group(function () {
    //     Route::post('/create', 'create')->name('create');
    //     Route::get('/messages/{ticket_id}', 'messages')->name('messages');
    //     Route::post('message/send', 'message_send')->name('message.send');
    // });
});

Route::group(['middleware' => ['auth:staff', 'permission'], 'prefix' => 'hub'], function () {
    Route::get('/dashboard', [HubDashboardController::class, 'dashboard'])->name('hub.dashboard');

    Route::controller(HubOrderManagementController::class)->prefix('orders')->name('hub.order.')->group(function () {
        Route::get('status/{status}', 'list')->name('list');
        Route::get('details/{id}', 'details')->name('details');
        Route::get('collecting/{id}', 'collecting')->name('collecting');
        Route::post('collected', 'collected')->name('collected');
        Route::post('prepared', 'prepared')->name('prepared');
        Route::get('print/{order}', 'print')->name('print');
    });
});














// Guest Live Chat
// Live Chat
Route::controller(TicketController::class)->prefix('ticket')->name('ticket.')->group(function () {
    Route::post('/create', 'create')->name('create');
    Route::get('/messages', 'messages')->name('messages');
    Route::post('message/send', 'message_send')->name('message.send');
});

Route::controller(SslCommerzController::class)->prefix('payment')->name('u.payment.')->group(function () {
    // Route::get('/example1', 'exampleEasyCheckout')->name('checkout1');
    // Route::get('/example2', 'exampleHostedCheckout')->name('checkout2');
    Route::get('/ssl/{order_id}', 'index')->name('index');
    // Route::post('/pay-via-ajax', 'payViaAjax')->name('index_ajax');
    Route::post('/success', 'success')->name('success');
    Route::post('/fail', 'fail')->name('failed');
    Route::post('/cancel', 'cancel')->name('cancel');
    Route::post('/ipn', 'ipn')->name('ipn');
});

// Frontend Routes

Route::controller(HomePageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/featured-products/{id?}', 'updateFeaturedProducts')->name('home.featured_products');
    Route::post('/switch-language', 'switchLanguage')->name('language.switch');
});

Route::get('/product-search/{search_value}/{category}', [ProductSearchController::class, 'productSearch'])->name('home.product.search');
Route::get('/product-details/{slug}', [SingleProductController::class, 'singleProduct'])->name('product.single_product');
Route::get('/products', [ProductPageController::class, 'products'])->name('category.products');
Route::get('/frequently-asked-question', [FaqPageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PrivacyPolicyPageController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/terms-and-conditions', [TermsAndConditionsPageController::class, 'terms_and_conditions'])->name('terms_and_conditions');
Route::get('/about-us', [AboutPageController::class, 'about'])->name('about_us');
Route::controller(ContactPageController::class)->group(function () {
    Route::get('/contact-us', 'contact')->name('contact_us');
    Route::post('/contact-us/submit', 'contact_submit')->name('contact_us.submit');
});

Route::controller(DataDeletionController::class)->group(function () {
    Route::get('/data-deletion', 'index')->name('data_deletion');
    Route::post('/data-deletion/submit', 'submit')->name('data_deletion.submit');
});

Route::controller(UserOrderByPrescriptionController::class)->prefix('order-by-prescrition')->name('u.obp.')->group(function () {
    Route::post('upload-prescription', 'prescription_upload')->name('up');
    Route::post('prescription/upload/image', 'image_upload')->name('upload');
    Route::post('prescription/create', 'create')->name('create');
    Route::put('prescription/update/{id}', 'update')->name('update');
    Route::get('prescription/delete/{id}', 'delete')->name('delete');
    Route::post('prescription/verify', 'verify')->name('verify');
    Route::post('prescription/send-otp', 'sendOtp')->name('send_otp');
    Route::post('prescription/resend-otp', 'resendOtp')->name('resend_otp');
    Route::post('prescription/verify-otp', 'verifyOtp')->name('verify_otp');
});

//Developer Routes
Route::get('/export-permissions', function () {
    $filename = 'permissions.csv';
    $filePath = createCSV($filename);
    return Response::download($filePath, $filename);
})->name('export.permissions');