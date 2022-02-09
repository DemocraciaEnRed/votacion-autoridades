<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserPhotoController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\VoteController;
use App\Http\Controllers\API\BlockController;
use App\Http\Controllers\API\PlateController;
use App\Http\Controllers\API\VoteResultController;
use App\Http\Controllers\API\UserNotInRollController;
use App\Http\Controllers\API\DesignationController;
use App\Http\Controllers\API\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logged', [UserController::class, 'logged']);

    Route::post('change-password', [UserController::class, 'changePassword']);

    Route::group(['prefix' => 'vote-results'], function() {
        Route::post('user-vote', [VoteResultController::class, 'userVote'])->middleware(['votation-in-course', 'user-dont-voted']);
    });
});

Route::group(['prefix' => 'vote-results'], function() {
    Route::get('results', [VoteResultController::class, 'results']);
    Route::get('excel-results', [VoteResultController::class, 'excelResults']);
});

// AUTH
Route::group(['prefix' => 'auth'], function() {
    Route::post('valid-dni', [LoginController::class, 'validDNI']);
    Route::post('take-census', [LoginController::class, 'takeCensus']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('valid-data-registration', [LoginController::class, 'validDataRegistration']);
    Route::post('register', [LoginController::class, 'register']);
    Route::post('logout', [LoginController::class, 'logout']);

    Route::group(['prefix' => 'forgot-password'], function() {
        Route::post('/', [LoginController::class, 'forgotPassword']);
        Route::post('/validate-token', [LoginController::class, 'validateToken']);
        Route::post('/change-password', [LoginController::class, 'changePasswordForgotten']);
    });


});

// PRODUCT IMAGES
Route::group(['prefix' => 'user-photos'], function() {
    Route::post('upload', [UserPhotoController::class, 'upload']);
});

// BLOCKS
Route::group(['prefix' => 'blocks'], function() {
    Route::get('with-plates', [BlockController::class, 'blocksWithPlates']);
});

Route::resources([
    'users' => UserController::class,
    'user-photos' => UserPhotoController::class,
    'roles' => RoleController::class,
    'votes' => VoteController::class,
    'blocks' => BlockController::class,
    'plates' => PlateController::class,
    'user-not-in-rolls' => UserNotInRollController::class,
    'designations' => DesignationController::class,
    'homes' => HomeController::class,
]);
