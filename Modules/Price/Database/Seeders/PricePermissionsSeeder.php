<?php

namespace Modules\Price\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PricePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->readPermission();
        $this->createPermission();
        $this->updatePermission();
    }

    public function readPermission()
    {
        Permission::factory()->create([
            'name' => 'price_view',
            'group' => 'Prices',
            'guard_name' => 'admins'
        ]);
    }

    public function createPermission()
    {
            Permission::factory()->create([
                'name' => 'price_create',
                'group' => 'Prices',
                'guard_name' => 'admins'
            ]);
    }

    public function updatePermission()
    {
            Permission::factory()->create([
                'name' => 'price_update',
                'group' => 'Prices',
                'guard_name' => 'admins'
            ]);
    }
}
