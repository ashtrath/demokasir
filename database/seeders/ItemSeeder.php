<?php

namespace Database\Seeders;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::insert([
            [
                "category_id" => 1,
                "name" => "Minyak Bimoli",
                "image" => "images/XoAHr2eft2JGlzb9zLgsL1BHRDPHlHOIUs7HWAsq.jpg",
                "stock" => 100,
                "buy_price" => 16000,
                "sell_price" => 20000,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "category_id" => 2,
                "name" => "Beras Super Sylph",
                "image" => "images\jpMupOwrJnxQaBnkxD4BOpX4zmw8Ff8iM6CjYHD8.jpg",
                "stock" => 100,
                "buy_price" => 250000,
                "sell_price" => 275000,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "category_id" => 3,
                "name" => "Telur",
                "image" => "images\g66gRL4zjb8DlTNTv1EFnv1JW0Kcx8XHWvBm2nqA.webp",
                "stock" => 150,
                "buy_price" => 20000,
                "sell_price" => 23000,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ]);
    }
}
