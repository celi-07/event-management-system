@extends('layouts.app')

@section('content')
<section class="xl:col-span-1">
      <div class="rounded-2xl border border-gray-200 bg-white">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
          <h2 class="font-bold text-[16px]">Upcoming Invitations</h2>
        </div>
        <ul class="divide-y divide-gray-100">
          @if ($invitations->count() == 0)
            <x-empty-data class="h-[300px] flex flex-col items-center justify-center" />
          @else
            @foreach ($invitations->take(8) as $inv)
              <li class="py-3 px-4 flex items-center justify-between">
                <div>
                  <div class="font-regular text-[14px]">{{ $inv->event->title }}</div>
                  <div class="text-[12px] text-gray-600 font-light">
                    {{ \Illuminate\Support\Carbon::parse($inv['date'])->format('D, M j · H:i') }} · Host: {{ $inv->event->host->name }}
                  </div>
                </div>
                <span @class([
                    'text-[12px] text-center font-semibold inline-block w-[80px] py-1 rounded-full',
                    'bg-[#01044e] text-white' => $inv['status']==='Accepted',
                    'bg-indigo-50 text-[#01044e]' => $inv['status']==='Pending',
                    'bg-[#622733] text-white' => $inv['status']==='Declined',
                ])>{{ $inv['status'] }}</span>
              </li>
            @endforeach
          @endif
        </ul>
      </div>
    </section>
@endsection