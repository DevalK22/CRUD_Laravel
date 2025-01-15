<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;

// Employee
Route::post('/login', [EmployeeController::class, 'logged_in'])->name('employee.logged.in');
Route::post('/logout', [EmployeeController::class, 'logout'])->name('logout');
Route::post('/register', [EmployeeController::class, 'register'])->name('employee.register');
Route::get('/login', function() { return view('login'); })->name('employee.login');
Route::get('/', function() { return view('login'); })->name('employee.login.page');
Route::get('/logged_in', [EmployeeController::class, 'single_employee'])->name('employee.logged');
Route::get('/register',function(){return view('register');});


// Admin
Route::post('/admin/create', [AdminController::class, 'create'])->name('employee_post');
Route::post('/admin', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'loggedIn'])->name('admin.logged_in');

Route::post('/', [AdminController::class, 'logout'])->name('admin_logout');
Route::get('/admin/insert', [AdminController::class, 'insert'])->name('insert');
Route::put('/admin/dashboard/edit/{id}', [AdminController::class, 'update'])->name('employee.update');
Route::delete('/admin/dashboard/{id}', [AdminController::class, 'destroy'])->name('employee.destroy');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::get('/admin/dashboard/edit/{id}', [AdminController::class, 'edit']);
Route::get('/admin', [AdminController::class, 'loginPage'])->name('admin.login.page');
