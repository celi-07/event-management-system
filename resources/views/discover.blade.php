@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Discover Events</h1>
            <p class="text-muted mb-0">Browse upcoming events near you.</p>
        </div>
    </div>

    @if($events->count())
        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @php
                            $image = $event->image ?? ($event->image_url ?? null);
                            $imageUrl = $image ? (Str::startsWith($image, ['http://','https://']) ? $image : asset('storage/'.$image)) : 'https://via.placeholder.com/600x300?text=No+Image';
                            $start = $event->start_date ?? $event->date ?? null;
                        @endphp

                        <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $event->title ?? 'Event image' }}" style="object-fit:cover; height:180px;">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $event->title ?? 'Untitled Event' }}</h5>
                            <div class="text-muted small mb-2">
                                <span class="me-3">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $start ? (is_string($start) ? $start : \Carbon\Carbon::parse($start)->format('M d, Y')) : 'TBA' }}
                                </span>
                                @if(!empty($event->location))
                                    <span>
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $event->location }}
                                    </span>
                                @endif
                            </div>

                            <p class="card-text text-muted mb-3 flex-grow-1">
                                {{ \Illuminate\Support\Str::limit($event->description ?? $event->excerpt ?? '', 140) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary btn-sm">View</a>
                                @if(!empty($event->capacity))
                                    <small class="text-muted">{{ $event->attendees_count ?? 0 }} / {{ $event->capacity }} going</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
@endsection