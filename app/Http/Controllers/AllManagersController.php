<?php

// app/Http/Controllers/AllManagersController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AllManagersController extends Controller
{
    public function index()
    {
        // Retrieve and return a list of all managers
        $managers = User::where('role_id', '=', 'manager')->get();

        return response()->json($managers);
    }
}
