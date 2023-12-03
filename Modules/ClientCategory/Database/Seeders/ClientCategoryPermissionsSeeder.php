<?php

namespace Modules\ClientCategory\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ClientCategoryPermissionsSeeder extends Seeder
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
            'name' => 'client_category_view',
            'group' => 'Client Categories',
            'guard_name' => 'admins'
        ]);

    }

    public function createPermission()
    {
            Permission::factory()->create([
                'name' => 'client_category_create',
                'group' => 'Client Categories',
                'guard_name' => 'admins'
            ]);
    }

    public function updatePermission()
    {
            Permission::factory()->create([
                'name' => 'client_category_update',
                'group' => 'Client Categories',
                'guard_name' => 'admins'
            ]);


    }
}
