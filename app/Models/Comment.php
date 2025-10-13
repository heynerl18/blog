<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  /** @use HasFactory<\Database\Factories\CommentFactory> */
  use HasFactory;

  protected $fillable = [
    'comment',
    'user_id',
    'post_id',
    'parent_id',
    'likes_count',
    'dislikes_count',
    'status',
    'moderation_reason',
    'moderated_by',
    'moderated_at'
  ];

  protected $casts = [
    'moderated_at' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function post()
  {
    return $this->belongsTo(Post::class);
  }

  // returns the parent comment (if it is a reply).
  public function parent()
  {
    return $this->belongsTo(Comment::class, 'parent_id');
  }

  // returns child comments (replies to this comment), sorted by descending date.
  public function replies()
  {
    return $this->hasMany(Comment::class, 'parent_id')->latest();
  }

  public function likes()
  {
    return $this->hasMany(CommentLike::class);
  }

  public function isLikedByUser(?User $user) // Accept null for unauthenticated users
  {
    if (!$user) {
      return false;
    }
    // Check if the user has liked the comment
    return $this->likes()->where('user_id', $user->id)->where('is_like', true)->exists();
  }

  public function isDislikedByUser(?User $user) // Accept null for unauthenticated users
  {
    if (!$user) {
      return false;
    }
    // Check if the user has disliked the comment
    return $this->likes()->where('user_id', $user->id)->where('is_like', false)->exists();
  }

  public function moderatedBy()
  {
    return $this->belongsTo(User::class, 'moderated_by');
  }

  // Scopes
  public function scopeApproved($query)
  {
    return $query->where('status', 'approved');
  }

  public function scopePending($query)
  {
    return $query->where('status', 'pending');
  }

  public function scopeRejected($query)
  {
    return $query->where('status', 'rejected');
  }

}
