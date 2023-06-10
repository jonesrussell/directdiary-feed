<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Inertia\Inertia;

class ExploreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Explore', [
            'posts' => PostResource::collection(Post::orderBy('created_at', 'desc')->get()),
        ]);
    }
}
