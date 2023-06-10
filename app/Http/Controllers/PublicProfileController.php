<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\User;
use Inertia\Inertia;

class PublicProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show($username)
    {
        $user = User::with(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->where('username', '=', $username)->first();

        if ($user) {
            $user->posts = (new PostCollection($user->posts))->toArray(request());
        }

        return Inertia::render('PublicProfile', [
            'profile' => $user,
        ]);
    }

    public function domains($username)
    {
        $user = User::with('domains')->where('username', '=', $username)->first();

        return Inertia::render('UserDomains', [
            'domains' => $user->domains,
        ]);
    }
}
