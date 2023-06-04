<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
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
            'tweets' => Tweet::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}