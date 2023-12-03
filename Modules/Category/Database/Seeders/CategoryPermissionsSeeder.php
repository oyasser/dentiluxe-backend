<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CategoryPermissionsSeeder extends Seeder
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
            'name' => 'category_view',
            'group' => 'Categories',
            'guard_name' => 'admins'
        ]);
    }

    public function createPermission()
    {
            Permission::factory()->create([
                'name' => 'category_create',
                'group' => 'Categories',
                'guard_name' => 'admins'
            ]);
    }

    public function updatePermission()
    {
            Permission::factory()->create([
                'name' => 'category_update',
                'group' => 'Categories',
                'guard_name' => 'admins'
            ]);
    }
}
