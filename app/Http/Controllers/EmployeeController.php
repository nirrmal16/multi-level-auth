<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/EmployeeController.php

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee-dashboard');
    }
}

