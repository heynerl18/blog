<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
  /** @use HasFactory<\Database\Factories\PostFactory> */
  use HasFactory, HasSlug;

  protected $fillable = [
    'title',
    'slug',
    'content',
    'status',
    'user_id',
    'category_id'
  ];

  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()
    ->generateSlugsFrom('title')
    ->saveSlugsTo('slug');
  }

  // * Indicate one post belongs to one user
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class, 'post_tag');
  }

  // * Indicate one post can have many medias 
  public function media()
  {
    return $this->hasMany(Media::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class)->whereNull('parent_id');
  }
}
