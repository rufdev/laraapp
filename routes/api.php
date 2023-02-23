<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\MunicipalityController;

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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('municipality', MunicipalityController::class);

    Route::get('profile', [UserController::class, 'profile']);
    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::apiResources([
        'dashboard' => DashboardController::class
    ]);
    Route::get('getschoolchartdata', [DashboardController::class, 'getschoolchartdata']);

    Route::resource('schools', SchoolController::class);
    Route::post('schools/list', [SchoolController::class, 'getSchools']);
});
