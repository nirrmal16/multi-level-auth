<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/AdminController.php

class AdminController extends Controller
{
    public function index()
    {
        return view('admin-dashboard');
    }
    public function addEmployee(Request $request)
    {
        // Implement logic to add a new employee
        // Example: validation, creation, etc.

        $employee = User::create([
            'name' => $request->input('name'),
            'dob' => $request->input('dob'),
            'date_of_join' => $request->input('date_of_join'),
            'role_id' => 'employee', // Assuming there is a 'role_id' column in your users table
        ]);

        return response()->json($employee);
    }

    public function addManager(Request $request)
    {
        // Implement logic to add a new manager
        // Example: validation, creation, etc.

        $manager = User::create([
            'name' => $request->input('name'),
            'dob' => $request->input('dob'),
            'date_of_join' => $request->input('date_of_join'),
            'role_id' => 'manager', // Assuming there is a 'role_id' column in your users table
        ]);

        return response()->json($manager);
    }
}
