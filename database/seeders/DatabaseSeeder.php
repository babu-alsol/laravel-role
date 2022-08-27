<?php

use Database\Seeders\CategorySedeer;
use Database\Seeders\demo;
use Database\Seeders\PostSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(RolePermissionSeeder::class);
        //$this->call(CategorySedeer::class);
        //$this->call(demo::class);
    }
}
