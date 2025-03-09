<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolePermission\PermissionController;
use App\Http\Controllers\RolePermission\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Define routes for the RoleController
Route::controller(RoleController::class)->group(function () {
    Route::post('/create_role', 'createRole');
    Route::get('/get_roles', 'getRoles');
});
// Define routes for the PermissionController
Route::controller(PermissionController::class)->group(function () {
    Route::post('/create_permission', 'createPermission');
    Route::get('/get_permissions', 'getPermissions');
});

// Define routes for the TransactionController
Route::controller(TransactionController::class)->group(function () {
    Route::get('/our_transaction', 'retrieveTransactions');
    Route::get('/our_transaction_by_date', 'retrieveTransactionsByDateRange');
});


// Define routes for the OrderController
Route::controller(OrderController::class)->group(function () {
    Route::post('/order/create_order', 'createOrder');
    Route::put('/order/update_order/{id}', 'updateOrder');
    Route::get('/our_order', 'retrieveOrder');
    Route::get('orders/{order_type}', 'retrieveOrderByType');
    Route::delete('/order/deleteOrder/{id}', 'deleteOrder');
});

// Define routes for the ExpenseController
Route::controller(ExpenseController::class)->group(function () {
    Route::get('/our_expenses', 'retrieveExpenses');
    Route::get('/createExpense', 'createExpense');
    Route::get('/expenses/{id}/edit', 'editExpense');
    Route::put('/expenses/{id}', 'updateExpense');
    Route::delete('/expenses/{id}', 'deleteExpense');
});


// Define routes for the StockController
Route::controller(StockController::class)->group(function () {
    // Retrieve all stocks
    Route::get('/our_stocks', 'retrieveStocks');
    Route::get('/our_stocks_by_date', 'retrieveStocksByDateRange');
    Route::post('/our_stocks', 'createStock');
    Route::get('/our_stocks/{id}/edit', 'editStock');
    Route::put('/our_stocks/{id}', 'updateStock');
    Route::delete('/our_stocks/{id}', 'deleteStock');
});

// Define routes for the StuffController
Route::controller(StuffController::class)->group(function () {
    Route::get('/our_stuffs', 'retrieveStuffs');
    Route::post('/our_stuffs', 'createStuff');
    Route::get('/our_stuffs/{id}/edit', 'editStuff');
    Route::put('/our_stuffs/{id}', 'updateStuff');
    Route::delete('/our_stuffs/{id}', 'deleteStuff');
    Route::delete('/our_stuffs', 'deleteMultipleStuffs');
});

// Define routes for the CategoryController
Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'retrieveCategories');
    Route::get('/categories/{id}', 'retrieveCategoryById');
    Route::post('/categories', 'createCategory');
    Route::get('/categories/{id}/edit', 'editCategory');
    Route::put('/categories/{id}', 'updateCategory');
    Route::delete('/categories/{id}', 'deleteCategory');
});



// Define routes for the ProductController
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'retrieveProducts');
    Route::get('products/{category}', 'retrieveProductsByCategory')->where('category', '[a-zA-Z]+');
    Route::get('/products/{id}', 'retrieveProductById')->where('id', '[0-9]+');
    Route::post('/products', 'createProduct');
    Route::get('/products/{id}/edit', 'editProduct')->where('id', '[0-9]+');
    Route::put('/products/{id}/editproduct', 'updateProduct')->where('id', '[0-9]+');
    Route::put('/products/{id}/updateStatus', 'updateProductStatus')->where('id', '[0-9]+');
    Route::delete('/products/{id}', 'deleteProduct')->where('id', '[0-9]+');
});

