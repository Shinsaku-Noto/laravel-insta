<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = $this->category;
        $category->name = $request->category;
        $category->save();

        return redirect()->route('admin.categories');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = $this->category->findOrFail($id);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories');
    }
}
