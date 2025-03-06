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
			// $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link transactions to a user
			$table->integer('user_id')->nullable();
			$table->string('category')->unique();
			$table->enum('type', ['income', 'expense']);
			$table->string('color')->nullable();
			$table->timestamps();
			$table->softDeletes('deleted_at', precision: 0);
		});

		// Insert predefined categories
		DB::table('categories')->insert([
			['user_id' => NULL, 'category' => 'Salary', 'type' => 'income', 'color' => '#08fa2c', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Business Revenue', 'type' => 'income', 'color' => '#120af7', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Food & Groceries', 'type' => 'expense', 'color' => '#966058', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Rent / Mortgage', 'type' => 'expense', 'color' => '#c47d72', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Utilities', 'type' => 'expense', 'color' => '#de8a81', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Transportation', 'type' => 'expense', 'color' => '#fa958e', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Debt Repayments', 'type' => 'expense', 'color' => '#6b2c2a', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Dining Out & Coffee', 'type' => 'expense', 'color' => '#853333', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Clothing & Accessories', 'type' => 'expense', 'color' => '#9e3c3e', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Health & Personal Care', 'type' => 'expense', 'color' => '#db5356', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Entertainment & Leisure', 'type' => 'expense', 'color' => '#f55d65', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Tobacco', 'type' => 'expense', 'color' => '#4a1015', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Children’s Education', 'type' => 'expense', 'color' => '#66161d', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Elderly Support', 'type' => 'expense', 'color' => '#b32636', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Gifts & Celebrations', 'type' => 'expense', 'color' => '#de2c41', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Emergency Fund', 'type' => 'expense', 'color' => '#f7314f', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Investments', 'type' => 'expense', 'color' => '#5c0515', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Pet Expenses', 'type' => 'expense', 'color' => '#780117', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Home Maintenance', 'type' => 'expense', 'color' => '#990626', 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Charity & Donations', 'type' => 'expense', 'color' => '#c2062f', 'created_at' => now(), 'updated_at' => now()],
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
