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
		Schema::create('comments', function (Blueprint $table) {
			$table->id();
			$table->text('comment'); // Changed from 'content' to 'comment'
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('post_id');
			$table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
			$table->unsignedInteger('likes_count')->default(0);
			$table->unsignedInteger('dislikes_count')->default(0);
			
			// fields for moderation
			$table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
			$table->text('moderation_reason')->nullable();
			$table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
			$table->timestamp('moderated_at')->nullable();

			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('comments');
	}
};
