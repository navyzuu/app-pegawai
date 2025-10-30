<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('employees', EmployeeController::class);

Route::resource('departments', DepartmentController::class);

Route::post('departments/{department}/positions', [PositionController::class, 'store'])->name('departments.positions.store');
Route::put('departments/{department}/positions/{position}', [PositionController::class, 'update'])->name('departments.positions.update');
Route::delete('departments/{department}/positions/{position}', [PositionController::class, 'destroy'])->name('departments.positions.destroy');

Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('attendance/{employee}/store', [AttendanceController::class, 'store'])->name('attendance.store');
Route::post('attendance/{employee}/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
Route::post('attendance/{employee}/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
Route::put('attendance/{employee}/update', [AttendanceController::class, 'update'])->name('attendance.update');

Route::resource('salaries', SalaryController::class);
