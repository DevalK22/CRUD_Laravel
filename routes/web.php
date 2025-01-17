<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

// Employee
Route::post('/login', [EmployeeController::class, 'logged_in'])->name('employee.logged.in');
Route::post('logged_in/summary/{id}', [EmployeeController::class, 'summary'])->name('employee.view.salary');
Route::post('/logout', [EmployeeController::class, 'logout'])->name('logout');
Route::post('/register', [EmployeeController::class, 'register'])->name('employee.register');
Route::post('/leave', [EmployeeController::class, 'leave_send'])->name('leave.send');
Route::get('/login', function() {
    if(Auth::check()) {

        return redirect('/logged_in');
    }

    return view('login'); })->name('employee.login');
Route::get('/', function() {
    if(Auth::check()) {

        return redirect('/logged_in');
    }

    return view('login');
})->name('employee.login.page');
Route::get('/logged_in', [EmployeeController::class, 'single_employee'])->name('employee.logged');
Route::get('/logged_in/summary/{id}', [EmployeeController::class, 'summary'])->name('employee.summary');
Route::get('/register',function(){return view('register');});
Route::get('/logged_in/leave',function(){return view('leave_form');})->name('leave.form');


// Admin
Route::post('/admin/create', [AdminController::class, 'create'])->name('employee_post');
Route::post('/admin', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'loggedIn'])->name('admin.logged_in');

Route::post('/admin/approved/{id}', [AdminController::class, 'approve'])->name('approve');
Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('reject');

Route::post('/', [AdminController::class, 'logout'])->name('admin_logout');
Route::get('/admin/view/{id}', [AdminController::class, 'view'])->name('view.leave');
Route::get('/admin/insert', [AdminController::class, 'insert'])->name('insert');
Route::put('/admin/dashboard/edit/{id}', [AdminController::class, 'update'])->name('employee.update');
Route::delete('/admin/dashboard/{id}', [AdminController::class, 'destroy'])->name('employee.destroy');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::get('/admin/summary/{id}', [AdminController::class, 'summary'])->name('admin.showSummary');
Route::get('/admin/dashboard/edit/{id}', [AdminController::class, 'edit']);
Route::get('/admin', [AdminController::class, 'loginPage'])->name('admin.login.page');
