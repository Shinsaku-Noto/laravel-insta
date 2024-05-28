<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use Auth;

class PostsController extends Controller
{
    private $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $posts = $this->post->withTrashed()->get();

        return view('admin.posts.index')
                ->with('posts', $posts);
    }

    public function softdelete($id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts');
    }

    public function restore($id)
    {
        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('admin.posts');
    }
}
