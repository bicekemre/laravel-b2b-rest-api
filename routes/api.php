<?php

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/offers', [\App\Http\Controllers\OfferController::class, 'list']);

Route::get('/products/items/{offset}/{limit}', [ProductController::class, 'items'])->name('products.items');
Route::get('/products/{slug}', [ProductController::class, 'item'])->name('products.item');
Route::post('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/update/{slug}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{slug}', [ProductController::class, 'delete'])->name('products.delete');

Route::post('/organizations/add-stock', [OrganizationController::class, 'addStock'])->name('organizations.add-stock');

Route::get('/organizations/items/{offset}/{limit}', [OrganizationController::class, 'items'])->name('organizations.items');
Route::get('/organizations/item/{slug}', [OrganizationController::class, 'item'])->name('organizations.item');
Route::post('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
Route::post('/organizations/{slug}', [OrganizationController::class, 'update'])->name('organizations.update');
Route::delete('/organizations/{slug}', [OrganizationController::class, 'delete'])->name('organizations.delete');

Route::get('/stock', [ProductController::class, 'stock'])->name('products.stock');

