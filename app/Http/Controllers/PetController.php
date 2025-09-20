<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PetController extends Controller
{
    // all pets owned by the authenticated user
    public function index()
    {
        $owner_id = Auth::user()->id;

        Log::info("OWNER ID", [$owner_id]);
        $pets = Pet::where("owner_id", $owner_id)->get();

        return response()->json(["status" => 200, "pets" => $pets]);
    }

    // store a new pet
    public function store(Request $request)
    {
        // TODO - make "age" into date of birth and dynamically calculate age?
        // TODO - description should have more definite character limit?
        $data = $request->validate([
            "name" => "required|string|max:100",
            "breed" => "required|string|max:50",
            "age" => "required|integer",
            "is_pet_friendly" => "required|boolean",
            "is_kid_friendly" => "required|boolean",
            "has_special_needs" => "required|boolean",
            "has_medication_needs" => "required|boolean",
            "description" => "string|nullable|max:2000",
        ]);

        $data['owner_id'] = Auth::user()->id;

        $pet = Pet::create($data);

        return response()->json(["status" => 200, "message" => "Pet created successfully", "pet" => $pet]);
    }

    // get a single pet object
    public function show(Pet $pet)
    {
        return response()->json(["status" => 200, "pet" => $pet]);
    }

    // update a pet
    public function update(Request $request, Pet $pet)
    {
        $data = $request->validate([
            "name" => "required|string|max:100",
            "breed" => "required|string|max:50",
            "age" => "required|integer",
            "is_pet_friendly" => "required|boolean",
            "is_kid_friendly" => "required|boolean",
            "has_special_needs" => "required|boolean",
            "has_medication_needs" => "required|boolean",
            "description" => "string|max:2000",
        ]);

        $data['owner_id'] = Auth::user()->id;

        $pet->update($data);

        return response()->json(["status" => 200, "message" => "Pet updated successfully", "pet" => $pet]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return response()->json(["status" => 200, "message" => "Pet deleted successfully"]);
    }
}