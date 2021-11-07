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
                    'role.view',
                    'role.create',
                    'role.store',
                    'role.show',
                    'role.edit',
                    'role.update',
                    'role.delete',
                    'role.approve',
                ]
            ],
            [
                'group_name' => 'order',
                'permissions' => [
                    'order.view',
                    'order.create',
                    'order.store',
                    'order.show',
                    'order.edit',
                    'order.update',
                    'order.delete',
                    'order.approve',
                ]
            ],

            [
                'group_name' => 'product',
                'permissions' => [
                    'product.view',
                    'product.create',
                    'product.store',
                    'product.show',
                    'product.edit',
                    'product.update',
                    'product.delete',
                    'product.approve',
                ]
            ],

            [
                'group_name' => 'user',
                'permissions' => [
                    'user.view',
                    'user.create',
                    'user.store',
                    'user.show',
                    'user.edit',
                    'user.update',
                    'user.delete',
                    'user.approve',
                ]
            ],

            [
                'group_name' => 'profile',
                'permissions' => [
                    'profile.view',
                    'profile.create',
                    'profile.store',
                    'profile.show',
                    'profile.edit',
                    'profile.update',
                    'profile.delete',
                    'profile.approve',
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
            'profile.update',
            'order.view',
            'order.edit',
        ];

        $roleUser->syncPermissions($userPermissions);



        $admin = new User;
        $admin->name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password ='password';
        if( $admin->save()){
            $admin->assignRole('superadmin');
        }

        $user = new User;
        $user->name = 'user';
        $user->email = 'user@gmail.com';
        $user->password ='password';
        $user->save();
        if( $user->save()){
            $user->assignRole('user');
        }



    }
}
