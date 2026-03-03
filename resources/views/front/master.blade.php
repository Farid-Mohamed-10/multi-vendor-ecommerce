<!DOCTYPE html>
<html lang="en">

@include('buyer-dashboard.partials.head')

<body class="min-h-screen flex flex-col">

    {{-- ── HEADER ──────────────────────────────────────────── --}}
    @include('front.partials.navbar')
    {{-- ── PAGE BODY ──────────────────────────────────────── --}}
    <div class="flex flex-1 min-w-0 overflow-hidden">
        {{-- ── MAIN CONTENT ───────────────────────────────────── --}}
        <main class="flex-1 min-w-0 overflow-hidden">
            @yield(section: 'content')
        </main>
    </div>

    @include('front.partials.footer')

    @include('front.partials.scripts')

</body>

</html>
