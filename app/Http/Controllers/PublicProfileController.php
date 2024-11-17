<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\User;
use Inertia\Inertia;

class PublicProfileController extends Controller
{
    public function show($username = null)
    {
        if (!$username && !request()->route()->parameter('username')) {
            abort(404);
        }

        return $this->showUnified($username ?? request()->route()->parameter('username'), 'posts');
    }

    public function domains($username)
    {
        return $this->showUnified($username, 'domains');
    }

    public function showUnified($username, $view)
    {
        $user = User::with(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'domains'])->where('username', '=', $username)->first();

        if (!$user) {
            abort(404);
        }

        if ($user) {
            $user->posts = (new PostCollection($user->posts))->toArray(request());
        }

        return Inertia::render('PublicProfile', [
            'profile' => $user,
            'view' => $view,
            'isCustomDomain' => request()->getHost() !== config('app.url')
        ]);
    }
}
