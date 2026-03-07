<?php

namespace Database\Seeders;

use App\Enums\EmployeeStatus;
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
            'email_verified_at' => now(),
        ]);

        $hr->employee()->updateOrCreate([
            'employee_number' => '11505',
        ], [
            'first_name' => 'Jasper',
            'last_name' => 'Fernandez',
            'department_id' => 2,
            'position' => 'Computer Programmer I',
            'status' => EmployeeStatus::ACTIVE,
        ]);

        $hr->assignRole(Role::HR, Role::EMPLOYEE);
    }
}
