@extends('admin-dashboard.master')
@section('title', ucfirst($role->name))
@section('roles active', 'active')

@section('content')
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 overflow-hidden">

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3 fade-up">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin-dashboard.roles.index') }}"
                    class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 capitalize">{{ $role->name }}</h1>
                    <p class="text-sm text-gray-400 mt-0.5">Role details &amp; assigned users</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin-dashboard.roles.edit', $role) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                    style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Role
                </a>
                <form action="{{ route('admin-dashboard.roles.destroy', $role) }}" method="POST"
                    onsubmit="return confirm('Permanently delete role \'{{ addslashes($role->name) }}\'?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="p-2.5 rounded-xl border border-red-100 text-red-400 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ── Left Column ── --}}
            <div class="xl:col-span-2 flex flex-col gap-6">

                {{-- Role Banner Card --}}
                <div class="bg-white rounded-2xl overflow-hidden fade-up d1">
                    <div class="h-20 w-full" style="background:linear-gradient(135deg,#7C3AED,#EC4899)"></div>
                    <div class="px-6 pb-6">
                        <div class="flex items-end justify-between -mt-8 mb-4 flex-wrap gap-3">
                            <div class="w-16 h-16 rounded-2xl border-4 border-white flex items-center justify-center flex-shrink-0"
                                style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9a12.02 12.02 0 00-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-600">
                                    {{ $role->guard_name }}
                                </span>
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800 capitalize">{{ $role->name }}</h2>
                        <p class="text-sm text-gray-400">
                            {{ $role->users->count() }} {{ Str::plural('user', $role->users->count()) }} assigned
                            &bull; Created {{ $role->created_at->format('d M, Y') }}
                        </p>
                    </div>
                </div>



                {{-- Assigned Users Table --}}
                <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up d3">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm sm:text-base font-bold text-gray-800">
                            Assigned Users
                            <span class="text-xs font-semibold ml-1 px-2 py-0.5 rounded-full bg-purple-50 text-purple-600">
                                {{ $role->users->count() }}
                            </span>
                        </h2>
                        <a href="{{ route('admin-dashboard.users.index') }}"
                            class="text-xs text-purple-600 font-semibold hover:text-purple-800 transition-colors">
                            Manage Users →
                        </a>
                    </div>

                    @if ($role->users->isEmpty())
                        <div class="flex flex-col items-center gap-2 py-10">
                            <svg class="w-10 h-10 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 11a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0" />
                            </svg>
                            <p class="text-sm text-gray-400">No users assigned to this role yet.</p>
                        </div>
                    @else
                        <div class="table-wrap">
                            <table class="w-full text-sm min-w-[400px]">
                                <thead>
                                    <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                                        <th class="pb-3 font-medium pr-4">User</th>
                                        <th class="pb-3 font-medium pr-4 hidden sm:table-cell">Email</th>
                                        <th class="pb-3 font-medium pr-4 hidden md:table-cell">Joined</th>
                                        <th class="pb-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($role->users as $user)
                                        <tr class="hover:bg-purple-50/30 transition-colors">
                                            <td class="py-3 pr-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                                        style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                    <span
                                                        class="font-semibold text-gray-700 whitespace-nowrap">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 pr-4 text-gray-500 text-xs hidden sm:table-cell">
                                                {{ $user->email }}</td>
                                            <td
                                                class="py-3 pr-4 text-gray-400 text-xs hidden md:table-cell whitespace-nowrap">
                                                {{ $user->created_at->format('d M, Y') }}
                                            </td>
                                            <td class="py-3 text-right">
                                                <a href="{{ route('admin-dashboard.users.show', $user) }}"
                                                    class="text-xs text-purple-600 font-semibold hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>

            {{-- ── Right: Sidebar ── --}}
            <div class="flex flex-col gap-6">

                {{-- Role Details Card --}}
                <div class="bg-white rounded-2xl p-6 fade-up d1">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Role Details</h2>
                    <dl class="divide-y divide-gray-50">
                        <div class="flex items-center justify-between py-3">
                            <dt class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9a12.02 12.02 0 00-.382-3.016z" />
                                </svg>
                                Role ID
                            </dt>
                            <dd class="text-sm font-mono text-gray-500">#{{ $role->id }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt
                                class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Guard
                            </dt>
                            <dd class="text-sm font-semibold text-gray-700">{{ $role->guard_name }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt
                                class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Users
                            </dt>
                            <dd class="text-sm font-semibold text-gray-700">{{ $role->users->count() }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt
                                class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Created
                            </dt>
                            <dd class="text-sm text-gray-700">{{ $role->created_at->format('d M, Y') }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt
                                class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Updated
                            </dt>
                            <dd class="text-sm text-gray-700">{{ $role->updated_at->format('d M, Y') }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-2xl p-6 fade-up d2">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Quick Actions</h2>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('admin-dashboard.roles.edit', $role) }}"
                            class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 border border-gray-100 hover:border-purple-200 hover:bg-purple-50/30 transition-colors">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Role
                        </a>
                        <a href="{{ route('admin-dashboard.users.index') }}"
                            class="w-full inline-flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 border border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0" />
                            </svg>
                            Manage Users
                        </a>

                    </div>
                </div>

            </div>
        </div>

    </main>
@endsection
