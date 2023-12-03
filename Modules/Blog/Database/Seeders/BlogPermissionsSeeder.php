<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class BlogPermissionsSeeder extends Seeder
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
            'name' => 'blog_view',
            'group' => 'blogs',
            'guard_name' => 'admins'
        ]);

    }

    public function createPermission()
    {
        Permission::factory()->create([
            'name' => 'blog_create',
            'group' => 'blogs',
            'guard_name' => 'admins'
        ]);
    }

    public function updatePermission()
    {
        Permission::factory()->create([
            'name' => 'blog_update',
            'group' => 'blogs',
            'guard_name' => 'admins'
        ]);


    }
}
