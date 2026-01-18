<?php

namespace App\Http\Controllers;

use App\Enums\RecurringExpenseType;
use App\Models\RecurringExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class RecurringExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $recurringExpenses = RecurringExpense::where("user_id", $userId)->orderBy('amount', 'desc')->get();

        return response()->json(["status" => 200, "recurringExpenses" => $recurringExpenses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "amount" => "required|numeric",
            "day_of_month" => "nullable|integer|min:1|max:31",
            "type" => ["required", new Enum(RecurringExpenseType::class)],
        ]);

        $data['user_id'] = Auth::user()->id;

        $recurringExpense = RecurringExpense::create($data);

        return response()->json(["status" => 200, "message" => "Recurring expense created successfully", "recurringExpense" => $recurringExpense]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;

        $recurringExpense = RecurringExpense::where("user_id", $userId)->where("id", $id)->first();

        if (!$recurringExpense) {
            return response()->json(["status" => 404, "message" => "Recurring expense not found"]);
        }

        return response()->json(["status" => 200, "recurringExpense" => $recurringExpense]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecurringExpense $recurringExpense)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "amount" => "required|numeric",
            "day_of_month" => "nullable|integer|min:1|max:31",
            "type" => ["required", new Enum(RecurringExpenseType::class)],
        ]);

        $recurringExpense->update($data);

        return response()->json(["status" => 200, "message" => "Recurring expense updated successfully", "recurringExpense" => $recurringExpense]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecurringExpense $recurringExpense)
    {
        $recurringExpense->delete();

        return response()->json(["status" => 200, "message" => "Recurring expense deleted successfully"]);
    }
}