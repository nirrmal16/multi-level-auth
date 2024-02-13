<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// routes/api.php

Route::middleware('auth')->get('/employee-info', 'EmployeeInfoController@index');
// routes/api.php

Route::middleware('auth')->get('/manager-info', 'ManagerInfoController@index');
Route::middleware('auth')->get('/team-members', 'TeamMembersController@index');
// routes/api.php

Route::middleware('auth')->get('/admin-info', 'AdminInfoController@index');
Route::middleware('auth')->get('/all-managers', 'AllManagersController@index');
Route::middleware('auth')->resource('/managers', 'ManagerCRUDController');
// routes/api.php

Route::middleware('auth')->get('/all-employees', 'AllEmployeesController@index');
// routes/api.php

Route::middleware('auth')->resource('/employees', 'EmployeeCRUDController');
// routes/api.php

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::post('/add-employee', 'AdminController@addEmployee');
    Route::post('/add-manager', 'AdminController@addManager');
});
