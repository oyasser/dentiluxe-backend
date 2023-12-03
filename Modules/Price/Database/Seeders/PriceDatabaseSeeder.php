<?php

namespace Modules\Price\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Price\Models\Price;

class PriceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Price::firstOrCreate(
            ['slug_en' => 'stock-price'],
            [
                'name_en' => 'Stock Price',
                'name_ar' => 'سعر المخزن',
                'slug_ar' => 'سعر-المخزن',
                'status' => true,
                'is_default' => false,
            ]);

        Price::firstOrCreate(
            ['slug_en' => 'sales-price'],
            [
                'name_en' => 'Sales Price',
                'name_ar' => 'سعر البيع',
                'slug_ar' => 'سعر-البيع',
                'status' => true,
                'is_default' => true,
            ]);

        Price::factory()->create();
    }
}
