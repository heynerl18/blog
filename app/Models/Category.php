<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
  ];

  protected static function boot()
  {
    parent::boot();

  // Generate the slug automatically before creating the record
    static::creating(function ($category) {
      $slug = Str::slug($category->name);
      $category->slug = $category->makeSlugUnique($slug);
    });

    // Update the slug automatically if the name changes
    static::updating(function ($category) {
      if ($category->isDirty('name')) {
        $slug = Str::slug($category->name);
        $category->slug = $category->makeSlugUnique($slug, $category->id);
      }
    });
  }

  private function makeSlugUnique($slug, $id = null)
  {
    $originalSlug = $slug;
    $count = 1;

    // Check if the slug already exists
    while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
      $slug = $originalSlug . '-' . $count;
      $count++;
    }
    return $slug;
  }


  // * Indicate one category can have many posts
  public function posts()
  {
    return $this->hasMany(Post::class);
  }
}
