<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Http\Request;

class EventsApiController extends ApiBaseController
{
    public function index(Request $request)
    {
        $query = Event::query(); 

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $events = $query->paginate(20); 

        return response()->json($events);
    }

    public function show(Request $request, $attendee_id)
    {
        if ($attendee_id) {
            return Event::scope($this->account_id)->find($attendee_id);
        }

        return response('Event Not Found', 404);
    }

    public function store(Request $request)
    {
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }


}
