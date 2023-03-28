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

Route::apiResources([
    'users' => UserController::class,
]);

Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
   Route::apiResources([
       'specialities' => SpecialitiesController::class,
   ]);
});

Route::apiResources([
    'specialities' => SpecialitiesController::class
]);
