<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $hr = User::firstOrCreate([
            'email' => 'jafernandez@nemsu.edu.ph',
        ], [
            'name' => 'Jasper Fernandez',
            'password' => bcrypt('secret'),
        ]);

        $hr->assignRole(Role::HR);
    }
}
