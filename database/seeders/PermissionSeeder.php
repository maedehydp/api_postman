<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_index = Permission::create(['name' => 'user_index']);
        $user_destroy = Permission::create(['name' => 'user_destroy']);
        $user_update = Permission::create(['name' => 'user_update']);
        $product_index = Permission::create(['name' => 'product_index']);
        $product_filter = Permission::create(['name' => 'product_filter']);
        $product_store = Permission::create(['name' => 'product_store']);
        $product_update = Permission::create(['name' => 'product_update']);
        $product_destroy = Permission::create(['name' => 'product_destroy']);
        $order_index = Permission::create(['name' => 'order_index']);
        $order_filter = Permission::create(['name' => 'order_filter']);
        $order_store = Permission::create(['name' => 'order_store']);
        $order_update = Permission::create(['name' => 'order_update']);
        $order_destroy = Permission::create(['name' => 'order_destroy']);
        $factor_index = Permission::create(['name' => 'factor_index']);
        $factor_store = Permission::create(['name' => 'factor_store']);
        $factor_destroy = Permission::create(['name' => 'factor_destroy']);
        $factor_status = Permission::create(['name' => 'factor_status']);

        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo([
            $user_index,
            $user_destroy,
            $user_update,
            $product_index,
            $product_filter,
            $product_store,
            $product_update,
            $product_destroy,
            $order_index,
            $order_filter,
            $order_store,
            $order_update,
            $order_destroy,
            $factor_index,
            $factor_store,
            $factor_destroy,
            $factor_status,
        ]);
//------------------------------------------------//
        $customer_role = Role::create(['name' => 'customer']);
        $customer_role->givePermissionTo([
            $order_index,
            $order_filter,
            $order_store,
            $order_update,
            $order_destroy,
            $factor_index,
            $factor_store,
            $factor_destroy,
            $factor_status
        ]);
//---------------------------------------------//
        $seller_role = Role::create(['name' => 'seller']);
        $seller_role->givePermissionTo([
            $product_index,
            $product_filter,
            $product_store,
            $product_update,
            $product_destroy,
            $factor_index
        ]);
    }
}
