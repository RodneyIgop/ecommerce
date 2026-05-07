<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@purefit.com',
            'password' => 'password',
            'role' => \App\Models\User::ROLE_ADMIN,
        ]);

        $business = \App\Models\User::create([
            'name' => 'Business Owner',
            'email' => 'business@purefit.com',
            'password' => 'password',
            'role' => \App\Models\User::ROLE_BUSINESS,
        ]);

        \App\Models\BusinessProfile::create([
            'user_id' => $business->id,
            'business_name' => 'PureFit Wholesale',
            'business_address' => '123 Commerce St, City',
            'business_phone' => '09123456789',
            'tax_id' => 'TIN-123456789',
        ]);

        \App\Models\User::create([
            'name' => 'Solo Buyer',
            'email' => 'buyer@purefit.com',
            'password' => 'password',
            'role' => \App\Models\User::ROLE_BUYER,
        ]);
    }
}
