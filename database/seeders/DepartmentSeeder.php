<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'code' => 'HRMO',
                'name' => 'Human Resources Management Office',
            ],
            [
                'code' => 'ICTU',
                'name' => 'Information and Communication Technology Unit',
            ],
        ];

        Department::upsert($departments, ['code']);
    }
}
