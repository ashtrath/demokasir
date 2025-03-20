<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'admin',
            'store_name' => 'Warung Sembako Bpk Okto',
            'store_address' => 'Jl. Dr. Ir. H. Soekarno No.19, Medokan Semampir, Surabaya',
            'store_phone' => '085187803544',
        ]);

        $this->call([
            CategorySeeder::class,
            ItemSeeder::class,
            SaleSeeder::class,
            DetailSaleSeeder::class
        ]);
    }
}
