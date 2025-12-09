<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function discover(Request $r) {
        $query = $r->input('q');

        if (!$query) {
            return view('discover', [
                'page' => 'Discover',
                'events' => Event::all(),
            ]);
        } else {
            $events = [];
            $events = Event::where('title', 'like', '%' . $query . '%')
                ->get();
            
            return view('discover', [
                'page' => 'Discover',
                'events' => $events,
            ]);
        }
    }

    public function getCreate() {
        return view('create-event', [
            'page' => 'Create Event',
        ]);
    }

    public function getEdit() {
        return view('edit-event', [
            'page' => 'Edit Event',
        ]);
    }

    public function getDetail($id) {
        $event = Event::find($id);
        return view('detail-event', [
            'page' => 'Event Detail',
            'event' => $event,
        ]);
    }

    public function getMyEvents(Request $r) {
        // User Id is still hard coded and will be replaced with auth user id later
        $userId = User::all()
            ->first()
            ->id;

        $query = $r->input('q');
        
        if (!$query) {
            $events = User::find($userId)
                ->hostedEvents()
                ->get();

            return view('my-events', [
                'page' => 'My Events',
                'events' => $events,
            ]);
        } else {
            $events = [];
            $events = User::find($userId)
                ->hostedEvents()
                ->where('title', 'like', '%' . $query . '%')
                ->get();

            return view('my-events', [
                'page' => 'My Events',
                'events' => $events,
            ]);
        }
    }
}
