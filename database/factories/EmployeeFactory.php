<?php
namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(18, 65),
            'gender' => $this->faker->randomElement(['Male', 'Female','Other']),
            'salary' => $this->faker->numberBetween(30000, 120000),
        ];
    }
}
