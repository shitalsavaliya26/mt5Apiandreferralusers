<?php

use App\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            'user_name' => 'jenius',
            'email' => 'jenius@avanya.com',
            'password' => Hash::make('aipX@1234'),
        ];

        Admin::create($input);

        Role::create(['name'=>'admin']);

        /** @var Role $adminRole */
        $adminRole = Role::whereName('Admin')->first();

        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
    }
}
