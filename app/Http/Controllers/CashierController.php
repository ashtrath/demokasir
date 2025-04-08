<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierPostRequest;
use App\Models\DetailSale;
use App\Models\Item;
use App\Models\Sale;
use Inertia\Inertia;

class CashierController extends Controller
{
    public function index()
    {
        return Inertia::render("cashier", [
            "items" => Item::search()->get(),
        ]);
    }

    public function store(CashierPostRequest $request)
    {
        $request->validated();

        $request["total"] = array_reduce($request->items, function ($init, $value) {
            return $init += $value['sell_price'] * $value['qty'];
        }, 0);
        $request["change"] = $request->total - $request->cash_tendered;

        // Create sale data array
        $saleData = $request->all();

        // If a custom datetime is provided, use it for created_at
        if ($request->has('sale_datetime')) {
            $saleData['created_at'] = $request->sale_datetime;
        }

        if ($sale = Sale::create($saleData)) {
            foreach ($request->items as $item) {
                DetailSale::create([
                    "sale_id" => $sale->id,
                    "item_id" => $item["id"],
                    "qty" => $item["qty"],
                    "price" => $item["sell_price"],
                    "total" => $item["qty"] * $item["sell_price"],
                    // Apply the same datetime to detail records if needed
                    "created_at" => $sale->created_at
                ]);
            }

            return back()->with("success", "Purchase success, added to sales")->with('saleId', $sale->id);
        }
        return back()->with("error", "Cannot add to sales, try again");
    }
}
