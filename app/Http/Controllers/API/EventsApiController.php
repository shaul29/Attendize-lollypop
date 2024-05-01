<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventsApiController extends ApiBaseController
{
    public function index(Request $request)
    {
        $query = Event::with('images');  // Ensure relationships are loaded if needed

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $query->where('end_date', '>', Carbon::now());
        $query->where('is_live', true);

        $events = $query->paginate(20);

        $events->getCollection()->transform(function ($event) {
            $event->map_address = $event->map_address;
            return $event;
        });

        return response()->json($events);
    }
}
