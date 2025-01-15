<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:100',
            'age' => ['required', 'integer', 'between:1,100'],
            'gender' => 'required|in:Male,Female,Other',
            'salary' => 'nullable|numeric',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
        ]);

        Employee::create([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'] ?? null,
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('employee.login')->with('success', 'Employee created successfully!');
    }

    public function logged_in(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:employees,email',
            'password' => 'required|min:6',
        ]);

        $employee = Employee::where('email', $validated['email'])->first();

        if ($employee && Hash::check($validated['password'], $employee->password)) {
            Auth::login($employee, $request->has('remember'));
            return redirect()->route('employee.logged')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
    }

    public function single_employee()
    {
        if (Auth::check()) {
            $id = Auth::id();
            $employee = Employee::find($id);

            return view('logged_in', ['employee' => $employee]);
        }

        return redirect()->route('employee.login')->with('error', 'Please log in to access this page.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('employee.login')->with('success', 'Logged out successfully.');
    }
}
