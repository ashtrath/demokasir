<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $with = ["category"];

    protected $guarded = [
        "id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSort(Builder $query)
    {
        return $query->when(request("sort") == "category", function (Builder $query, bool $value) {
            return $query->orderBy(Category::select("name")->whereColumn("categories.id", "items.id"));
        }, function (Builder $query) {
            return $query->orderBy(request("sort") ?? "created_at");
        });
    }

    public function scopeSearch(Builder $query)
    {
        $keyword = request('search');
        if (empty($keyword)) {
            return $query;
        }

        $query->where(function (Builder $subQuery) use ($keyword) {
            $subQuery->where("name", "LIKE", "%$keyword%")
                ->orWhereHas("category", function (Builder $category) use ($keyword) {
                    $category->where("name", "LIKE", "%$keyword%");
                });
        });

        if (is_numeric($keyword)) {
            $numericKeyword = (float) $keyword; // Cast to number
            $query->orWhere("stock", "<=", $numericKeyword)
                ->orWhere("buy_price", "<=", $numericKeyword)
                ->orWhere("sell_price", "<=", $numericKeyword);
        }

        return $query;
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
