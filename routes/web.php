 <?php

use App\Http\Controllers\AuthSocialController;
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
Route::get('/', Home::class)->name('home');
Route::get('/categories/{category:slug}', PublicCategoryPosts::class)->name('categories.index');
Route::get('/tags/{tag:slug}', PublicTagPosts::class)->name('tags.index');
Route::get('/posts/{post:slug}', PostShow::class)->name('posts.show');
Route::get('/contact', ContactForm::class)->name('contact');
Route::get('/about', AboutPage::class)->name('about');

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
Route::middleware(['auth', 'verified'])->group(function () {
  Route::view('/dashboard', 'pages._index')->name('dashboard');
  Route::view('/categories', 'pages._categories')->name('categories');
  Route::view('/tags', 'pages._tags')->name('tags');
  Route::view('/posts', 'pages._posts')->name('posts.index');
  Route::view('/posts/create', 'pages.forms.posts.create')->name('posts.create');
  Route::view('/posts/{postId}/edit', 'pages.forms.posts.edit')->name('posts.edit');
  Route::view('/users', 'pages._users')->middleware('can:users.index')->name('users');
  Route::view('/roles', 'pages._roles')->name('roles');
});

require __DIR__ . '/auth.php';
