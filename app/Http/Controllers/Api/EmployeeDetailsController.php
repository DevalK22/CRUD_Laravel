<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Resources\EmployeeResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeDetailsController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $age = $request->input('age');
        $gender = $request->input('gender');
        $salary = $request->input('salary');
        $id = $request->input('id');

        $employees = Employee::when($id, function ($query, $id) {
                return $query->where('id', $id);
            })
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($age, function ($query, $age) {
                return $query->where('age', $age);
            })
            ->when($gender, function ($query, $gender) {
                return $query->where('gender', $gender);
            })
            ->when($salary, function ($query, $salary) {
                return $query->where('salary', '=', $salary);
            })
            ->paginate(5);

        if ($employees->isEmpty()) {
            return response()->json(['message' => 'No employees found'], Response::HTTP_OK);
        }
        return response()->json([
            'data' => EmployeeResource::collection($employees),
            'pagination' => [
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem(),
            ]
        ]);
    }

   public function store(Request $request)
{
    $allowedParameters = ['name', 'age', 'gender', 'salary'];

    $unexpectedParameters = array_diff(array_keys($request->all()), $allowedParameters);

    if (count($unexpectedParameters) > 0) {
        return response()->json([
            'error' => 'Invalid parameter(s) inserted: ' . implode(', ', $unexpectedParameters)
        ], 400);
    }

    $messages = [
        'name.required' => 'Please fill out the employee name field.',
        'age.required' => 'Please fill out the employee age field.',
        'gender.required' => 'Please fill out the employee gender field.',
        'salary.required' => 'Please fill out the employee salary field.',
        'name.min' => 'The employee name must be at least 2 characters long.',
        'name.max' => 'The employee name cannot be more than 50 characters.',
        'age.integer' => 'The employee age must be an integer.',
        'age.between' => 'The employee age must be between 18 and 100.',
        'salary.numeric' => 'The employee salary must be a number.',
        'salary.min' => 'The employee salary must be at least 0.',
    ];

    $validated = $request->validate([
        'name' => 'required|min:2|max:50',
        'age' => ['required', 'integer', 'between:18,100'],
        'gender' => 'required',
        'salary' => 'required|numeric|min:0',
    ], $messages);

    try {
        $employee = Employee::create([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
        ]);

        return new EmployeeResource($employee);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'An error occurred while creating the employee: ' . $e->getMessage()
        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        $allowedParameters = ['name', 'age', 'gender', 'salary'];

        $unexpectedParameters = array_diff(array_keys($request->all()), $allowedParameters);

        if (count($unexpectedParameters) > 0) {
            return response()->json([
                'error' => 'Invalid parameter(s) inserted: ' . implode(', ', $unexpectedParameters)
            ], 400);
        }
        $messages = [
            'name.required' => 'Please fill out the employee name field.',
            'age.required' => 'Please fill out the employee age field.',
            'gender.required' => 'Please fill out the employee gender field.',
            'salary.required' => 'Please fill out the employee salary field.',
            'name.min' => 'The employee name must be at least 2 characters long.',
            'name.max' => 'The employee name cannot be more than 50 characters.',
            'age.integer' => 'The employee age must be an integer.',
            'age.between' => 'The employee age must be between 18 and 100.',
            'salary.numeric' => 'The employee salary must be a number.',
            'salary.min' => 'The employee salary must be at least 0.',
        ];

        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'age' => ['required', 'integer', 'between:18,100'],
            'gender' => 'required',
            'salary' => 'required|numeric|min:0',
        ], $messages);

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found with the given ID'], 404);
        }

        $employee->update([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
        ]);

        return new EmployeeResource($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found with the given ID'], 404);
        }

        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully!'], Response::HTTP_OK);
    }
}
