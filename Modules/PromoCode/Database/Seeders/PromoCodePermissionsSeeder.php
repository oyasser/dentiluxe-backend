<?php

namespace Modules\PromoCode\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PromoCodePermissionsSeeder extends Seeder
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
            'name' => 'promocode_view',
            'group' => 'promocodes',
            'guard_name' => 'admins'
        ]);

    }

    public function createPermission()
    {
        Permission::factory()->create([
            'name' => 'promocode_create',
            'group' => 'promocodes',
            'guard_name' => 'admins'
        ]);
    }

    public function updatePermission()
    {
        Permission::factory()->create([
            'name' => 'promocode_update',
            'group' => 'promocodes',
            'guard_name' => 'admins'
        ]);


    }
}
