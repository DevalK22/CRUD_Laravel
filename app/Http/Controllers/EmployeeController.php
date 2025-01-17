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

        // Creating the employee record with the new fields
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

        // $employee = Employee::where('email', $validated['email'])->first();

        if (Auth::attempt(['email'=>$validated['email'],'password'=>$validated['password']])) {

            return redirect()->route('employee.logged')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
    }

    public function single_employee()
    {
        if (Auth::check()) {
            $id = Auth::id();
            $employee = Employee::find($id);

            // Return the view with all employee data, including the new fields
            return view('logged_in', ['employee' => $employee]);
        }

        return redirect()->route('employee.login')->with('error', 'Please log in to access this page.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('employee.login')->with('success', 'Logged out successfully.');
    }
    public function summary(Request $request, $id)
{
    // Find the employee by ID
    $employee = Employee::find($id);

    if (!$employee) {
        return redirect()->back()->with('error', 'Employee not found.');
    }

    // Validate the password input from the user
    $validated = $request->validate([
        'password' => 'required|string',
    ]);

    // Check if the entered password matches the employee's password
    if (Hash::check($validated['password'], $employee->password)) {
        // Password is correct, show the salary
        return view('employee_summary', compact('employee'));
    } else {
        // Password is incorrect, redirect back with an error message
        return back()->withErrors(['password' => 'Incorrect password. Please try again.']);
    }
    }


    public function leave_send(Request $request)
{
    // Validate the form inputs
    $validated = $request->validate([
        'leave_type' => 'required|string|in:Sick Leave,Casual Leave,Annual Leave',
        'leave_start' => 'required|date|after_or_equal:today',
        'leave_end' => 'required|date|after_or_equal:leave_start',
        'reason' => 'required|string|min:10|max:500',
    ]);
    $existingLeave = Employee::where('id', Auth::id())
        ->where('status', 'Pending')
        ->first();

    if ($existingLeave) {
        return redirect()->route('employee.logged')->with('error', 'You already have a pending leave request.');
    }
    // Assuming you have a Leave model
    $employee = Employee::where('id',Auth::id())
    ->update([
        'leave_type'=>$validated['leave_type'],
        'start_leave'=>$validated['leave_start'],
        'end_leave'=>$validated['leave_end'],
        'reason'=>$validated['reason'],
        'status'=>'Pending',
]);

    // Redirect to a success page or back with a success message
    return redirect()->route('employee.logged',['status'=>'Pending'])->with('success', 'Leave request submitted successfully!');
}

}
