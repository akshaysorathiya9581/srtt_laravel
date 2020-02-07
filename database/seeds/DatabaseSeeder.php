<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        // $this->call(ServicesTableSeeder::class);
        $this->call(MealpreferenceSeeder::class);
        $this->call(SeatpreferenceSeeder::class);
        
    }
}
