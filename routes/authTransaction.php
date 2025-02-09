<?php
use Illuminate\Support\Facades\Route;

// load controller
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionAjaxController;

Route::middleware('auth')->group(function () {

	Route::resources([
		'transactions' => TransactionController::class,
	]);

		// AJAX Routes
	Route::get('/ajax/categories', [TransactionAjaxController::class, 'getCategories'])->name('ajax.categories');
	Route::get('/ajax/reports', [TransactionAjaxController::class, 'getTransactions'])->name('ajax.reports');
});
