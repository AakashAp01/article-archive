<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SearchController;
use App\Livewire\ArticleList;
use App\Livewire\ArticleManager;
use App\Livewire\CategoryManager;
use App\Livewire\Dashboard;
use App\Livewire\EmailTemplateManager;
use App\Livewire\NewsletterManager;
use App\Livewire\UserManager;
use App\Livewire\ProfileManager;
use App\Livewire\LoginManager;
use App\Livewire\ResetPassword;
use App\Livewire\SavedArticles;
use App\Livewire\SettingsManager;
use Illuminate\Http\Request;

// 1. Public Pages
Route::get('/', function () { return view('welcome'); })->name('welcome');
Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('newsletter/unsubscribe/{email}', [NewsletterController::class, 'showUnsubscribeForm'])->name('newsletter.unsubscribe.confirm');
Route::post('newsletter/unsubscribe', [NewsletterController::class, 'processUnsubscribe'])->name('newsletter.unsubscribe.process');

// 2. Guest Routes
Route::middleware('guest')->group(function () {

    Route::get('login', LoginManager::class)->name('login');

    Route::get('auth/google', [AuthController::class, 'redirect'])->name('google.login');

    Route::get('auth/google/callback', [AuthController::class, 'callback']);

    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');

});

// 3. Protected Routes (Admin Panel)
Route::middleware('auth','throttle:60,1')->group(function () {

    // Category Management
    Route::get('admin/dashboard', Dashboard::class)->name('dashboard');
    Route::get('admin/categories', CategoryManager::class)->name('categories.index');
    Route::get('admin/newsletter', NewsletterManager::class)->name('newsletter.index');

    // Toggle Publish
    Route::post('admin/article/{id}/toggle-publish', [ArticleController::class, 'togglePublish'])->name('article.toggle-publish');
    Route::get('admin/users', UserManager::class)->name('users.index');

    // Listing Page
    Route::get('admin/articles', ArticleList::class)->name('article.index');
    Route::get('admin/articles/create', ArticleManager::class)->name('article.create');
    Route::get('admin/articles/{id}/edit', ArticleManager::class)->name('article.edit');
   
    // Profile Management
    Route::get('profile', ProfileManager::class)->name('profile');
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    // Email Template Management
    Route::get('admin/email-templates', EmailTemplateManager::class)->name('email-templates');

    //setting 
    Route::get('admin/settings', SettingsManager::class)->name('settings');
    Route::get('/saved-articles', SavedArticles::class)->name('articles.saved');
});

// 4. Wildcard Routes
Route::get('article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('articles/search', [SearchController::class, 'searchApi']);
Route::get('canvas/viewport', [SearchController::class, 'fetchViewport']);
Route::get('canvas/map', [SearchController::class, 'fetchMap']);
Route::get('canvas/bounds', [SearchController::class, 'fetchBounds']);


//Legal pages
Route::view('privacy-policy', 'privacy')->name('privacy');
Route::view('terms-of-service', 'terms')->name('terms');


