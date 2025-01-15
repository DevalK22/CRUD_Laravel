<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdatesEmployeeSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'age' => 30,
            'gender' => 'Male',
            'salary' => 50000,
        ];

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->put(route('employee.update', $employee->id), $updatedData);

        $response->assertRedirect(route('admin/dashboard'));
        $response->assertSessionHas('success', 'Employee updated successfully!');

        $this->assertDatabaseHas('employees', $updatedData);
        $this->assertDatabaseMissing('employees', ['name' => $employee->name]);
    }

    public function testDeletesEmployeeSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->delete(route('employee.destroy', $employee->id));

        $response->assertRedirect(route('admin/dashboard'));
        $response->assertSessionHas('success', 'Employee deleted successfully!');

        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }

    public function testCreatesEmployeeSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employeeData = [
            'name' => 'John Doe',
            'age' => 28,
            'gender' => 'Male',
            'salary' => 45000,
        ];

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->post(route('employee_post'), $employeeData);

        $response->assertRedirect(route('admin/dashboard'));
        $response->assertSessionHas('success', 'Employee created successfully!');

        $this->assertDatabaseHas('employees', $employeeData);
    }

    public function testReadsEmployeeSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $response = $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ])->get(route('admin/dashboard', $employee->id));

        $response->assertStatus(200);

        $response->assertSee($employee->name);
        $response->assertSee($employee->age);
        $response->assertSee($employee->gender);
        $response->assertSee($employee->salary);
    }


}
