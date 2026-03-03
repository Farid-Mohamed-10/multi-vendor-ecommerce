@extends('admin-dashboard.master')
@section('title', 'Users')
@section('users active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Users</h1>
                <p class="text-sm text-gray-400 mt-0.5">Manage all registered users</p>
            </div>
            <a href="{{ route('admin-dashboard.users.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                style="background: linear-gradient(135deg, #7C3AED, #EC4899)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add User
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('admin-dashboard.users.index') }}"
            class="bg-white rounded-2xl p-4 mb-5 flex flex-wrap gap-3 items-center"
            style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Search users…" value="{{ request('search') }}"
                    class="w-full pl-9 pr-4 py-2 rounded-xl text-sm border border-purple-100 bg-purple-50/40 focus:outline-none focus:border-purple-400 text-gray-600 placeholder-gray-400">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <select name="role"
                class="text-sm border border-purple-100 bg-purple-50/40 rounded-xl px-3 py-2 text-gray-500 focus:outline-none focus:border-purple-400">
                <option value="">All Roles</option>
                @foreach ($allRoles as $role)
                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-purple-500 hover:bg-purple-600 transition-colors">
                Search
            </button>
            @if (request('search') || request('role'))
                <a href="{{ route('admin-dashboard.users.index') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-purple-600 hover:text-purple-700 border border-purple-200 hover:border-purple-300 transition-colors">
                    Clear
                </a>
            @endif
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <div class="table-wrap">
                <table class="w-full text-sm min-w-[600px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                            <th class="px-6 py-4 font-medium">#</th>
                            <th class="px-6 py-4 font-medium">User</th>
                            <th class="px-6 py-4 font-medium">Email</th>
                            <th class="px-6 py-4 font-medium">Phone</th>
                            <th class="px-6 py-4 font-medium hidden sm:table-cell">Role</th>
                            <th class="px-6 py-4 font-medium hidden md:table-cell">Joined</th>
                            <th class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($users as $user)
                            <tr class="hover:bg-purple-50/20 transition-colors">

                                <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>

                                {{-- Avatar + Name --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 overflow-hidden"
                                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                                            @if ($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                                    class="w-full h-full object-cover" alt="">
                                            @else
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            @endif
                                        </div>
                                        <span
                                            class="font-semibold text-gray-700 whitespace-nowrap">{{ $user->name }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $user->phone }}</td>

                                <td class="px-6 py-4 hidden sm:table-cell">
                                    @forelse ($user->roles as $role)
                                        <span
                                            class="text-xs font-semibold px-2.5 py-1 rounded-full
                                    @if ($role->name === 'admin') bg-purple-50 text-purple-600
                                    @elseif ($role->name === 'seller')
                                        bg-blue-50 text-blue-600
                                    @else
                                        bg-gray-100 text-gray-600 @endif">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span
                                            class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-600">User</span>
                                    @endforelse
                                </td>

                                <td class="px-6 py-4 text-gray-400 text-xs hidden md:table-cell whitespace-nowrap">
                                    {{ $user->created_at->format('d M, Y') }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View --}}
                                        <a href="{{ route('admin-dashboard.users.show', $user) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors"
                                            title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('admin-dashboard.users.edit', $user) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        {{-- Delete --}}
                                        <form action="{{ route('admin-dashboard.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
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
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-purple-50">
                                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 11a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium">No users found</p>
                                        <a href="{{ route('admin-dashboard.users.create') }}"
                                            class="text-xs text-purple-600 font-semibold hover:underline">
                                            + Add your first user
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
