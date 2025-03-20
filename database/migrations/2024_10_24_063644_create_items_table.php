<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id")->nullable()->constrained("categories")->references("id")->on("categories");
            // $table->foreignId("user_id")->constrained("users")->references("id")->on("users");
            $table->string("name", 255);
            $table->string("image", 255)->nullable();
            $table->integer("stock");
            $table->integer("sell_price");
            $table->integer("buy_price");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
