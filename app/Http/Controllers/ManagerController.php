<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/ManagerController.php

class ManagerController extends Controller
{
    public function index()
    {
        return view('manager-dashboard');
    }
}
