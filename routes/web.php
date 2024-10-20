<?php

use App\Http\Controllers\Chat\ConversationController;
use App\Http\Controllers\Chat\ConversationMessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    if (auth()->check) {
        return redirect('/home');
    }
    return Inertia::render('Welcome');
})->middleware('guest')->name('welcome');

Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');

Route::middleware('auth')->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');    

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('profile/picture', [ProfilePictureController::class, 'index'])->name('profile.picture.index');
    Route::get('profile/picture/create', [ProfilePictureController::class, 'create'])->name('profile.picture.create');
    Route::post('profile/picture', [ProfilePictureController::class, 'store'])->name('profile.picture.store');

    Route::resource('messages', ConversationController::class)->names('conversations');

    Route::get('msg/{conversationId}', [ConversationMessageController::class, 'index'])->name('messages.index');
    Route::get('msg/{conversationId}/{messageId}', [ConversationMessageController::class, 'show'])->name('messages.show');
    Route::post('msg/{conversationId}', [ConversationMessageController::class, 'store'])->name('messages.store');
    Route::delete('msg/{conversationId}', [ConversationMessageController::class, 'deleteAll'])->name('messages.deleteAll');
    Route::delete('msg/{conversationId}/{messageId}', [ConversationMessageController::class, 'destroy'])->name('messages.destroy');

    // Landing Page routes
    Route::get('landing-pages', [LandingPageController::class, 'index'])->name('landing-pages.index');
    Route::get('landing-pages/create', [LandingPageController::class, 'create'])->name('landing-pages.create');
    Route::post('landing-pages', [LandingPageController::class, 'store'])->name('landing-pages.store');
    Route::get('landing-pages/{landingPage}', [LandingPageController::class, 'show'])->name('landing-pages.show');
    Route::get('landing-pages/{landingPage}/edit', [LandingPageController::class, 'edit'])->name('landing-pages.edit');
    Route::put('landing-pages/{landingPage}', [LandingPageController::class, 'update'])->name('landing-pages.update');
    Route::delete('landing-pages/{landingPage}', [LandingPageController::class, 'destroy'])->name('landing-pages.destroy');

    // Domain routes
    Route::get('domains', [DomainController::class, 'index'])->name('domains.index');
    Route::get('domains/create', [DomainController::class, 'create'])->name('domains.create');
    Route::post('domains', [DomainController::class, 'store'])->name('domains.store');
    Route::get('domains/{domain}', [DomainController::class, 'show'])->name('domains.show');
    Route::get('domains/{domain}/edit', [DomainController::class, 'edit'])->name('domains.edit');
    Route::put('domains/{domain}', [DomainController::class, 'update'])->name('domains.update');
    Route::delete('domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');
});

require __DIR__ . '/auth.php';

Route::get('{username}', [PublicProfileController::class, 'show']);
Route::get('{username}/domains', [PublicProfileController::class, 'domains']);
