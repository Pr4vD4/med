<?php

use App\Http\Controllers\SpecialitiesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware(['auth:sanctum', 'admin'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/users/auth', [UserController::class, 'auth']);

Route::get('/users/profile', [UserController::class, 'profile'])->middleware(['auth:sanctum']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/users/doctors', [UserController::class, 'doctors']);
    Route::post('/users/appointment/make', [UserController::class, 'make_appointment']);

    Route::get('/specialities/doctors/{id}', [SpecialitiesController::class, 'doctors']);
});

Route::apiResources([
    'users' => UserController::class,
]);

Route::group(['middleware' => ['auth:sanctum']], function () {
   Route::apiResources([
       'specialities' => SpecialitiesController::class,
   ]);
   Route::patch('/users/spec/sync', [UserController::class, 'sync_speciality']);
});

Route::apiResources([
    'specialities' => SpecialitiesController::class
]);
