<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));

        // mock data (replace with real queries)
        $stats = [
            'my_events'      => 12,
            'invites_sent'   => 37,
            'invites_pending'=> 9,
            'attendees_total'=> 214,
        ];

        $upcomingInvites = [
            ['title'=>'Tech Mixer Night','date'=>'2025-10-12 19:00','host'=>'Sarah Lee','status'=>'Accepted'],
            ['title'=>'Dev Summit','date'=>'2025-10-15 09:00','host'=>'KJF','status'=>'Pending'],
            ['title'=>'Product Launch','date'=>'2025-10-20 14:30','host'=>'Arman','status'=>'Declined'],
        ];

        $myEvents = [
            ['title'=>'HISHOT 2025 Briefing','date'=>'2025-10-18 10:00','visitors'=>86,'status'=>'Published'],
            ['title'=>'Cybersec Workshop','date'=>'2025-10-25 13:00','visitors'=>120,'status'=>'Draft'],
            ['title'=>'Community Meetup','date'=>'2025-11-02 16:00','visitors'=>48,'status'=>'Published'],
        ];

        return view('dashboard', compact('stats','upcomingInvites','myEvents', 'q'));
    }
}