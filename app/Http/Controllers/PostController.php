<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Welcome', [
            'posts' => PostResource::collection(Post::orderBy('id', 'desc')->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = null;
        $extension = null;
        $fileName = null;
        $path = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $request->validate(['file' => 'required|mimes:jpg,jpeg,png,mp4']);
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $extension === 'mp4' ? $path = '/videos/' : $path = '/pics/';
        }

        $post = new Post;

        $user = Auth::user();
        $post->user_id = $user->id;
        $post->post = $request->input('post');
        if ($fileName) {
            $post->file = $path . $fileName;
            $post->is_video = $extension === 'mp4' ? true : false;
            $file->move(public_path() . $path, $fileName);
        }
        $post->comments = rand(5, 500);
        $post->reposts = rand(5, 500);
        $post->likes = rand(5, 500);

        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!is_null($post->file) && file_exists(public_path() . $post->file)) {
            unlink(public_path() . $post->file);
        }

        $post->delete();

        return redirect()->route('posts.index');
    }
}
