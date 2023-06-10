<?php

namespace App\Http\Controllers;

use App\Http\Resources\DomainCollection;
use App\Models\User;
use Inertia\Inertia;

class PublicProfileDomainsController extends Controller
{
    /**
     * Display the user's domains.
     */
    public function show($username)
    {
        $user = User::with('domains')->where('username', '=', $username)->first();

        if ($user) {
            $user->domains = (new DomainCollection($user->domains))->toArray(request());
        }

        return Inertia::render('UserDomains', [
            'profile' => $user,
        ]);
    }
}
