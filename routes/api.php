<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\RolePermission\PermissionController;
use App\Http\Controllers\RolePermission\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(RoleController::class)->group(function () {
    Route::post('/create_role', 'createRole');
    Route::get('/get_roles','getRoles');
});

Route::controller(PermissionController::class)->group(function () {
    Route::post('/create_permission', 'createPermission');
    Route::get('/get_permissions','getPermissions');
});


/*order*/
Route::controller(OrderController::class)->group(function(){
    Route::post('/order/create_order','createOrder');
    Route::put('/order/update_order/{id}','updateOrder');
    Route::get('/our_order','retrieveOrder');
    Route::get('orders/{order_type}','retrieveOrderByType');
    Route::delete('/order/deleteOrder/{id}','deleteOrder');
});
