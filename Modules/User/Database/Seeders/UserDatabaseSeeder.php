<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Database\Seeders\AdminRolesAndPermissionsSeeder;
use Spatie\Permission\PermissionRegistrar;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call(AdminRolesAndPermissionsSeeder::class);
        $this->command->info("Admin with roles and permissions created successfully!.");
        $this->command->info("Creating dummy data....");
    }
}
