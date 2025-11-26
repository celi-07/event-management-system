<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title','Dashboard') • EMS</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
<div x-data="{ open:false }" class="min-h-screen">

  {{-- Sidebar --}}
  <aside
    class="fixed inset-y-0 left-0 z-40 w-72 border-r border-gray-200 p-4 transition-transform -translate-x-full md:translate-x-0 bg-white"
    :class="{ 'translate-x-0': open }"
  >
    <div class="flex items-center gap-2 mb-8">
      <div class="h-9 w-9 rounded-2xl bg-indigo-600"></div>
      <span class="font-semibold">EMS</span>
    </div>

    <nav class="space-y-1 text-sm">
      <a href="{{ route('dashboard') }}" class="{{ $page === 'Dashboard' ? 'flex items-center justify-between rounded-xl px-3 py-2 bg-indigo-50 text-indigo-700' : 'block rounded-xl px-3 py-2 hover:bg-gray-100' }}">
        <span>Dashboard</span>
      </a>
      <a href="{{ url('/my-events') }}" class="{{ $page === 'My Events' ? 'flex items-center justify-between rounded-xl px-3 py-2 bg-indigo-50 text-indigo-700' : 'block rounded-xl px-3 py-2 hover:bg-gray-100' }}">My Events</a>
      <a href="{{ url('/invitations') }}" class="{{ $page === 'Invitations' ? 'flex items-center justify-between rounded-xl px-3 py-2 bg-indigo-50 text-indigo-700' : 'block rounded-xl px-3 py-2 hover:bg-gray-100' }}">Invitations</a>
      <a href="{{ url('/discover') }}" class="{{ $page === 'Discover' ? 'flex items-center justify-between rounded-xl px-3 py-2 bg-indigo-50 text-indigo-700' : 'block rounded-xl px-3 py-2 hover:bg-gray-100' }}">Discover</a>
      <a href="{{ url('/profile') }}" class="{{ $page === 'Profile' ? 'flex items-center justify-between rounded-xl px-3 py-2 bg-indigo-50 text-indigo-700' : 'block rounded-xl px-3 py-2 hover:bg-gray-100' }}">Profile</a>
      <div class="pt-4">
        <a href="{{ url('/create/events') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-3 py-2 text-white">
          <img src="{{ asset('images/add.svg') }}" class="h-4 w-4" alt="Plus Icon" />
          Create Event
        </a>
      </div>
    </nav>

    <div class="absolute bottom-4 left-4 right-4 rounded-xl border border-gray-200 p-3 bg-gray-50">
      <div class="text-xs text-gray-600 font-bold mb-1">Pro Tip</div>
      <div class="text-xs text-gray-600 text-justify">Events with banners and clear agendas get 2–3× more attendees. Ship that poster today.</div>
    </div>
  </aside>

  {{-- Backdrop (mobile only) --}}
  <div
    x-show="open"
    x-transition.opacity
    @click="open=false"
    class="fixed inset-0 z-30 bg-black/40 md:hidden"
  ></div>

  {{-- Main --}}
  <div class="md:ml-72">
    {{-- Topbar --}}
    <header class="sticky top-0 z-20 bg-white border-b border-gray-200">
      <div class="flex items-center justify-end gap-3 px-4 py-3">
        <button @click="open=!open" class="md:hidden rounded-lg p-2 hover:bg-gray-100">
          <img src="{{ asset('images/burger.svg') }}" class="h-5 w-5 opacity-50" alt="Menu" />
        </button>
        @if($page === 'Dashboard' || $page === 'My Events' || $page === 'Invitations' || $page === 'Discover')
          <div class="flex-1 max-w-xl mr-20">
            <form 
              method="GET" 
              action="{{ $page === 'Discover' || $page === 'Dashboard' ? url('/discover') : ($page === 'Invitations' ? url('/invitations') : ($page === 'My Events' ? url('/my-events') : '#')) }}"
            >
              <div class="relative">
                <input 
                  class="w-full rounded-xl border-gray-200 bg-gray-50 pl-10 pr-3 py-2 focus:bg-white focus:border-indigo-400 focus:ring-indigo-400"
                  value="{{ request('q') }}"
                  name="q" 
                  placeholder="Search events, hosts, tags…" 
              />
                <img src="{{ asset('images/search.svg') }}" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 opacity-50" alt="Search Icon" />
              </div>
            </form>
          </div>
        @endif
        <div class="flex items-center gap-3">
            <a href="{{ url('/invitations') }}" class="relative rounded-lg p-2 hover:bg-gray-100">
                <span class="absolute -top-1 -right-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-indigo-600 text-white text-xs px-1">3</span>
                <img src="{{ asset('images/invitation.svg') }}" class="h-5 w-5" alt="Invitations" />
            </a>
            <a href="{{ url('/profile') }}" class="flex items-center gap-2 rounded-lg px-2 py-1 hover:bg-gray-100">
                <img src="https://i.pravatar.cc/40?img=5" class="h-8 w-8 rounded-full" alt="avatar">
                <span class="hidden sm:block text-sm font-medium">You</span>
            </a>
        </div>
      </div>
    </header>

    {{-- Content --}}
    <main class="p-4 md:p-6">
      @yield('content')
    </main>
  </div>
</div>
</body>
</html>
