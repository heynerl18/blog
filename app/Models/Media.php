<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
  /** @use HasFactory<\Database\Factories\MediaFactory> */
  use HasFactory;

  protected $fillable = [
    'url',
    'file_type',
    'post_id',
  ];

  // * Indicate one Media belongs to one Post
  public function post()
  {
    return $this->belongsTo(Post::class);
  }
}
    