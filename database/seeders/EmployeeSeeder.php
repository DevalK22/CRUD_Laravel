<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed random employees
        Employee::factory(10)->create();

        // Add a specific employee for testing
        Employee::factory()->create([
            'name' => 'Dusty Lind',
            'age' => 30,
            'gender' => 'Male',
            'salary' => 50000,
        ]);
    }
}
