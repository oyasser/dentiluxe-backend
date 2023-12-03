<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nwidart\Modules\Facades\Module;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $modulesSeedes = collect(Module::all())->map(function ($module) {
            return config('modules.namespace') . '\\' . $module->getName() . '\\Database\Seeders\\' . $module->getName() . 'DatabaseSeeder';
        })->values()->toArray();
        $this->call($modulesSeedes);
    }
}
