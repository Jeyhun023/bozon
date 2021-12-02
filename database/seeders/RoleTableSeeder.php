<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $defaultPermissions = config('default_permissions');


        $insertPermissions = function ($role) use ($defaultPermissions) {
            return  collect($defaultPermissions[$role])
                ->map(function ($name) {
                    return DB::table('permissions')->insertGetId(['name' => $name,'guard_name' => 'api','created_at' => now(),'updated_at' => now()]);
                })->toArray();
        };

        $permissionIdsByRole = [];

        foreach ($defaultPermissions as $role => $permissions){
            $permissionIdsByRole[$role] = $insertPermissions($role);
        }
        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $roleId = DB::table('roles')->insertGetId(['name' => $role,'guard_name' => 'api','created_at' => now(),'updated_at' => now()]);
            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(function ($id) use($roleId) {
                        return [
                            'role_id' => $roleId,
                            'permission_id' => $id
                        ];
                    })->toArray()
                );
        }
    }
}
