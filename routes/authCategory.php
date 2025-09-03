<?php
use Illuminate\Support\Facades\Route;

// load controller
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryAjaxController;

Route::middleware('auth')->group(function () {

	Route::resources([
		'categories' => CategoryController::class,
	]);
	// Route::get('categories/edit', [CategoryAjaxController::class, 'edit'])->name('categories.edit');

	// AJAX Routes

});
