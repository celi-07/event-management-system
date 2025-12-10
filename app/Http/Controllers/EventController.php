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

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $status = $request->input('action') === 'draft' ? 'Draft' : 'Published';
            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . auth()->id() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/events'), $imageName);
                $imagePath = 'uploads/events/' . $imageName;
            }

            $event = Event::create([
                'title' => $data['title'],
                'date' => $data['date'],
                'location' => $data['location'],
                'description' => $data['description'],
                'image' => $imagePath,
                'host_id' => auth()->id(),
                'status' => $status,
            ]);

            if ($status === 'Published') {
                return back()->with('success', 'Event created successfully!');
            } else {
                return back()->with('success', 'Event saved as draft successfully!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create event. Please try again.')
                ->withInput();
        }
    }

    public function getEdit($id) {
        $event = Event::findOrFail($id);

        return view('edit-event', [
            'page' => 'Edit Event',
            'event' => $event,
        ]);
    }

    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);

        // Prevent edits on published events
        if ($event->status === 'Published') {
            return back()->with('error', 'Published events cannot be edited.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = $event->image;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . auth()->id() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/events'), $imageName);
                $imagePath = 'uploads/events/' . $imageName;
            }

            $newStatus = $event->status;
            if ($event->status === 'Draft' && $request->boolean('publish_now')) {
                $newStatus = 'Published';
            }

            $event->update([
                'title' => $data['title'],
                'date' => $data['date'],
                'location' => $data['location'],
                'description' => $data['description'],
                'image' => $imagePath,
                'status' => $newStatus,
            ]);

            return back()->with('success', $newStatus === 'Published' ? 'Event updated and published successfully!' : 'Event updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update event. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id) {
        $event = Event::findOrFail($id);

        try {
            $event->delete();
            return redirect()->route('my.events')->with('success', 'Event deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete event. Please try again.');
        }
    }

    public function getDetail($id) {
        $event = Event::find($id);
        return view('detail-event', [
            'page' => 'Event Detail',
            'event' => $event,
        ]);
    }

    public function getMyEvents(Request $r) {
        $userId = auth()->id();

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
