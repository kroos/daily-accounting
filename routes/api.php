<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryAjaxController;
use App\Http\Controllers\TransactionAjaxController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
	Route::post('/ajax/categories/getCategories', [CategoryAjaxController::class, 'getCategories'])->name('ajax.getCategories');
	Route::get('/ajax/categories/listcategories', [CategoryAjaxController::class, 'listcategories'])->name('ajax.listcategories');
	Route::post('/ajax/transactions/reports', [TransactionAjaxController::class, 'getTransactions'])->name('ajax.reports');
	Route::delete('/ajax/categories/destroy/{category}', [CategoryController::class, 'destroy'])->name('ajax.categories.destroy');
	Route::delete('/ajax/transactions/destroy/{transaction}', [TransactionController::class, 'destroy'])->name('ajax.transactions.destroy');
});
