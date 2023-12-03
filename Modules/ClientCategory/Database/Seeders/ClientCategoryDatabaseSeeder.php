<?php

namespace Modules\ClientCategory\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\ClientCategory\Models\ClientCategory;

class ClientCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        ClientCategory::firstOrCreate([
            'name_en' => 'fixed',
            'name_ar' => 'الأساسي',
            'description_en' => 'fixed description',
            'description_ar' => 'تفاصيل الأساسي',
            'is_default' => true,
            'status' => true,
        ]);
    }
}
