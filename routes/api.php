<?php

use App\Http\Controllers\Api\V1\ProfileFriendsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.v1.')->prefix('v1')->group(function () {
    Route::apiResource('profiles', \App\Http\Controllers\Api\V1\ProfileController::class);

    Route::get('profiles/friends/{profile}', [ProfileFriendsController::class, 'friends']);

    Route::get('profiles/shorter/connection/{firstProfile}/{secondProfile}', [ProfileFriendsController::class, 'shorterConnection']);
});
