<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController; 
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;

Route::post('/users/{userId}/assign-role', [AuthController::class, 'assignRole']);
Route::post('/users/{userId}/remove-role', [AuthController::class, 'removeRole']);



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'role'
], function ($router) {
    Route::get('/getAll', [RoleController::class, 'getAll'])->name('getAll');
    Route::post('/create', [RoleController::class, 'create'])->name('create');
    Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user_role'
], function ($router) {
    Route::post('/addRoleToUser/{userId}', [UserRoleController::class, 'addRoleToUser'])->name('addRoleToUser');
    Route::post('/sync-roles-to-user/{userId}', [UserRoleController::class, 'syncRolesToUser'])->name('syncRolesToUser');
    Route::post('/remove-role-from-user/{userId}', [UserRoleController::class, 'removeRoleFromUser'])->name('removeRoleFromUser');
});