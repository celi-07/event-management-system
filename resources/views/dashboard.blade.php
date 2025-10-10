@extends('layouts.app')

@section('title','Dashboard')

@section('content')
  {{-- Page Title --}}
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-semibold">Dashboard</h1>
      <p class="text-sm text-gray-600">Track events, invitations, and attendance. If these numbers are flat, your growth is flat—fix it fast.</p>
    </div>
  </div>

  {{-- KPI Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <x-stat-card label="My Events" :value="$stats['my_events']"/>
    <x-stat-card label="Invitations Sent" :value="$stats['invites_sent']"/>
    <x-stat-card label="Pending Invites" :value="$stats['invites_pending']"/>
    <x-stat-card label="Total Attendees" :value="$stats['attendees_total']"/>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Left: Upcoming Invitations --}}
    <section class="xl:col-span-1">
      <div class="rounded-2xl border border-gray-200 bg-white">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
          <h2 class="font-semibold">Upcoming Invitations</h2>
          <a href="{{ url('/invitations') }}" class="text-sm text-indigo-600 hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-100">
          @foreach ($upcomingInvites as $inv)
          <li class="p-4 flex items-center justify-between">
            <div>
              <div class="font-medium">{{ $inv['title'] }}</div>
              <div class="text-sm text-gray-600">
                {{ \Illuminate\Support\Carbon::parse($inv['date'])->format('D, M j · H:i') }} · Host: {{ $inv['host'] }}
              </div>
            </div>
            <span @class([
                'text-xs px-2 py-1 rounded-full',
                'bg-green-100 text-green-700' => $inv['status']==='Accepted',
                'bg-yellow-100 text-yellow-700' => $inv['status']==='Pending',
                'bg-red-100 text-red-700' => $inv['status']==='Declined',
            ])>{{ $inv['status'] }}</span>
          </li>
          @endforeach
        </ul>
      </div>
    </section>

    {{-- Middle: My Events Table --}}
    <section class="xl:col-span-2">
      <div class="rounded-2xl border border-gray-200 bg-white">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
          <h2 class="font-semibold">My Events</h2>
          <div class="flex items-center gap-2">
            <a href="{{ url('/events/create') }}" class="text-sm rounded-lg border px-3 py-1.5 hover:bg-gray-50">Create</a>
            <a href="{{ url('/events') }}" class="text-sm text-indigo-600 hover:underline">Manage</a>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
              <tr>
                <th class="px-4 py-3 text-left font-medium">Title</th>
                <th class="px-4 py-3 text-left font-medium">Date</th>
                <th class="px-4 py-3 text-left font-medium">Visitors</th>
                <th class="px-4 py-3 text-left font-medium">Status</th>
                <th class="px-4 py-3 text-right font-medium">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @foreach ($myEvents as $e)
              <tr>
                <td class="px-4 py-3 font-medium">{{ $e['title'] }}</td>
                <td class="px-4 py-3">{{ \Illuminate\Support\Carbon::parse($e['date'])->format('D, M j · H:i') }}</td>
                <td class="px-4 py-3">{{ $e['visitors'] }}</td>
                <td class="px-4 py-3">
                  <span @class([
                    'text-xs px-2 py-1 rounded-full',
                    'bg-indigo-100 text-indigo-700' => $e['status']==='Published',
                    'bg-gray-200 text-gray-700' => $e['status']==='Draft',
                  ])>{{ $e['status'] }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                  <a href="{{ url('/events/1/edit') }}" class="text-indigo-600 hover:underline">Edit</a>
                  <span class="mx-2 text-gray-300">|</span>
                  <a href="{{ url('/events/1') }}" class="text-gray-600 hover:underline">View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </section>
  </div>
@endsection
