<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{

    private $post;
    private $category;
    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->all();

        return view('users.posts.create')
                ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->post->user_id = Auth::user()->id;
        $this->post->image =  'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        if($request->category)
        {
            foreach ($request->category as $category_id) {
                $category_post[] = ["category_id" => $category_id];
            }

            $this->post->categoryPost()->createMany($category_post);
        }else{
            return redirect()->route('index');
        }



        return redirect()->route('index');

    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('users.posts.show')
                ->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = $this->category->all();

        if($post->categoryPost->isEmpty()){
            $pivots = [0];
        }else{
            foreach ($post->categoryPost as $category)
            {
                $pivots[] = $category->category_id;
            }
        }



        return view('users.posts.edit')
        ->with('post', $post)
        ->with('categories', $categories)
        ->with('pivots', $pivots);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->user_id = Auth::user()->id;
        if($request->image){
            $post->image =  'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        }
        $post->description = $request->description;
        $post->save();

        foreach ($request->category as $category_id) {
            $category_post[] = ["category_id" => $category_id, "post_id" => $post->id];
        }

        $post->categoryPost()->delete();

        $post->categoryPost()->createMany($category_post);

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();

        return redirect()->route('index');
    }
}
