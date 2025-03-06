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
			['user_id' => NULL, 'category' => 'Salary', 'type' => 'income', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Business Revenue', 'type' => 'income', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Food & Groceries', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Rent / Mortgage', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Utilities', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Transportation', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Debt Repayments', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Dining Out & Coffee', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Clothing & Accessories', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Health & Personal Care', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Entertainment & Leisure', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Tobacco', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Children’s Education', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Elderly Support', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Gifts & Celebrations', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Emergency Fund', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Investments', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Pet Expenses', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Home Maintenance', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
			['user_id' => NULL, 'category' => 'Charity & Donations', 'type' => 'expense', 'color' => null, 'created_at' => now(), 'updated_at' => now()],
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
