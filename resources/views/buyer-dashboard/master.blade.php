<!DOCTYPE html>
<html lang="en">

@include('buyer-dashboard.partials.head')

<body class="min-h-screen">

    {{-- ── HEADER ──────────────────────────────────────────── --}}
    @include('buyer-dashboard.partials.navbar')

    {{-- Sidebar overlay --}}
    <div class="sidebar-overlay" id="overlay"></div>

    {{-- ── PAGE BODY ──────────────────────────────────────── --}}
    <div class="flex">

        {{-- SIDEBAR --}}
        @include('buyer-dashboard.partials.sidebar')

        {{-- ── MAIN CONTENT ───────────────────────────────────── --}}
        <main class="flex-1 min-w-0 overflow-hidden">
            @yield(section: 'content')
        </main>


    </div>

    @include('buyer-dashboard.partials.scripts')

</body>

</html>
