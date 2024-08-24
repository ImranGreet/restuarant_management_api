<?php

use App\Http\Controllers\RolePermission\PermissionController;
use App\Http\Controllers\RolePermission\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(RoleController::class)->group(function () {
    Route::post('/create_role', 'createRole');
});

Route::controller(PermissionController::class)->group(function () {
    Route::post('/create_permission', 'createPermission');
    Route::get('/get_permissions','getPermissions');
});
