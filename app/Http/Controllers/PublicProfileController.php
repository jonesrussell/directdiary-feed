<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show($username)
    {
        logger($username);
        return Inertia::render('PublicProfile', [
            'profile' => User::where('username', '=', $username)->first(),
        ]);
    }
}
