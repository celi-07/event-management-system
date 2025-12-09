<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getMyData() {
        // User Id is still hard coded and will be replaced with auth user id later
        $userId = User::all()->first()->id;

        $allInvitations = Invitation::all();
        $invitations = User::find($userId)
            ->invitations()
            ->get();
        $events = User::find($userId)
            ->hostedEvents()
            ->get();
        
        return view('dashboard', [
            'page' => 'Dashboard',
            'user' => User::find($userId),
            'allInvitations' => $allInvitations,
            'invitations' => $invitations,
            'events' => $events,
        ]);
    }
}