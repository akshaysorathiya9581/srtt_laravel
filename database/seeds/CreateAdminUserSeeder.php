<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Admin',
        	'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => '1',
            'roles' => '1',
        ]);

        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::pluck('id','id')->all();

        $user->syncPermissions($permissions);

        // $user->assignRole([$role->id]);
    }
}
