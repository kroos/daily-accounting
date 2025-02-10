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
	Route::post('/ajax/transactions/reports', [TransactionAjaxController::class, 'getTransactions'])->name('ajax.reports');
});
