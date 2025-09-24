<?php

namespace Database\Seeders;

use App\Models\Hrm\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['name' => 'Management'],
            ['name' => 'Sales'],
            ['name' => 'Cashier'],
            ['name' => 'Warehouse'],
            ['name' => 'Customer Service'],
            ['name' => 'IT Support'],
            ['name' => 'Finance'],
            ['name' => 'Human Resources'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
