<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create(['depart_name' => 'IT']);
        Department::create(['depart_name' => 'HR']);
        Department::create(['depart_name' => 'Finance']);
        Department::create(['depart_name' => 'Marketing']);
    }
}
