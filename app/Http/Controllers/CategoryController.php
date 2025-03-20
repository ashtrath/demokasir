<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("categories/index", [
            "categories" => Category::search()->sort()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("categories/add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if (Category::create($request->validated())) {
            return to_route('categories.index')->with("success", "Category has been added");
        }

        return back()->with("error", "Cannot create category, try again");
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
        return Inertia::render("categories/edit", [
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($category->update($request->validated())) {
            return to_route("categories.index")->with("success", "Success update $category->name category");
        }

        return back()->with("error", "Cannot update category $category->name, try again");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return back()->with("success", "Category $category->name removed");
        }

        return back()->with("error", "Cannot removed $category->name category");
    }
}
