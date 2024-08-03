<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache roles dan permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions
        Permission::create(['name' => 'create nasabah']);
        Permission::create(['name' => 'edit nasabah']);
        Permission::create(['name' => 'delete nasabah']);
        Permission::create(['name' => 'view nasabah']);
        Permission::create(['name' => 'create pinjaman']);
        Permission::create(['name' => 'edit pinjaman']);
        Permission::create(['name' => 'delete pinjaman']);
        Permission::create(['name' => 'view pinjaman']);
        Permission::create(['name' => 'create angsuran']);
        Permission::create(['name' => 'edit angsuran']);
        Permission::create(['name' => 'delete angsuran']);
        Permission::create(['name' => 'view angsuran']);
        Permission::create(['name' => 'create simpanan']);
        Permission::create(['name' => 'edit simpanan']);
        Permission::create(['name' => 'delete simpanan']);
        Permission::create(['name' => 'view simpanan']);
        Permission::create(['name' => 'view rekap_keuangan']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view user']);
        
        // Buat roles dan berikan permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'teller']);
        $role->givePermissionTo([
            'create nasabah',
            'edit nasabah',
            'view nasabah',
            'create pinjaman',
            'edit pinjaman',
            'view pinjaman',
            'create angsuran',
            'edit angsuran',
            'view angsuran',
            'create simpanan',
            'edit simpanan',
            'view simpanan',
        ]);

        $role = Role::create(['name' => 'nasabah']);
        $role->givePermissionTo();
    }
}
