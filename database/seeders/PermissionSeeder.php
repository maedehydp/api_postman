<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_delete = Permission::Create(['name' => 'admin.delete']);
        $seller_update = Permission::Create(['name' => 'seller.update']);

        $user = Role::create(['name' => 'admin']);

        $user->givePermissionTo([$admin_delete, $seller_update]);
    }
}
