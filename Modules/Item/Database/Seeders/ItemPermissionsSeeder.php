<?php

namespace Modules\Item\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ItemPermissionsSeeder extends Seeder
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
            'name' => 'item_view',
            'group' => 'Items',
            'guard_name' => 'admins'
        ]);
    }

    public function createPermission()
    {
            Permission::factory()->create([
                'name' => 'item_create',
                'group' => 'Items',
                'guard_name' => 'admins'
            ]);
    }

    public function updatePermission()
    {
            Permission::factory()->create([
                'name' => 'item_update',
                'group' => 'Items',
                'guard_name' => 'admins'
            ]);
    }
}
