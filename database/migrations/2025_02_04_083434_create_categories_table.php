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
		Schema::create('categories', function (Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
			$table->enum('type', ['income', 'expense']);
			$table->timestamps();
			$table->softDeletes('deleted_at', precision: 0);
		});

		// Insert predefined categories
		DB::table('categories')->insert([
			['name' => 'Salary', 'type' => 'income', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Business Revenue', 'type' => 'income', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Food & Groceries', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Rent / Mortgage', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Utilities', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Transportation', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Debt Repayments', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Dining Out & Coffee', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Clothing & Accessories', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Health & Personal Care', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Entertainment & Leisure', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Tobacco', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Children’s Education', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Elderly Support', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Gifts & Celebrations', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Emergency Fund', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Investments', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Pet Expenses', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Home Maintenance', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
			['name' => 'Charity & Donations', 'type' => 'expense', 'created_at' => now(), 'updated_at' => now()],
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('categories');
	}
};
