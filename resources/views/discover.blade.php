@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<div class="container py-4">
    <div class="mb-4">
        <h2 class="text-3xl font-bold mb-1">Discover Events</h2>
        <p class="text-[14px] text-gray-600">Browse upcoming events near you.</p>
    </div>

    @if($events->count())
        <div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($events as $event)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @php
                                $image = $event->image ?? ($event->image_url ?? null);
                                $imageUrl = $image ? (Str::startsWith($image, ['http://','https://']) ? $image : asset($image)) : '';
                                $start = $event->start_date ?? $event->date ?? null;
                            @endphp

                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $event->title ?? 'Event image' }}" style="object-fit:cover; height:200px;">
                            @else
                                <div class="w-full h-[200px] bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center rounded-t-[5px]">
                                    <span class="text-white text-4xl font-bold">{{ substr($event->name, 0, 1) }}</span>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title font-bold text-[20px]">{{ $event->title ?? 'Untitled Event' }}</h5>
                                
                                <div class="text-muted small mb-3">
                                    <div class="font-semibold text-[14px] mb-1">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ $start ? (is_string($start) ? $start : \Carbon\Carbon::parse($start)->format('M d, Y')) : 'TBA' }}
                                    </div>
                                    @if(!empty($event->location))
                                        <div class="font-semibold text-[14px]">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $event->location }}
                                        </div>
                                    @endif
                                </div>

                                <p class="card-text text-muted flex-grow-1 text-[14px] font-light">
                                    {{ \Illuminate\Support\Str::limit($event->description ?? $event->excerpt ?? '', 160) }}
                                </p>

                                <div class="mt-auto bg-[#01044e] text-center py-2 rounded-lg">
                                    <a href="{{ route('events.show', $event->id) }}" class="w-100 font-semibold text-[15px] no-underline text-white">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            @if(method_exists($events, 'links'))
                {{ $events->links() }}
            @endif
        </div>
    @else
        <div class="text-center py-5">
            <img src="https://via.placeholder.com/240x140?text=No+Events" alt="No events" class="mb-3">
            <h4 class="mb-2">No events found</h4>
            <p class="text-muted mb-3">Try adjusting your search or check back later.</p>
            <a href="{{ route('events.create') }}" class="btn btn-primary">Create an event</a>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection