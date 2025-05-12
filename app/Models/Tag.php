<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($tag) {
      $slug = Str::slug($tag->name);
      $tag->slug = $tag->makeSlugUnique($slug);
    });

    // Update the slug automatically if the name changes
    static::updating(function ($tag) {
      if ($tag->isDirty('name')) {
        $slug = Str::slug($tag->name);
        $tag->slug = $tag->makeSlugUnique($slug, $tag->id);
      }
    });
  }

  private function makeSlugUnique($slug, $id = null){
    $originalSlug = $slug;
    $count        = 1;

    // Check if the slug already exists.
    while (Tag::where('slug', $slug)->where('id', '!=', $id)->exists()) {
      $slug = $originalSlug . '-'. $count;
      $count++;
    }
    return $slug;
  }

  public function posts()
  {
    return $this->belongsToMany(Post::class, 'post_tag');
  }
}
