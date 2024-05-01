<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Http\Request;

class TicketsApiController extends ApiBaseController
{
    public function index(Request $request, $event_id)
    {
        $event = Event::findOrFail($event_id);

        if (!$event->is_live) {
            return response()->json(['message' => 'Event is not live'], 403);
        }

        $tickets = $event->tickets()->orderBy('sort_order', 'asc')->get();

        return response()->json([
            'event_id' => $event_id,
            'tickets' => $tickets,
        ]);
    }
}
