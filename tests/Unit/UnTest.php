<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of an employee.
     */
    public function testCreateEmployee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'John Doe',
            'age' => 30,
            'gender' => 'Male',
            'salary' => 50000,
        ];

        $employee = Employee::create($data);

        $this->assertDatabaseHas('employees', $data);
        $this->assertEquals('John Doe', $employee->name);
    }

    /**
     * Test the retrieval of an employee.
     */
    public function testReadEmployee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create([
            'name' => 'Jane Doe',
            'age' => 28,
            'gender' => 'Female',
            'salary' => 60000,
        ]);

        $retrievedEmployee = Employee::find($employee->id);

        $this->assertNotNull($retrievedEmployee);
        $this->assertEquals('Jane Doe', $retrievedEmployee->name);
    }

    /**
     * Test the update of an employee.
     */
    public function testUpdateEmployee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create([
            'name' => 'Mike Ross',
            'age' => 35,
            'gender' => 'Male',
            'salary' => 70000,
        ]);

        $updateData = [
            'name' => 'Michael Ross',
            'salary' => 75000,
        ];

        $employee->update($updateData);

        $this->assertDatabaseHas('employees', $updateData);
        $this->assertEquals('Michael Ross', $employee->fresh()->name);
    }

    /**
     * Test the deletion of an employee.
     */
    public function testDeleteEmployee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $employeeId = $employee->id;
        $employee->delete();

        $this->assertDatabaseMissing('employees', ['id' => $employeeId]);
    }
}
