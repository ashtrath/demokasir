<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $guarded = [
        "id"
    ];

    static public function boot()
    {
        parent::boot();

        static::deleting(function (Sale $sale) {
            $sale->detailSale->each(function ($value) {
                $value->delete();
            });
        });
    }

    public function detailSale()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function scopeSort(Builder $query)
    {
        return $query->orderBy(request("sort") ?? "created_at");
    }
}
