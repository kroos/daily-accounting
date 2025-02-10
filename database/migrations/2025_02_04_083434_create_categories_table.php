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
			$table->string('category')->unique();
			$table->enum('type', ['income', 'expense']);
			$table->string('color')->nullable();
			$table->timestamps();
			$table->softDeletes('deleted_at', precision: 0);
		});

		// Insert predefined categories
		DB::table('categories')->insert([
			['category' => 'Salary', 'type' => 'income', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Business Revenue', 'type' => 'income', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Food & Groceries', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Rent / Mortgage', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Utilities', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Transportation', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Debt Repayments', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Dining Out & Coffee', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Clothing & Accessories', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Health & Personal Care', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Entertainment & Leisure', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Tobacco', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Children’s Education', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Elderly Support', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Gifts & Celebrations', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Emergency Fund', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Investments', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Pet Expenses', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Home Maintenance', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['category' => 'Charity & Donations', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
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
