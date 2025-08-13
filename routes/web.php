<?php
use Illuminate\Support\Facades\Route;

// load controller
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
	return view('welcome');
});

Route::get('/dashboard', [TransactionController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
Route::middleware(['auth', 'password.confirm'])->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
	Route::resources([
		'categories' => CategoryController::class,
		'transactions' => TransactionController::class,
	]);
});

require __DIR__.'/auth.php';
