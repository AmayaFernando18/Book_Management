<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BookCategory::withCount('books')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_cate,name',
        ]);

        BookCategory::create($request->only('name'));
        return redirect('/categories')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookCategory $category)
    {
        $category->load('books');
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_cate,name,' . $category->id,
        ]);

        $category->update($request->only('name'));
        return redirect('/categories')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCategory $category)
    {
        // Check if category has books
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Cannot delete category that has books assigned to it!');
        }

        $category->delete();
        return redirect('/categories')->with('success', 'Category deleted successfully!');
    }
}
