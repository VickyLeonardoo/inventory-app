<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Membuat beberapa role
        //Membuat default user untuk super admin

        $superAdminRole = Role::create([
            'name' => 'superadmin',
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
        ]);

        $supervisor = Role::create([
            'name' => 'supervisor',
        ]);

        $staffInventory = Role::create([
            'name' => 'staff',
        ]);

        //Super admin
        $userSuperAdmin = User::create([
            'name' => 'Vicky Leonardo',
            'email' => 'admin@example.com',
            'password' => bcrypt('123'),
        ]);

        $userSuperAdmin->assignRole($superAdminRole);

    }
}
