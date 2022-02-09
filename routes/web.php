<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\Auth\ProfileController;
use App\Http\Controllers\Backend\AdministratorController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\RollController;
use App\Http\Controllers\Backend\BlockController;
use App\Http\Controllers\Backend\PositionController;
use App\Http\Controllers\Backend\PlateController;
use App\Http\Controllers\Backend\CandidateController;
use App\Http\Controllers\Backend\LogRollController;
use App\Http\Controllers\Frontend\AppController as FrontendAppController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\VoteController;
use App\Http\Controllers\Backend\VoteResultController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UserNotInRollController;
use App\Http\Controllers\Backend\DesignationController;

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

// Route::get('/', [FrontendAppController::class, 'app']);

Route::group(['middleware' => ['admin_authenticate:1']], function () {

    Route::get('logout', [LoginController::class, 'logout']);

    Route::group(['prefix' => 'admin'], function() {

        Route::get('/', [AdminController::class, 'index']);

        // PROFILE
        Route::get('profile', [ProfileController::class, 'index']);
        Route::post('profile/update', [ProfileController::class, 'update']);

        // ADMINISTRATORS
        Route::get('administrator/{administrator}/change-status', [AdministratorController::class, 'changeStatus'])->middleware('role:super-admin');

        // USERS
        Route::get('users/validate/{index?}', [UserController::class, 'validateUsers']);
        Route::post('users/validate/{index}/{user}', [UserController::class, 'validateUser']);
        Route::get('users/validate-all-users', [UserController::class, 'validateAllUsers']);
        Route::get('users/export', [UserController::class, 'export']);

        // ROLLS
        Route::get('rolls/import', [RollController::class, 'import']);
        Route::post('rolls/import', [RollController::class, 'importPost']);
        Route::get('rolls/export', [RollController::class, 'export']);
        Route::post('rolls/export', [RollController::class, 'exportPost']);

        // ROLES
        Route::get('roles/{role}/permissions', [RoleController::class, 'permissions']);
        Route::post('roles/{role}/permissions', [RoleController::class, 'editPermissions']);

        // VOTES RESULTS
        Route::get('vote-results/load-votes-manually', [VoteResultController::class, 'loadVotesManually']);
        Route::post('vote-results/load-votes-manually', [VoteResultController::class, 'loadVotesManuallyPost']);
        Route::get('vote-results/export', [VoteResultController::class, 'export']);

        // VOTES
        Route::get('votes/send-mail-results/{vote}', [VoteController::class, 'sendMailResults']);

        // USER NOT IN ROLLS
        Route::get('user-not-in-rolls/export', [UserNotInRollController::class, 'export']);

        Route::group([/*'middleware' => ['role:super-admin']*/], function() {

            Route::resources([
                'administrators' => AdministratorController::class,
                'roles' => RoleController::class,
                'users' => UserController::class,
                'rolls' => RollController::class,
                'blocks' => BlockController::class,
                'blocks.positions' => PositionController::class,
                'plates' => PlateController::class,
                'plates.candidates' => CandidateController::class,
                'log-rolls' => LogRollController::class,
                'votes' => VoteController::class,
                'vote-results' => VoteResultController::class,
                'homes' => HomeController::class,
                'user-not-in-rolls' => UserNotInRollController::class,
                'designations' => DesignationController::class,
            ]);
        });
    });

});

Route::group(['middleware' => 'admin_authenticate:0'], function() {
    Route::get('login', [LoginController::class, 'login']);
    Route::post('login', [LoginController::class,'authenticate']);
});

Route::get('email/verify/{user}', [LoginController::class, 'verifyEmail'])->name('email.verify.user');

Route::get('/{any}', [FrontendAppController::class, 'app'])->where('any', '.*');