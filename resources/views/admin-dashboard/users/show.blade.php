@extends('admin-dashboard.master')
@section('title', $user->name)
@section('users active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin-dashboard.users.index') }}"
                    class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">User Profile</h1>
                    <p class="text-sm text-gray-400 mt-0.5">Viewing details for {{ $user->name }}</p>
                </div>
            </div>
            <a href="{{ route('admin-dashboard.users.edit', $user) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit User
            </a>
        </div>

        {{-- Profile Banner Card --}}
        <div class="bg-white rounded-2xl overflow-hidden mb-5" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">

            {{-- Banner --}}
            <div class="h-24 w-full" style="background:linear-gradient(135deg,#7C3AED,#EC4899)"></div>

            {{-- Avatar + Badges --}}
            <div class="px-6 pb-6">
                <div class="flex items-end justify-between -mt-10 mb-4 flex-wrap gap-3">
                    <div class="w-20 h-20 rounded-2xl border-4 border-white flex items-center justify-center text-white text-2xl font-bold overflow-hidden flex-shrink-0"
                        style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover"
                                alt="{{ $user->name }}" />
                        @else
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        @endif
                    </div>
                    <div class="flex items-center gap-2 mb-1">
                        <span
                            class="text-xs font-semibold px-3 py-1 rounded-full
                        {{ ($user->status ?? 'active') === 'active' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-400' }}">
                            {{ ucfirst($user->status ?? 'Active') }}
                        </span>
                        @forelse ($user->roles as $role)
                            <span
                                class="text-xs font-semibold px-3 py-1 rounded-full
                            @if ($role->name === 'admin') bg-purple-50 text-purple-600
                            @elseif ($role->name === 'seller')
                                bg-blue-50 text-blue-600
                            @else
                                bg-gray-100 text-gray-600 @endif">
                                {{ ucfirst($role->name) }}
                            </span>
                        @empty
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-100 text-gray-600">User</span>
                        @endforelse
                    </div>
                </div>
                <h2 class="text-lg font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-sm text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        {{-- Details Card --}}
        <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <h3 class="text-sm font-bold text-gray-700 mb-4">Account Details</h3>

            <dl class="divide-y divide-gray-50">

                <div class="flex items-center justify-between py-3">
                    <dt class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        User ID
                    </dt>
                    <dd class="text-sm font-mono text-gray-500">#{{ $user->id }}</dd>
                </div>

                <div class="flex items-center justify-between py-3">
                    <dt class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email
                    </dt>
                    <dd class="text-sm text-gray-700">{{ $user->email }}</dd>
                </div>

                <div class="flex items-center justify-between py-3">
                    <dt class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Phone
                    </dt>
                    <dd class="text-sm text-gray-700">{{ $user->phone ?? '—' }}</dd>
                </div>

                <div class="flex items-center justify-between py-3">
                    <dt class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Joined
                    </dt>
                    <dd class="text-sm text-gray-700">{{ $user->created_at->format('d M, Y — h:i A') }}</dd>
                </div>

                <div class="flex items-center justify-between py-3">
                    <dt class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Last Updated
                    </dt>
                    <dd class="text-sm text-gray-700">{{ $user->updated_at->format('d M, Y — h:i A') }}</dd>
                </div>

            </dl>

            {{-- Footer Actions --}}
            <div class="flex items-center justify-between pt-5 mt-2 border-t border-gray-50 flex-wrap gap-3">

                <form action="{{ route('admin-dashboard.users.destroy', $user) }}" method="POST"
                    onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete User
                    </button>
                </form>

                <a href="{{ route('admin-dashboard.users.edit', $user) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                    style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit User
                </a>

            </div>
        </div>

    </div>
@endsection
