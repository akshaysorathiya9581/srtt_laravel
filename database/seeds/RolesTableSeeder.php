<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
           'Super-Admin',
           'Employee',
           'Customer',
           'Accounter'
        ];

        foreach ($roles as $role) {
             Role::create(['name' => $role]);
        }
    }
}
