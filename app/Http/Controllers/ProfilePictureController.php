<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfilePictureController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->clearMediaCollection('avatar');
        $avatar = $user
            ->addMedia($request->file('avatar'))
            ->toMediaCollection('avatar');
        logger($avatar);
    }

    public function destroy($id)
    {
    }
}
