<?php
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

//Get all employees
Route::get('employees', [EmployeeController::class, 'index']);

//Get a single employee
Route::get('employees/{employee}', [EmployeeController::class, 'show']);

//Create a new employee
Route::post('employees', [EmployeeController::class, 'create']);

//Update an employee
Route::put('employees/{id}', [EmployeeController::class, 'update']);

//Delete an employee
Route::delete('employees/{employee}', [EmployeeController::class, 'destroy']);