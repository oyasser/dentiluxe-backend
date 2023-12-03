<?php

namespace Modules\Admin\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Admin\Models\Admin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(): void
    {
        $this->superAdminRole();
    }

    /**
     * Create Super admin Rules and Permissions
     */
    private function superAdminRole(): void
    {
        $this->command->info('Checking if super admin already exists ...');

        $admin = Admin::where('email', 'admin@greentank.eg')->first();

        if (!$admin) {
            $admin = Admin::create([
                'name'     => 'Super Admin',
                'email'    => 'admin@greentank.eg',
                'password' => 'secret', // $2y$10$oPCcCpaPQ69KQ1fdrAIL0eptYCcG/s/NmQZizJfVdB.QOXUn5mGE6
            ]);

            //https://github.com/laravel/laravel/pull/3456
            //Use a precomputed hash of the word "secret" instead of using bcrypt directly
            $this->command->info('Super Admin Created with this credentials:');
            $this->command->info("Email: {$admin->email}");
            $this->command->info("Password: secret");
        }

        // create roles and assign existing permissions
        $this->command->info('Checking if super admin Role ...');

        $role        = Role::firstOrCreate(['name' => 'super_admin','guard_name' => 'admins']);

        $this->command->info('Assign Super admin Role ...');

        $admin->assignRole($role);
    }
}
