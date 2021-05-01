<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Role::create(['name' => 'User', 'guard_name' => 'user']);

        Permission::create(['name'=>'Create-Cities','guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Cities','guard_name'=>'admin']);
        Permission::create(['name'=>'Update-Cities','guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Cities','guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Admins','guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Admins','guard_name'=>'admin']);
        Permission::create(['name'=>'Update-Admins','guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Admins','guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Doctors','guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Doctors','guard_name'=>'admin']);
        Permission::create(['name'=>'Update-Doctors','guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Doctors','guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Patients','guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Patients','guard_name'=>'admin']);
        Permission::create(['name'=>'Update-Patients','guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Patients','guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Secrataries','guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Secrataries','guard_name'=>'admin']);
        Permission::create(['name'=>'Update-Secrataries','guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Secrataries','guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Users','guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Users','guard_name'=>'admin']);
        Permission::create(['name'=>'Update-Users','guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Users','guard_name'=>'admin']);

        Permission::create(['name' => 'Create-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Roles', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Permissions', 'guard_name' => 'admin']);


        /** Permossions USER **/

        Permission::create(['name'=>'Create-Cities','guard_name'=>'user']);
        Permission::create(['name'=>'Read-Cities','guard_name'=>'user']);
        Permission::create(['name'=>'Update-Cities','guard_name'=>'user']);
        Permission::create(['name'=>'Delete-Cities','guard_name'=>'user']);

        Permission::create(['name'=>'Create-Doctors','guard_name'=>'user']);
        Permission::create(['name'=>'Read-Doctors','guard_name'=>'user']);
        Permission::create(['name'=>'Update-Doctors','guard_name'=>'user']);
        Permission::create(['name'=>'Delete-Doctors','guard_name'=>'user']);

        Permission::create(['name'=>'Create-Patients','guard_name'=>'user']);
        Permission::create(['name'=>'Read-Patients','guard_name'=>'user']);
        Permission::create(['name'=>'Update-Patients','guard_name'=>'user']);
        Permission::create(['name'=>'Delete-Patients','guard_name'=>'user']);

        Permission::create(['name'=>'Create-Secrataries','guard_name'=>'user']);
        Permission::create(['name'=>'Read-Secrataries','guard_name'=>'user']);
        Permission::create(['name'=>'Update-Secrataries','guard_name'=>'user']);
        Permission::create(['name'=>'Delete-Secrataries','guard_name'=>'user']);

        Permission::create(['name'=>'Create-Users','guard_name'=>'user']);
        Permission::create(['name'=>'Read-Users','guard_name'=>'user']);
        Permission::create(['name'=>'Update-Users','guard_name'=>'user']);
        Permission::create(['name'=>'Delete-Users','guard_name'=>'user']);
    }
}
