@extends('admin-dashboard.master')
@section('title', 'Roles')
@section('roles active', 'active')

@section('content')
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 overflow-hidden">

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3 fade-up">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Roles</h1>
                <p class="text-sm text-gray-400 mt-0.5">Manage roles</p>
            </div>
        </div>

        {{-- ── Flash Message ── --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl mb-5 fade-up">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Stats ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d1">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9a12.02 12.02 0 00-.382-3.016z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Total Roles</p>
                <p class="text-2xl font-bold text-gray-800">{{ $roles->count() }}</p>
            </div>



            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d3">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box icon-products">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Assigned Users</p>
                <p class="text-2xl font-bold text-gray-800">{{ $roles->sum(fn($r) => $r->users->count()) }}</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d4">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box icon-revenue">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Unassigned Users</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ \App\Models\User::whereDoesntHave('roles')->count() }}
                </p>
            </div>
        </div>

        {{-- ── Role Cards Grid ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 mb-6">
            @php
                $palette = [
                    ['grad' => 'linear-gradient(135deg,#7C3AED,#A78BFA)', 'light' => '#EDE9FE', 'text' => '#7C3AED'],
                    ['grad' => 'linear-gradient(135deg,#EC4899,#F9A8D4)', 'light' => '#FCE7F3', 'text' => '#EC4899'],
                    ['grad' => 'linear-gradient(135deg,#3B82F6,#93C5FD)', 'light' => '#EFF6FF', 'text' => '#3B82F6'],
                    ['grad' => 'linear-gradient(135deg,#10B981,#6EE7B7)', 'light' => '#ECFDF5', 'text' => '#10B981'],
                    ['grad' => 'linear-gradient(135deg,#F59E0B,#FCD34D)', 'light' => '#FFFBEB', 'text' => '#F59E0B'],
                    ['grad' => 'linear-gradient(135deg,#EF4444,#FCA5A5)', 'light' => '#FEF2F2', 'text' => '#EF4444'],
                ];
            @endphp

            @forelse ($roles as $role)
                @php $c = $palette[$loop->index % count($palette)]; @endphp

                <div class="stat-card bg-white rounded-2xl p-5 group fade-up">

                    {{-- Icon & Name Row --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0"
                                style="background:{{ $c['grad'] }}">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9a12.02 12.02 0 00-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 capitalize">{{ $role->name }}</h3>
                                <p class="text-xs text-gray-400">
                                    {{ $role->users->count() }} {{ Str::plural('user', $role->users->count()) }}
                                </p>
                            </div>
                        </div>

                        {{-- Hover actions --}}
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin-dashboard.roles.show', $role) }}"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors"
                                title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin-dashboard.roles.edit', $role) }}"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin-dashboard.roles.destroy', $role) }}" method="POST"
                                onsubmit="return confirm('Delete role \'{{ addslashes($role->name) }}\'? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                    title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>



                    {{-- Footer: Avatars + Link --}}
                    <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                        <div class="flex -space-x-2">
                            @forelse ($role->users->take(4) as $user)
                                <div class="w-7 h-7 rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-bold"
                                    style="background:{{ $c['grad'] }}" title="{{ $user->name }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @empty
                                <span class="text-xs text-gray-400 italic">No users yet</span>
                            @endforelse
                            @if ($role->users->count() > 4)
                                <div
                                    class="w-7 h-7 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    +{{ $role->users->count() - 4 }}
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('admin-dashboard.roles.show', $role) }}"
                            class="text-xs font-semibold hover:underline transition-colors"
                            style="color:{{ $c['text'] }}">
                            View details →
                        </a>
                    </div>
                </div>

            @empty
                <div class="sm:col-span-2 xl:col-span-3 bg-white rounded-2xl p-16 flex flex-col items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-purple-50">
                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9a12.02 12.02 0 00-.382-3.016z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">No roles found</p>

                </div>
            @endforelse
        </div>

        {{-- ── Roles Table ── --}}
        <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up">
            <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                <h2 class="text-sm sm:text-base font-bold text-gray-800">All Roles</h2>
                <div class="relative">
                    <input type="text" placeholder="Search roles…"
                        class="pl-8 pr-4 py-2 rounded-xl text-xs border border-purple-100 bg-purple-50/40 focus:outline-none focus:border-purple-400 text-gray-600 placeholder-gray-400">
                    <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <div class="table-wrap">
                <table class="w-full text-sm min-w-[540px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">#</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">Role Name</th>

                            <th class="pb-3 font-medium pr-4 whitespace-nowrap hidden md:table-cell">Users</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap hidden md:table-cell">Created</th>
                            <th class="pb-3 font-medium whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($roles as $role)
                            <tr class="hover:bg-purple-50/30 transition-colors">
                                <td class="py-3 pr-4 text-gray-400 font-mono text-xs">{{ $role->id }}</td>

                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
                                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9a12.02 12.02 0 00-.382-3.016z" />
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-gray-700 capitalize">{{ $role->name }}</span>
                                    </div>
                                </td>



                                <td class="py-3 pr-4 text-gray-500 text-xs hidden md:table-cell">
                                    {{ $role->users->count() }} {{ Str::plural('user', $role->users->count()) }}
                                </td>

                                <td class="py-3 pr-4 text-gray-400 text-xs hidden md:table-cell whitespace-nowrap">
                                    {{ $role->created_at->format('d M, Y') }}
                                </td>

                                <td class="py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin-dashboard.roles.show', $role) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors"
                                            title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin-dashboard.roles.edit', $role) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin-dashboard.roles.destroy', $role) }}" method="POST"
                                            onsubmit="return confirm('Delete role \'{{ addslashes($role->name) }}\'?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                                title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-sm text-gray-400">No roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
