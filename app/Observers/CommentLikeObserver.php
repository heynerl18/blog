<?php

namespace App\Observers;

use App\Models\CommentLike;
use App\Models\Comment;

class CommentLikeObserver
{
	/**
	 * Handle the CommentLike "created" event.
	 */
	public function created(CommentLike $commentLike): void
	{
		if ($commentLike->is_like) {
			$commentLike->comment->increment('likes_count');
		}else {
			$commentLike->comment->increment('dislikes_count');
		}
	}

	/**
	 * Handle the CommentLike "updated" event.
	 */
	public function updated(CommentLike $commentLike): void
	{
		// If the is_like field has changed, update the counts accordingly
		if ($commentLike->isDirty('is_like')) {
			if ($commentLike->is_like) {
				// If the new value is true, increment likes and decrement dislikes
				$commentLike->comment->increment('likes_count');
				$commentLike->comment->decrement('dislikes_count');
			} else {
				// If the new value is false, increment dislikes and decrement likes
				$commentLike->comment->increment('dislikes_count');
				$commentLike->comment->decrement('likes_count');
			}
		}
	}

	/**
	 * Handle the CommentLike "deleted" event.
	 */
	public function deleted(CommentLike $commentLike): void
	{
		if ($commentLike->is_like) {
			// If the like was deleted, decrement the likes count
			$commentLike->comment->decrement('likes_count');
		} else {
			// If the dislike was deleted, decrement the dislikes count
			$commentLike->comment->decrement('dislikes_count');
		}
	}

	/**
	 * Handle the CommentLike "restored" event.
	 */
	public function restored(CommentLike $commentLike): void
	{
		//
	}

	/**
	 * Handle the CommentLike "force deleted" event.
	 */
	public function forceDeleted(CommentLike $commentLike): void
	{
		//
	}
}
