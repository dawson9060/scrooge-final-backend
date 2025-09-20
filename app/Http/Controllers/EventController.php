<?php

namespace App\Http\Controllers;

use App\EventStatus;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    // all events owned by the authenticated user
    public function index()
    {
        $owner_id = Auth::user()->id;

        // events where the user is requesting someone take their pet
        $giveEvents = Event::where("event_owner", $owner_id)->with('pets')->get();

        // events where the user is taking someone else's pet
        $takeEvents = Event::where("event_taker", $owner_id)->with('pets')->get();

        return response()->json(["status" => 200, "events" => ["give" => $giveEvents, "take" => $takeEvents]]);
    }

    // create a new event (as the event owner ONLY)
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string|max:2000",
            "pet_ids" => "required|array|min:1",
            // "is_active" => "required|boolean",
            "event_start" => "required|numeric",
            "event_end" => "required|numeric",
        ]);

        $numDays = floor(($data['event_end'] - $data['event_start']) / (24 * 60 * 60 * 1000)); // assuming event_start and event_end are in milliseconds
        $numPets = count($data['pet_ids']);

        $data['event_owner'] = Auth::user()->id;
        $data['num_pets'] = $numPets;
        $data['num_days'] = $numDays;
        $data['num_credits'] = $numPets * $numDays;
        $data['city'] = Auth::user()->city;
        $data['state'] = Auth::user()->state;
        $data['zip'] = Auth::user()->zip;
        // TODO - make this a default value in db?
        $data['is_active'] = true;

        Log::info(message: "EVENT SUBTRACT: " . $data['event_end'] - $data['event_start']);

        $event = Event::create($data);

        $event->pets()->attach($data['pet_ids']);

        return response()->json(["status" => 200, "message" => "Event created successfully", "event" => $event]);
    }

    // fetch a specific event by its id
    public function show(Event $event)
    {
        return response()->json(["status" => 200, "event" => $event]);
    }


    // Update a specific event by its id, only the event owner can do this
    // TODO - CONSIDER MAKING THIS INTO A DIFFERENT METHOD -> "claimEvent" SO AS TO NOT PASS userIds from FRONTEND
    public function update(Request $request, Event $event)
    {
        if ($event->event_owner !== Auth::user()->id) {
            return response()->json(["status" => 403, "message" => "You are not authorized to update this event."], 403);
        }

        // TODO - should owner be allowed to change the event start / end times after booking?
        $data = $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string|max:2000",
            "pet_ids" => "required|array|min:1",
            "is_active" => "required|boolean",
            "event_start" => "required|numeric",
            "event_end" => "required|numeric",
        ]);

        // TODO - account for just 1 day events, as in the floor() will round down to 0
        $numDays = floor(($data['event_end'] - $data['event_start']) / (24 * 60 * 60 * 1000)); // assuming event_start and event_end are in milliseconds

        $numPets = count($data['pet_ids']);

        $data['num_pets'] = $numPets;
        $data['num_days'] = $numDays;
        $data['num_credits'] = $numPets * $numDays;

        $event->update($data);

        // update the pets associated with the event (event_pets pivot table)
        $event->pets()->sync($data['pet_ids']);
    }

    // delete a specific event by its id
    // TODO - should we have soft-deletes? - cascade deletes in pivot table will not happen automatically if so
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(["status" => 200, "message" => "Event deleted successfully"]);
    }

    // get all events
    // TODO - should have filtering here
    public function allEvents()
    {
        $events = Event::where('is_active', true)
            ->where('status', EventStatus::CREATED)
            ->get();

        return response()->json(['status' => 200, 'events' => $events]);
    }
}