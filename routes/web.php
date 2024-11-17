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
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Main domain routes (highest priority)
Route::domain(config('app.url'))->middleware('web')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/', function() {
            Log::debug('Main domain root route hit');
            return Inertia::render('Welcome');
        })->name('welcome');
    });
    
    // 2. Standard Application Routes
    Route::middleware('web')->group(function () {
        // Authenticated Routes
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('/home', function() {
                Log::debug('Routes: Matching authenticated home route');
                return Inertia::render('Home');
            })->name('home');
            Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');
            
            // Posts Routes
            Route::prefix('posts')->name('posts.')->group(function () {
                Route::post('/', [PostController::class, 'store'])->name('store');
                Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');
            });

            // Profile Routes
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('edit');
                Route::patch('/', [ProfileController::class, 'update'])->name('update');
                Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
                
                Route::prefix('picture')->name('picture.')->group(function () {
                    Route::get('/', [ProfilePictureController::class, 'index'])->name('index');
                    Route::get('/create', [ProfilePictureController::class, 'create'])->name('create');
                    Route::post('/', [ProfilePictureController::class, 'store'])->name('store');
                });
            });

            // Conversations Routes
            Route::resource('messages', ConversationController::class)->names('conversations');

            Route::prefix('msg/{conversationId}')->name('messages.')->group(function () {
                Route::get('/', [ConversationMessageController::class, 'index'])->name('index');
                Route::get('/{messageId}', [ConversationMessageController::class, 'show'])->name('show');
                Route::post('/', [ConversationMessageController::class, 'store'])->name('store');
                Route::delete('/', [ConversationMessageController::class, 'deleteAll'])->name('deleteAll');
                Route::delete('/{messageId}', [ConversationMessageController::class, 'destroy'])->name('destroy');
            });

            // Landing Page Routes
            Route::prefix('landing-pages')->name('landing-pages.')->group(function () {
                Route::get('/', [LandingPageController::class, 'index'])->name('index');
                Route::get('/create', [LandingPageController::class, 'create'])->name('create');
                Route::post('/', [LandingPageController::class, 'store'])->name('store');
                Route::get('/{landingPage}', [LandingPageController::class, 'show'])->name('show');
                Route::get('/{landingPage}/edit', [LandingPageController::class, 'edit'])->name('edit');
                Route::put('/{landingPage}', [LandingPageController::class, 'update'])->name('update');
                Route::delete('/{landingPage}', [LandingPageController::class, 'destroy'])->name('destroy');
            });

            // Domain Routes
            Route::prefix('domains')->name('domains.')->group(function () {
                Route::get('/', [DomainController::class, 'index'])->name('index');
                Route::get('/create', [DomainController::class, 'create'])->name('create');
                Route::post('/', [DomainController::class, 'store'])->name('store');
                Route::get('/{domain}', [DomainController::class, 'show'])->name('show');
                Route::delete('/{domain}', [DomainController::class, 'destroy'])->name('destroy');
            });
        });

        require __DIR__ . '/auth.php';

        // 3. Username-based Routes (lowest priority, catch-all)
        Route::get('{username}', function($username) {
            Log::debug('Routes: Attempting to match username route', ['username' => $username]);
            return app()->call([app(PublicProfileController::class), 'show'], ['username' => $username]);
        })->where('username', '[A-Za-z0-9_]+');
        
        Route::get('{username}/domains', function($username) {
            Log::debug('Routes: Attempting to match username domains route', ['username' => $username]);
            return app()->call([app(PublicProfileController::class), 'domains'], ['username' => $username]);
        })->where('username', '[A-Za-z0-9_]+');
    });
});

// 2. Custom Domain Routes
Route::group(['domain' => '{subdomain}.ddev.site', 'middleware' => ['web', 'custom.domain']], function () {
    Route::get('/', function() {
        $username = request()->route('username');
        
        Log::debug('Custom domain root route', [
            'username' => $username,
            'host' => request()->getHost(),
            'subdomain' => request()->route('subdomain')
        ]);
        
        if (!$username) {
            Log::error('No username set for custom domain');
            abort(404);
        }
        
        // Directly return the public profile view
        return app(PublicProfileController::class)->show($username);
    })->name('custom-domain.profile');
    
    Route::get('/domains', function() {
        Log::info('Routes: Custom domain domains route hit', [
            'host' => request()->getHost(),
            'username' => request()->route('username')
        ]);
        
        return app()->call([app(PublicProfileController::class), 'domains'], [
            'username' => request()->route('username')
        ]);
    })->name('custom-domain.domains');
});
