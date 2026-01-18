<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateBudget(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'budget' => 'required|numeric|min:1',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        $user->update(['budget' => $validated['budget']]);

        // Update the budget field
        // $user->budget = $validated['budget'];
        // $user->save();

        return response()->json([
            'message' => 'Budget updated successfully',
            'budget' => $user->budget,
        ]);
    }

}