<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
