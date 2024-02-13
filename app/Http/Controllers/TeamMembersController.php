<?php

// app/Http/Controllers/TeamMembersController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamMembersController extends Controller
{
    public function index()
    {
        // Retrieve and return the authenticated manager's team members
        $teamMembers = auth()->user()->teamMembers; // Assuming you have a relationship defined in the User model

        return response()->json($teamMembers);
    }
}
