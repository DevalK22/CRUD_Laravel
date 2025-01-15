<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EmployeeDetailsController;


Route::apiResource('employees', EmployeeDetailsController::class);
Route::any('employee', function () {
    return response()->json(['error' => 'Invalid URL. Did you mean /api/employees?'], 404);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::fallback(function () {
    return response()->json(['error' => 'Wrong URL format, please check your request.'], 404);
});
