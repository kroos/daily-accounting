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
	Route::post('/ajax/categories/getCategories', [CategoryAjaxController::class, 'getCategories'])->name('ajax.getCategories');
	Route::get('/ajax/categories/listcategories', [CategoryAjaxController::class, 'listcategories'])->name('ajax.listcategories');
});
