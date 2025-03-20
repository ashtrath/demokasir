<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DetailSale extends Model
{
    use HasFactory;

    protected $guarded = [
        "id"
    ];

    protected $with = ["item"];

    public function item() {
        return $this->belongsTo(Item::class);
    }

    static public function boot() {
        parent::boot();

        static::created(function (DetailSale $detailSale) {
            $detailSale->item->decrement("stock", $detailSale->qty);
        });
    }
}
