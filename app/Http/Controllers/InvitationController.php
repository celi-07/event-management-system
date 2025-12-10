<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function getInvitations(Request $r) {
        // User Id is still hard coded and will be replaced with auth user id later
        $userId = User::all()
            ->first()
            ->id;

        $query = $r->input('q');
        
        if (!$query) {
            $invitations = User::find($userId)
                ->invitations()
                ->get();

            return view('invitations', [
                'page' => 'Invitations',
                'invitations' => $invitations,
            ]);
        } else {
            $invitations = [];
            $invitations = User::find($userId)
                ->invitations()
                ->get();
            
            $invitations = $invitations->filter(function ($invitation) use ($query) {
                return str_contains(strtolower($invitation->event->title), strtolower($query));
            });

            return view('invitations', [
                'page' => 'Invitations',
                'invitations' => $invitations,
            ]);
        }
    }

    public function registerInvitation($eventId) {
        try {
            $user = auth()->user();
            
            if (Invitation::where('event_id', $eventId)->where('invitee_id', $user->id)->exists()) {
                return back()->with('error', 'You have already registered for this event.');
            }
            
            Invitation::create([
                'event_id' => $eventId,
                'invitee_id' => $user->id,
                'status' => 'Pending',
                'sent_at' => NULL,
                'responded_at' => now(),
            ]);

            return back()->with('success', "Successfully registered for the event!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to register for the event. Please try again.');
        }
    }
}
