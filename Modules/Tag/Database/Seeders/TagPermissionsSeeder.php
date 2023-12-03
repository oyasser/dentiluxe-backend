<?php

namespace Modules\Tag\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TagPermissionsSeeder extends Seeder
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
            'name' => 'tag_view',
            'group' => 'tags',
            'guard_name' => 'admins'
        ]);
    }

    public function createPermission()
    {
        Permission::factory()->create([
            'name' => 'tag_create',
            'group' => 'tags',
            'guard_name' => 'admins'
        ]);
    }

    public function updatePermission()
    {
        Permission::factory()->create([
            'name' => 'tag_update',
            'group' => 'tags',
            'guard_name' => 'admins'
        ]);
    }
}
