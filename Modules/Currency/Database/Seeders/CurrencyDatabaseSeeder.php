<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Currency\Models\Currency;

class CurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Currency::firstOrCreate(
            ['name_en' => 'EGP'],
            [
                'name_ar' => 'الجنيه المصري',
                'rate' => 1,
                'is_default' => true,
                'status' => true
            ]);
    }
}
