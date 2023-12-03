<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
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
            'name' => 'role_view',
            'group' => 'Roles',
            'guard_name' => 'admins'
        ]);

    }

    public function createPermission()
    {
            Permission::factory()->create([
                'name' => 'role_create',
                'group' => 'Roles',
                'guard_name' => 'admins'
            ]);
    }

    public function updatePermission()
    {
            Permission::factory()->create([
                'name' => 'role_update',
                'group' => 'Roles',
                'guard_name' => 'admins'
            ]);


    }
}
