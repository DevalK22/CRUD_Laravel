<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Employee;

class AdminController extends Controller
{
    public function insert()
{
    if (!session('admin')) {
        return redirect()->route('admin.login.page')->with('error', 'Please log in to access this page.');
    }
    return view('dashboard');
}


public function loginPage(){
    // Check if the admin is already logged in
    if (session('admin')) {
        return redirect()->route('dashboard');
    }

    // Prevent caching of the login page
    return response()->view("admin")
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
}

       public function create(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:employees,email', // Ensures email exists in the database
            'password' => 'required|min:6',
            'name' => 'required|min:2|max:20',
            'age' => ['required', 'integer', 'between:0,100'],
            'gender' => 'required',
            'salary' => 'required',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'The email address is not registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'name.min' => 'The name field must be at least 2 characters.',
            'name.required' => 'The name field is required.',
            'age.required' => 'The age field is required.',
            'age.between' => 'The age field must be between 0 and 100.',
            'gender.required' => 'The gender field is required.',
            'salary.required' => 'The salary field is required.',
        ]);

        $employee = Employee::create([
            'email'=> $validated['email'],
            'password'=> $validated['password'],
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Employee created successfully!',
                'employee' => $employee,
            ], 201);
        }
        return redirect()->route('dashboard')->with('success', 'Employee created successfully!');
    }
    public function loggedIn(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Hardcoded admin credentials (ensure password is hashed in real-world scenarios)
        $adminCredentials = [
            'email' => 'admin@example.com',
            'password' => 'password123',  // It's recommended to hash this in production, this is for demonstration only
        ];

        // Compare the provided credentials with the hardcoded ones
        if (
            $credentials['email'] === $adminCredentials['email'] &&
            $credentials['password'] === $adminCredentials['password']
        ) {
            session(['admin' => 1]);

            // Redirect to the dashboard
            return redirect()->route('dashboard')->with('success', 'Welcome, Admin!');
        }

        // If credentials don't match, set the error message and return back
        return back()->with('error', 'Admin does not exist or the credentials are incorrect.');
    }


    public function index(Request $request)
{
    // Retrieve query parameters
    $email = $request->input('email');
    $id = $request->input('id');
    $name = $request->input('name');
    $gender = $request->input('gender');
    $age = $request->input('age');
    $salary = $request->input('salary');

    // Filter employees based on query parameters
    $employees = Employee::query()
        ->when($email, fn($query) => $query->where('email', $email))
        ->when($id, fn($query) => $query->where('id', $id))
        ->when($name, fn($query) => $query->where('name', 'like', "%$name%"))
        ->when($gender, fn($query) => $query->where('gender', $gender))
        ->when($age, fn($query) => $query->where('age', $age))
        ->when($salary, fn($query) => $query->where('salary', $salary))
        ->paginate(5);  // Paginate results

        if (!session('admin')) {
            return redirect()->route('admin.login.page')->with('error', 'Please log in to access this page.');
        }
        return view('employee_details', compact('employees'));
}




    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        if (!session('admin')) {
            return redirect()->route('admin.login.page')->with('error', 'Please log in to access this page.');
        }
        return redirect()->route('dashboard')->with('success', 'Employee deleted successfully!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        if (!session('admin')) {
            return redirect()->route('admin.login.page')->with('error', 'Please log in to access this page.');
        }
        return view('edit_employee', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'age' => ['required', 'integer', 'between:18,100'],
            'gender' => 'required',
            'salary' => 'required|numeric|min:0',
        ], [
            'name.min' => 'The name field must be at least 2 characters.',
            'name.required' => 'The name field is required.',
            'age.required' => 'The age field is required.',
            'age.between' => 'The age field must be between 18 and 100.',
            'gender.required' => 'The gender field is required.',
            'salary.required' => 'The salary field is required.',
        ]);
        $employee = Employee::findOrFail($id);

        $employee->update([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
        ]);
        if (!session('admin')) {
            return redirect()->route('admin.login.page')->with('error', 'Please log in to access this page.');
        }
        return redirect()->route('dashboard')->with('success', 'Employee updated successfully!');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('admin.login.page')->with('success', 'Logged out successfully!');
    }
}
