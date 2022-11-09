<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'manage_users',
            'manage_all_users',
            'manage_support',
            'manage_roles',
            'manage_staff_users',
            'manage_wallet',
            'manage_credit_request',
            'manage_withdraw_request',
            'manage_trading_profits',
            'manage_ownership',
            'manage_ranks',
            'manage_news',
            'manage_cms',
            'manage_traders',
            'manage_settings',
            'manage_report'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
