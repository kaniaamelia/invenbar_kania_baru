<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear pivot table data first
        DB::table('model_has_permissions')->delete();
        DB::table('role_has_permissions')->delete();

        // Now delete permissions and roles
        Permission::query()->delete();
        Role::query()->delete();

        $permissions = [
            'manage barang',
            'delete barang',
            'view kategori',
            'manage kategori',
            'view lokasi',
            'manage lokasi',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);

        $petugasRole->syncPermissions([
            'manage barang',
            'view kategori',
            'view lokasi',
        ]);

        $adminRole->syncPermissions(Permission::all());
    }
}


