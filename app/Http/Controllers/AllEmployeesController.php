<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/EmployeeInfoController.php

// app/Http/Controllers/AllEmployeesController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AllEmployeesController extends Controller
{
    public function index()
    {
        // Retrieve and return a list of all employees
        $employees = User::where('role_id', '=', 'employee')->get();

        return response()->json($employees);
    }
}
