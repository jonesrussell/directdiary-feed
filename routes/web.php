<?php

use App\Http\Controllers\Chat\ConversationController;
use App\Http\Controllers\Chat\ConversationMessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\PublicProfileDomainsController;
use App\Models\Post;
use Illuminate\Foundation\Application;
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
    if (auth()->check()) {
        return redirect('/home');
    }
    return Inertia::render('Welcome');
})->middleware('guest')->name('welcome');

Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
Route::delete('/posts/{id}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');

Route::middleware('auth')->group(function () {
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
});

require __DIR__ . '/auth.php';

Route::get('{username}', [PublicProfileController::class, 'show']);
Route::get('{username}/domains', [PublicProfileController::class, 'domains']);

// Remove or comment out this line if it exists
// Route::redirect('/', '/home')->middleware('auth');
