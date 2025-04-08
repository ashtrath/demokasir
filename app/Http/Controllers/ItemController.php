<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("items/index", [
            "items" => Item::search()->sort()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("items/add", [
            "categories" => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile("image")) {
            $file = $request->file("image")->store("images", "public");

            $data["image"] = $file;
        }

        if (Item::create($data)) {
            return to_route("items.index")->with("success", "Success add new item");
        }

        return back()->with("error", "Cannot add new item, try again");
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return Inertia::render("items/edit", [
            "categories" => Category::all(),
            "item" => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $data = $request->validated();
        $oldPath = "";

        if ($request->hasFile("image")) {
            $file = $request->file("image")->store("images", "public");
            $oldPath = $item->image ?? "";
            $data["image"] = $file;
        }

        if ($item->update($data)) {
            if ($request->hasFile("image")) {
                Storage::disk('public')->delete($oldPath);
            }
            return to_route("items.index")->with("success", "Success update item $item->name");
        }

        return back()->with("error", "Cannot update item, try again");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if ($item->delete()) {
            Storage::disk('public')->delete($item->image ?? '');
            return back()->with("success", "Success delete $item->name item");
        }
        return back()->with("error", "Error deleting item $item->name");
    }
}
