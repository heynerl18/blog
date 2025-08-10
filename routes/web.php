 <?php

use App\Http\Controllers\AuthSocialController;
use App\Livewire\Admin\Categories\CategoriesManager;
use App\Livewire\Admin\Home\AdminHome;
use App\Livewire\Admin\Posts\PostsManager;
use App\Livewire\Admin\Roles\RolesManager;
use App\Livewire\Admin\Tags\TagsManager;
use App\Livewire\Admin\Users\UsersManager;
use App\Livewire\Public\AboutPage;
use App\Livewire\Public\ContactForm;
use App\Livewire\Public\Home;
use App\Livewire\Public\PostShow;
use App\Livewire\Public\PublicCategoryPosts;
use App\Livewire\Public\PublicTagPosts;
use Illuminate\Support\Facades\Route;

// ==================================================
// Public Routes
// ==================================================
Route::name('public.')->group(function () {
  Route::get('/', Home::class)->name('home');
  Route::get('/categories/{category:slug}', PublicCategoryPosts::class)->name('categories.index');
  Route::get('/tags/{tag:slug}', PublicTagPosts::class)->name('tags.index');
  Route::get('/posts/{post:slug}', PostShow::class)->name('posts.show');
  Route::get('/contact', ContactForm::class)->name('contact');
  Route::get('/about', AboutPage::class)->name('about');
});

// ==================================================
// Social Authentication Routes
// ==================================================
Route::prefix('auth')->group(function () {
  Route::get('/redirect', [AuthSocialController::class,'redirectToGoogle'])->name('auth.redirect');
  Route::get('/callback', [AuthSocialController::class, 'handleGoogleCallback'])->name('auth.callback');
});

// ==================================================
// Backend Routes (Protected by Authentication)
// ==================================================
Route::middleware(['auth', 'verified', 'role:Admin|Blogger'])
  ->prefix('dashboard')->name('admin.')
  ->group(function () {
    Route::get('/', AdminHome::class)->name('dashboard');
    Route::get('/categories', CategoriesManager::class)->name('categories');
    Route::get('/tags', TagsManager::class)->name('tags');
    Route::get('/posts', PostsManager::class)->name('posts.index');
    Route::view('/posts/create', 'pages.forms.posts.create')->name('posts.create');
    Route::view('/posts/{postId}/edit', 'pages.forms.posts.edit')->name('posts.edit');
    Route::get('/users', UsersManager::class)->middleware('can:users.index')->name('users');
    Route::get('/roles', RolesManager::class)->name('roles');
});

require __DIR__ . '/auth.php';
