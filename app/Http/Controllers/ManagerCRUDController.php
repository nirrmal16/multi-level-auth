<?php

// app/Http/Controllers/ManagerCRUDController.php

// app/Http/Controllers/ManagerCRUDController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagerCRUDController extends Controller
{

    public function update(Request $request, $id)
    {
        // Implement update logic for managers
        $manager = User::findOrFail($id);
        $manager->update($request->all());

        return response()->json($manager);
    }
}
