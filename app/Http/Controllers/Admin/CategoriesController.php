<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;
use Auth;

class CategoriesController extends Controller
{
    private $category, $post;
    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    public function index()
    {
        $categories = $this->category->all();

        $posts = $this->post->all();
        
        $uncategorized = [];
        foreach($posts as $post) {
            if($post->categoryPost->isEmpty()){
                $uncategorized[] = $post;
            }
        }

        return view('admin.categories.index')
                ->with('categories', $categories)
                ->with('uncategorized', $uncategorized);
    }
}
