<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    protected $guarded = [
        "id"
    ];

    public function scopeSort(Builder $query) {
        return $query->orderBy(request("sort") ?? "created_at");
    }

    public function scopeSearch(Builder $query) {
        $keyword = request("search");
        return $query->whereAny([
            "code",
            "name"
        ], "LIKE", "%$keyword%");
    }

    // static public function boot() {
    //     parent::boot();

    //     static::creating(function (Category $category) {
    //         if (!$category->user_id) {
    //             $category->user_id = Auth::id();
    //         }
    //     });
    // }
}
