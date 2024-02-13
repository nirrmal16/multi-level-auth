<?php

// app/Http/Controllers/EmployeeCRUDController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeCRUDController extends Controller
{
    public function update(Request $request, $id)
    {
        // Implement update logic for employees
        $employee = User::findOrFail($id);
        $employee->update($request->all());

        return response()->json($employee);
    }
}
