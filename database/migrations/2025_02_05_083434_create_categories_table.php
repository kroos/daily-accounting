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
			['name' => 'Salary', 'type' => 'income'],
			['name' => 'Business Revenue', 'type' => 'income'],
			['name' => 'Food & Groceries', 'type' => 'expense'],
			['name' => 'Rent / Mortgage', 'type' => 'expense'],
			['name' => 'Utilities', 'type' => 'expense'],
			['name' => 'Transportation', 'type' => 'expense'],
			['name' => 'Debt Repayments', 'type' => 'expense'],
			['name' => 'Dining Out & Coffee', 'type' => 'expense'],
			['name' => 'Clothing & Accessories', 'type' => 'expense'],
			['name' => 'Health & Personal Care', 'type' => 'expense'],
			['name' => 'Entertainment & Leisure', 'type' => 'expense'],
			['name' => 'Tobacco & Alcohol', 'type' => 'expense'],
			['name' => 'Children’s Education', 'type' => 'expense'],
			['name' => 'Elderly Support', 'type' => 'expense'],
			['name' => 'Gifts & Celebrations', 'type' => 'expense'],
			['name' => 'Emergency Fund', 'type' => 'expense'],
			['name' => 'Investments', 'type' => 'expense'],
			['name' => 'Pet Expenses', 'type' => 'expense'],
			['name' => 'Home Maintenance', 'type' => 'expense'],
			['name' => 'Charity & Donations', 'type' => 'expense'],
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
