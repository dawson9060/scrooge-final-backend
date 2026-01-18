<?php

namespace App\Http\Controllers;

use App\Enums\UniqueExpenseType;
use App\Models\UniqueExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;

class UniqueExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $uniqueExpenses = UniqueExpense::where("user_id", $userId)->orderBy('date', 'asc')->get();

        return response()->json(["status" => 200, "uniqueExpenses" => $uniqueExpenses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "amount" => "required|numeric",
            "date" => "required|integer|min:1",
            "type" => ["required", new Enum(UniqueExpenseType::class)],
        ]);

        $data['user_id'] = Auth::user()->id;

        $uniqueExpense = UniqueExpense::create($data);

        return response()->json(["status" => 200, "message" => "Unique expense created successfully", "uniqueExpense" => $uniqueExpense]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;

        $uniqueExpense = UniqueExpense::where("user_id", $userId)->where("id", $id)->first();

        if (!$uniqueExpense) {
            return response()->json(["status" => 404, "message" => "Unique expense not found"]);
        }

        return response()->json(["status" => 200, "recurringExpense" => $uniqueExpense]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UniqueExpense $uniqueExpense)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "amount" => "required|numeric",
            "date" => "required|integer|min:1",
            "type" => ["required", new Enum(UniqueExpenseType::class)],
        ]);

        $uniqueExpense->update($data);

        return response()->json(["status" => 200, "message" => "Unique expense updated successfully", "uniqueExpense" => $uniqueExpense]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UniqueExpense $uniqueExpense)
    {
        $uniqueExpense->delete();

        return response()->json(["status" => 200, "message" => "Unique expense deleted successfully"]);
    }
}