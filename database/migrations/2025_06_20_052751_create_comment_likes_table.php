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
		Schema::create('comment_likes', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->onDelete('cascade'); //  Foreign key to the user, removes likes if the user deletes their account
			$table->foreignId('comment_id')->constrained()->onDelete('cascade'); // Foreign key to the comment, removes likes if the comment is deleted
			$table->boolean('is_like')->default(true)->comment('true para "me gusta", false para "no me gusta"'); // Indicates if the like is a like (true) or a dislike (false)
			$table->timestamps();
			
			$table->unique(['user_id', 'comment_id']); // Ensures a user can only like or dislike a comment once
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('comment_likes');
	}
};
