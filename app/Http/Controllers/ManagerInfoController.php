<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// app/Http/Controllers/ManagerInfoController.php



class ManagerInfoController extends Controller
{
    public function index()
    {
        // Retrieve and return the authenticated manager's information
        $managerInfo = auth()->user();

        return response()->json($managerInfo);
    }
}
