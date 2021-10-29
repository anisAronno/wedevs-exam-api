<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();
        User::truncate();
        Role::truncate();
        Permission::truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();


        // Create Roles
        $roleSuperAdmin = Role::create([ 'name' => 'superadmin']);
        $roleUser = Role::create([ 'name' => 'user']);

        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password ='password';
        $user->save();

        $user = new User;
        $user->name = 'user';
        $user->email = 'user@gmail.com';
        $user->password ='password';
        $user->save();




        // Permission List as array
        $permissions = [

            [
                'group_name' => 'home',
                'permissions' => [
                    'home.view',
                ]
            ],

            [
                'group_name' => 'role',
                'permissions' => [
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ]
            ],
            [
                'group_name' => 'order',
                'permissions' => [
                    'order.create',
                    'order.view',
                    'order.edit',
                    'order.delete',
                    'order.approve',
                ]
            ],

            [
                'group_name' => 'product',
                'permissions' => [
                    'product.create',
                    'product.view',
                    'product.edit',
                    'product.delete',
                ]
            ],

            [
                'group_name' => 'user',
                'permissions' => [

                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                ]
            ],

            [
                'group_name' => 'profile',
                'permissions' => [
                    'profile.view',
                    'profile.create',
                    'profile.delete',
                    'profile.edit',
                ]
            ],

        ];


         // Create and Assign Permissions
         for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // User Permission

        $userPermissions = [
            'profile.view',
            'profile.edit',

            'order.view',
            'order.edit',
        ];

        $roleUser->syncPermissions($userPermissions);



    }
}
