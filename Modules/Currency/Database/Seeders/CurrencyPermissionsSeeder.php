<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CurrencyPermissionsSeeder extends Seeder
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
            'name' => 'currency_view',
            'group' => 'Currencies',
            'guard_name' => 'admins'
        ]);

    }

    public function createPermission()
    {
            Permission::factory()->create([
                'name' => 'currency_create',
                'group' => 'Currencies',
                'guard_name' => 'admins'
            ]);
    }

    public function updatePermission()
    {
            Permission::factory()->create([
                'name' => 'currency_update',
                'group' => 'Currencies',
                'guard_name' => 'admins'
            ]);


    }
}
