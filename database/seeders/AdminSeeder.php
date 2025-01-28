<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\Admin; // Assuming Admin model exists

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create the Super Admin user
        $admin = DB::table('admins')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin@2025'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $role = Role::firstOrCreate(['name' => 'SuperAdmin']);

        $adminUser = Admin::find($admin);
        $adminUser->assignRole('SuperAdmin');
    }
}
