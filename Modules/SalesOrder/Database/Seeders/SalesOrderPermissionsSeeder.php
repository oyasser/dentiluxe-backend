<?php

namespace Modules\SalesOrder\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SalesOrderPermissionsSeeder extends Seeder
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
            'name' => 'sales_order_view',
            'group' => 'sales_orders',
            'guard_name' => 'admins'
        ]);

    }

    public function createPermission()
    {
        Permission::factory()->create([
            'name' => 'sales_order_create',
            'group' => 'sales_orders',
            'guard_name' => 'admins'
        ]);
    }

    public function updatePermission()
    {
        Permission::factory()->create([
            'name' => 'sales_order_update',
            'group' => 'sales_orders',
            'guard_name' => 'admins'
        ]);


    }
}
