<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailStatusController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::group([
     'middleware' => 'auth:api'
], function () {

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/getUser', [AuthController::class, 'User']);
// Emails
    Route::get('/emails/{folderId}', [EmailController::class, 'index']);
    Route::get('/getCount', [EmailController::class, 'getCount']);
    Route::get('/emails/{id}', [EmailController::class, 'show']);
    Route::post('/emails', [EmailController::class, 'store']);

// Attachments
    Route::get('/attachments', [AttachmentController::class, 'index']);
    Route::get('/attachments/{id}', [AttachmentController::class, 'show']);

// Email Statuses
    Route::get('/email-statuses', [EmailStatusController::class, 'index']);
    Route::get('/email-statuses/{id}', [EmailStatusController::class, 'show']);

});
