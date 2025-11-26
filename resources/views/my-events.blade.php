@extends('layouts.app')

@section('content')
<section class="xl:col-span-2">
      <div class="rounded-2xl border border-gray-200 bg-white">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
          <h2 class="font-semibold">My Events</h2>
          <div class="flex items-center gap-2">
            <a href="{{ url('/create/events') }}" class="text-sm rounded-lg border px-3 py-1.5 hover:bg-gray-50">Create</a>
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
              @foreach ($events as $e)
              <tr>
                <td class="px-4 py-3 font-medium">{{ $e['title'] }}</td>
                <td class="px-4 py-3">{{ \Illuminate\Support\Carbon::parse($e['date'])->format('D, M j · H:i') }}</td>
                <td class="px-4 py-3">{{ $e['visitor_count'] }}</td>
                <td class="px-4 py-3">
                  <span @class([
                    'text-xs px-2 py-1 rounded-full',
                    'bg-indigo-100 text-indigo-700' => $e['status']==='Published',
                    'bg-gray-200 text-gray-700' => $e['status']==='Draft',
                  ])>{{ $e['status'] }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                  <a href="{{ url('/events/' . $e['id'] . '/edit') }}" class="text-indigo-600 hover:underline">Edit</a>
                  <span class="mx-2 text-gray-300">|</span>
                  <a href="{{ url('/events/' . $e['id']) }}" class="text-gray-600 hover:underline">View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </section>
@endsection