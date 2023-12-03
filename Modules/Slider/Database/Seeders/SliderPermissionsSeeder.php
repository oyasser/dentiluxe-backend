<?php

namespace Modules\Slider\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SliderPermissionsSeeder extends Seeder
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
            'name' => 'slider_view',
            'group' => 'Sliders',
            'guard_name' => 'admins'
        ]);
    }

    public function createPermission()
    {
            Permission::factory()->create([
                'name' => 'slider_create',
                'group' => 'Sliders',
                'guard_name' => 'admins'
            ]);
    }

    public function updatePermission()
    {
            Permission::factory()->create([
                'name' => 'slider_update',
                'group' => 'Sliders',
                'guard_name' => 'admins'
            ]);
    }
}
