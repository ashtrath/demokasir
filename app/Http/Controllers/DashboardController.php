<?php

namespace App\Http\Controllers;

use App\Models\DetailSale;
use App\Models\Item;
use App\Models\Sale;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        return Inertia::render("index", [
            "total_revenue" => Sale::whereDate('created_at', Carbon::today())->sum("total"),
            "total_items" => Item::count(),
            "total_orders" => Sale::count(),
            "recent_orders" => DetailSale::limit(5)->get(),
            "charts" => Sale::selectRaw("DATE(created_at) as date, SUM(total) as total")->whereMonth("created_at", request("month") ?? Carbon::today()->month)->whereYear("created_at", request("year") ?? Carbon::today()->year)->groupBy("date")->orderBy("date")->get()->map(fn(mixed $value) => [$value->date, $value->total])
        ]);
    }
}
