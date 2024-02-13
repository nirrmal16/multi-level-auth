<?php

// app/Http/Controllers/AdminInfoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminInfoController extends Controller
{
    public function index()
    {
        // Retrieve and return the authenticated admin's information
        $adminInfo = auth()->user();

        return response()->json($adminInfo);
    }
}
