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
		Schema::create('uploads', function (Blueprint $table) {
			$table->id();
			$table->foreignId('transaction_id')->constrained()->onDelete('cascade'); // Linked to a transaction
			$table->string('file_path'); // Stores file path
			$table->string('file_type'); // Stores file type (jpg, png, pdf, etc.)
			$table->timestamps();
			$table->softDeletes('deleted_at', precision: 0);
		});
	}

	/**
	* Reverse the migrations.
	*/
	public function down(): void
	{
		Schema::dropIfExists('uploads');
	}
};
