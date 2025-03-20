<?php

namespace Database\Seeders;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::insert([
            [
                "cash_tendered" => 400000,
                "total" => 315000,
                "change" => 85000,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "cash_tendered" => 300000,
                "total" => 275000,
                "change" => 25000,
                "created_at" => Carbon::now()->subDay(),
                "updated_at" => Carbon::now()->subDay()
            ],
            [
                "cash_tendered" => 750000,
                "total" => 710000,
                "change" => 40000,
                "created_at" => Carbon::now()->subDays(2),
                "updated_at" => Carbon::now()->subDays(2)
            ],
            [
                "cash_tendered" => 50000,
                "total" => 20000,
                "change" => 30000,
                "created_at" => Carbon::now()->subDays(3),
                "updated_at" => Carbon::now()->subDays(3)
            ],
        ]);
    }
}
