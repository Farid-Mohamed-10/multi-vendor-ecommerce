@extends('admin-dashboard.master')
@section('title', 'Create Role')
@section('roles active', 'active')

@section('content')
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 overflow-hidden">

        {{-- ── Header ── --}}
        <div class="flex items-center gap-3 mb-6 fade-up">
            <a href="{{ route('admin-dashboard.roles.index') }}"
                class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Create Role</h1>
                <p class="text-sm text-gray-400 mt-0.5">Define a new role and set its name</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ── Left: Form ── --}}
            <div class="xl:col-span-2 flex flex-col gap-6">

                {{-- Role Details Card --}}
                <div class="bg-white rounded-2xl p-6 fade-up d1">

                    <h2 class="text-sm font-bold text-gray-700 mb-5 flex items-center gap-2">
                        <span
                            class="w-5 h-5 rounded-full text-white text-xs flex items-center justify-center font-bold flex-shrink-0"
                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">1</span>
                        Role Details
                    </h2>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-5">
                            <p class="text-sm font-semibold text-red-600 mb-2">Please fix the following errors:</p>
                            <ul class="text-xs text-red-500 space-y-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin-dashboard.roles.store') }}" method="POST" id="roleForm">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Role Name <span class="text-red-400 normal-case font-normal">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="e.g. editor, moderator, manager"
                                class="w-full px-4 py-2.5 rounded-xl text-sm border
                                          {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-purple-100 bg-purple-50/30' }}
                                          text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 mt-1.5">
                                Use lowercase, no spaces (e.g.
                                <span
                                    class="font-mono bg-purple-50 text-purple-600 px-1.5 py-0.5 rounded">super-admin</span>).
                                Must be unique.
                            </p>
                        </div>

                    </form>
                </div>



            </div>

            {{-- ── Right: Sidebar ── --}}
            <div class="flex flex-col gap-6">

                {{-- Save Card --}}
                <div class="bg-white rounded-2xl p-6 fade-up d1">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Save Role</h2>
                    <div class="flex flex-col gap-2">

                        <a href="{{ route('admin-dashboard.roles.index') }}"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-gray-400 hover:text-gray-600 transition-colors text-center">
                            Cancel
                        </a>
                    </div>
                </div>

                {{-- Tips Card --}}
                <div class="bg-white rounded-2xl p-6 fade-up d2">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Tips</h2>
                    <ul class="flex flex-col gap-3">
                        @foreach (['Role names must be unique and lowercase.', 'Use hyphens for multi-word names (e.g. super-admin).', 'Assign roles to users from the Users section.', 'The Super Admin role bypasses all permission checks.'] as $tip)
                            <li class="flex items-start gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-purple-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $tip }}
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

    </main>
@endsection
