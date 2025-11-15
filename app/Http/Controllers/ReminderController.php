<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $reminders = Reminder::where("user_id", $userId)->orderBy('date', 'desc')->get();

        return response()->json(["status" => 200, "reminders" => $reminders]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "date" => "required|integer|min:1",
        ]);

        $data['user_id'] = Auth::user()->id;

        $reminder = Reminder::create($data);

        return response()->json(["status" => 200, "message" => "Reminder created successfully", "reminders" => $reminder]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;

        $reminder = Reminder::where("user_id", $userId)->where("id", $id)->first();

        if (!$reminder) {
            return response()->json(["status" => 404, "message" => "Reminder not found"]);
        }

        return response()->json(["status" => 200, "reminder" => $reminder]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "date" => "required|integer|min:1",
        ]);

        $reminder->update($data);

        return response()->json(["status" => 200, "message" => "Reminder updated successfully", "reminder" => $reminder]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return response()->json(["status" => 200, "message" => "Reminder deleted successfully"]);
    }
}