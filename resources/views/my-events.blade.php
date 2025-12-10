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
            <thead class="bg-gray-200 text-[#000]">
              <tr>
                <th class="px-4 py-[8px] text-center font-semibold">Title</th>
                <th class="px-4 py-[8px] text-center font-semibold">Date</th>
                <th class="px-4 py-[8px] text-center font-semibold">Visitors</th>
                <th class="px-4 py-[8px] text-center font-semibold">Status</th>
                <th class="px-4 py-[8px] text-center font-semibold">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @if ($events->count() == 0)
                <tr>
                  <td colspan="5" class="px-4 py-3">
                    <x-empty-data class="h-[241px] flex flex-col items-center justify-center" />
                  </td>
                </tr>
              @else
                @foreach ($events->take(9) as $e)
                  <tr>
                    <td class="px-4 py-3 text-center text-[14px]">{{ $e['title'] }}</td>
                    <td class="px-4 py-3 text-center text-[14px] font-light">{{ \Illuminate\Support\Carbon::parse($e['date'])->format('D, M j · H:i') }}</td>
                    <td class="px-4 py-3 text-center text-[14px] font-light">{{ $e['visitor_count'] }}</td>
                    <td class="px-4 py-3 text-center">
                      <span @class([
                        'text-[12px] inline-block w-[80px] py-1 rounded-full text-center font-semibold',
                        'bg-[#01044e] text-[#fff]' => $e['status']==='Published',
                        'bg-indigo-50 text-text-[#01044e]' => $e['status']==='Draft',
                      ])>{{ $e['status'] }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                      <a href="{{ url('/events/' . $e['id'] . '/edit') }}" class="text-[#01044e] text-[12px] font-semibold hover:underline">Edit</a>
                      <span class="mx-2 text-gray-300">|</span>
                      <a href="{{ url('/events/' . $e['id']) }}" class="text-[#622733] text-[12px] font-semibold hover:underline">View</a>
                    </td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
    </section>
@endsection