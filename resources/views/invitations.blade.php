@extends('layouts.app')

@section('content')
<section class="xl:col-span-1">
      <div class="rounded-2xl border border-gray-200 bg-white">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
          <h2 class="font-semibold">Upcoming Invitations</h2>
          <a href="{{ url('/invitations') }}" class="text-sm text-indigo-600 hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-100">
          @foreach ($invitations as $inv)
          <li class="p-4 flex items-center justify-between">
            <div>
              <div class="font-medium">{{ $inv->event->title }}</div>
              <div class="text-sm text-gray-600">
                {{ \Illuminate\Support\Carbon::parse($inv['date'])->format('D, M j · H:i') }} · Host: {{ $inv->event->host->name }}
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
@endsection