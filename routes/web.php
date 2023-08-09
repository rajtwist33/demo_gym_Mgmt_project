<?php
use App\Http\Controllers\Admin\TrainerPayment;
use App\Http\Controllers\Admin\TrainershiftController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\GymerController;
use App\Http\Controllers\Admin\ModelController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Superadmin\ModeController;
use App\Http\Controllers\Superadmin\RoleController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\User_offerController;
use App\Http\Controllers\Superadmin\ShiftController;
use App\Http\Controllers\Admin\AdvanceListController;
use App\Http\Controllers\Admin\PaymenteditController;
use App\Http\Controllers\Superadmin\GenderController;
use App\Http\Controllers\Superadmin\PackageController;
use App\Http\Controllers\Admin\Users_profileController;
use App\Http\Controllers\Superadmin\BloodtypeController;
use App\Http\Controllers\Admin\AnualpaymenttypeController;
use App\Http\Controllers\Superadmin\ActivegymerController;
use App\Http\Controllers\Admin\Attendance_reportController;
use App\Http\Controllers\Admin\Paymenthistory;
use App\Http\Controllers\Superadmin\GroupDiscounController;
use App\Http\Controllers\Superadmin\InactivegymerController;
use App\Http\Controllers\Superadmin\Annual_PaymentController;
use App\Http\Controllers\Superadmin\DeletegymerController;
use App\Http\Controllers\Superadmin\PasswordChangeController;


Route::get('/demo', function ()
 {
});
Route::get('/', function () {
    Artisan::call('key:generate');
    Artisan::call('optimize:clear');
    return view('home');
});
Route::get('/welcome', function () {
    Artisan::call('optimize:clear');
    Artisan::call('key:generate');
    return view('welcome');
})->name('welcome');

Auth::routes();

//  All SuperAdmin Routes List
Route::group(['prefix' => 'home', 'middleware' => ['auth', 'user-access:1']], function () {
    Route::get('/', [HomeController::class, 'superadminHome'])->name('superadmin.home');

    Route::group(['namespace' => 'App\Http\Controllers\Superadmin', 'as' => 'superadmin.'], function () {
        Route::resources(
            [
                'setup/shift' => ShiftController::class,
            ],
            ['only' => ['index', 'create', 'store', 'edit', 'show', 'update', 'destroy']],
        );
        Route::resources(
            [
                'manage/users' => UserController::class,
                'manage/role' => RoleController::class,
                'manage/active_gymer' => ActivegymerController::class,
                'manage/inactive_gymer' => InactivegymerController::class,
                'setup/gender' => GenderController::class,
                'setup/blood_type' => BloodtypeController::class,
                'setup/offer' => PackageController::class,
                'setup/modes' => ModeController::class,
                'setup/groupdiscount' => GroupDiscounController::class,
                'setup/annual_payment' => Annual_PaymentController::class,
                'change_password' => PasswordChangeController::class,
                'deletegymer'=>DeletegymerController::class,
            ],
            ['except' => []],
        );
    });
});

// All Admin Routes List
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'user-access:2']], function () {
    Route::get('/', [HomeController::class, 'adminHome'])->name('admin.home');

    Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.'], function () {
        Route::resources([
            'manage/gymer' => GymerController::class,
            'manage/trainer' => TrainerController::class,
            'payment' => PaymentController::class,
            'paymentedit' => PaymenteditController::class,
            'attendance' => AttendanceController::class,
            'attendancereport' => Attendance_reportController::class,
            'advancelist' => AdvanceListController::class,
            'modes' => ModelController::class,
            'users_profile' => Users_profileController::class,
            'user_offer' => User_offerController::class,
            'offers' => OfferController::class,
            'anual_paymenttype' => AnualpaymenttypeController::class,
            'payment_history' => Paymenthistory::class,
            'trainerpayment'=>TrainerPayment::class,
            'trainershift'=>TrainershiftController::class,

        ]);
        Route::post('payment_history/addoldpayment',[Paymenthistory::class, 'addoldpayment'])->name('payment_history.addoldpayment');
        Route::post('trainerpayment/addtraineroldamount',[TrainerPayment::class, 'addtraineroldamount'])->name('trainerpayment.addtraineroldamount');

        //Pdf
        Route::get('/pdf', [PdfController::class, 'index'])->name('pdf.index');
        Route::get('/pdf/profile', [PdfController::class, 'show'])->name('profile');
        Route::get('/print/profile/{id}', [PdfController::class, 'print_profile'])->name('print.profile');
        Route::post('/pdf/generate-pdf', [PdfController::class, 'gymerdues'])->name('search.gymerdues');
        Route::get('group/delete/{slug}', [Users_profileController::class, 'destroy'])->name('delete.group');
        Route::get('offer/delete/{slug}', [User_offerController::class, 'destroy'])->name('delete.offer');
        Route::get('paymenttype/delete/{slug}', [AnualpaymenttypeController::class, 'destroy'])->name('delete.paymenttype');
    });
});
