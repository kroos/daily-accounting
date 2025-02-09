<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	* Run the migrations.
	*/
	public function up(): void
	{
		Schema::create('transactions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link transactions to a user
			$table->enum('type', ['income', 'expense']);
			$table->foreignId('category_id')->constrained()->onDelete('cascade'); // Link to categories
			$table->decimal('amount', 10, 2);
			$table->date('date');
			$table->string('barcode')->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes('deleted_at', precision: 0);
		});
	}

	/**
	* Reverse the migrations.
	*/
	public function down(): void
	{
		Schema::dropIfExists('transactions');
	}
};
