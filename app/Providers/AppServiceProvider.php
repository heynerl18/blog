<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\CommentLike;
use App\Observers\CommentLikeObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    View::composer('layouts.public', function ($view) {
      $categories = Category::select('id', 'name')->get();
      $view->with('categories', $categories);
    });

    CommentLike::observe(CommentLikeObserver::class);
  }
}
