<?php

// routes/web.php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AllManagersController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeeCRUDController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AllEmployeesController;
use App\Http\Controllers\ManagerCRUDController;
use App\Http\Controllers\ManagerInfoController;
use App\Http\Controllers\TeamMembersController;
use App\Http\Controllers\AdminInfoController;
use App\Http\Controllers\Auth\LoginController;





// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/manager/dashboard', 'ManagerController@index')->name('manager.dashboard');
    Route::get('/employee/dashboard', 'EmployeeController@index')->name('employee.dashboard');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index']);
});

Route::group(['middleware' => ['auth', 'role:manager']], function () {
    Route::get('/manager-dashboard', [ManagerController::class, 'index']);
});

Route::group(['middleware' => ['auth', 'role:employee']], function () {
    Route::get('/employee-dashboard', [EmployeeController::class, 'index']);
});
Route::post('/login', [LoginController::class, 'login'])->name('login');
