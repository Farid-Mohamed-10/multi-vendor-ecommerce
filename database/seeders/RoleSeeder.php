<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $buyerRole = Role::firstOrCreate([
            'name' => 'buyer',
            'guard_name' => 'web',
        ]);

        $sellerRole = Role::firstOrCreate([
            'name' => 'seller',
            'guard_name' => 'web',
        ]);

        $adminUser = User::firstOrNew(['email' => 'fm221210@gmail.com']);
        $adminUser->fill([
            'name' => 'Farid Mohamed',
            'email' => 'fm221210@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '01029911289',
        ])->save();

        // Assign admin role to the user
        $adminUser->assignRole($adminRole);
    }
}
