<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    protected $with = ["category"];
    
    protected $guarded = [
        "id"
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function scopeSort(Builder $query) {
        return $query->when(request("sort") == "category", function(Builder $query, bool $value) {
            return $query->orderBy(Category::select("name")->whereColumn("categories.id", "items.id"));
        }, function(Builder $query) {
            return $query->orderBy(request("sort") ?? "created_at");
        });
    }

    public function scopeSearch(Builder $query) {
        $keyword = request("search");
        return $query->where("name", "LIKE", "%$keyword%")->orWhere("stock", "<=", "$keyword")->orWhere("buy_price", "<=", "$keyword")->orWhere("sell_price", "<=", "$keyword")->orWhereHas("category", function(Builder $category) use ($keyword) {
            return $category->where("name", "LIKE", "%$keyword%");
        });
    }

    // static public function boot() {
    //     parent::boot();

    //     static::creating(function (Item $item) {
    //         if (!$item->user_id) {
    //             $item->user_id = Auth::id();
    //         }
    //     });
    // }
}