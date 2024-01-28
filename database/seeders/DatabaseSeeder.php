<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ProductType::factory()
            ->count(3)
            ->create()
            ->each(function ($productType) {
                $productType->products()->saveMany(
                    Product::factory()->count(3)->make()
                )->each(function ($product) {
                    $product->variants()->saveMany(
                        Variant::factory()->count(3)->make()
                    );
                });
            });

    }
}
