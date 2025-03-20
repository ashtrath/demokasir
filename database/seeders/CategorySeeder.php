<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                "code" => "C001",
                "name" => "Minyak",
                // "user_id" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "code" => "C002",
                "name" => "Beras",
                // "user_id" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "code" => "C003",
                "name" => "Telur",
                // "user_id" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]
        ]);
    }
}
