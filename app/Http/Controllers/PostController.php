<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as MyHttpRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Welcome', [
            'posts' => PostResource::collection(Post::with('user')->orderBy('id', 'desc')->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MyHttpRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(MyHttpRequest $request): RedirectResponse
    {
        $validated = $request->validate([
            'post' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,mp4',
        ]);

        $user = Auth::user();
        /* @var User $user */
        $post = $user->posts()->create($validated);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $isVideo = $file->getMimeType() === 'video/mp4';

            $post->addMedia($file)
                 ->toMediaCollection($isVideo ? 'video' : 'image');

            $post->is_video = $isVideo;
            $post->save();
        }

        return redirect()->back()->with('success', 'Post created successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        try {
            $this->authorize('delete', $post);
        } catch (AuthorizationException $e) {

        }

        $post->clearMediaCollection('image');
        $post->clearMediaCollection('video');
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }
}
