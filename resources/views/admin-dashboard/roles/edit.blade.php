@extends('admin-dashboard.master')
@section('title', 'Edit Role')
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
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Edit Role</h1>
                    <p class="text-sm text-gray-400 mt-0.5">
                        Updating
                        <span class="font-semibold capitalize" style="color:#7C3AED">{{ $role->name }}</span>
                    </p>
                </div>
            </div>
            <a href="{{ route('admin-dashboard.roles.show', $role) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-purple-600 border border-purple-200 hover:bg-purple-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View
            </a>
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

                    <form action="{{ route('admin-dashboard.roles.update', $role) }}" method="POST" id="roleForm">
                        @csrf @method('PUT')

                        <div class="flex flex-col gap-4">

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                    Role Name <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $role->name) }}"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border
                                              {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-purple-100 bg-purple-50/30' }}
                                              text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                                @error('name')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror

                            </div>

                            {{-- ── Right: Sidebar ── --}}
                            <div class="flex flex-col gap-6">

                                {{-- Save Card --}}
                                <div class="bg-white rounded-2xl p-6 fade-up d1">
                                    <h2 class="text-sm font-bold text-gray-700 mb-4">Update Role</h2>
                                    <div class="flex flex-col gap-2">
                                        <button type="submit" form="roleForm"
                                            class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Changes
                                        </button>
                                        <a href="{{ route('admin-dashboard.roles.index') }}"
                                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-gray-400 hover:text-gray-600 transition-colors text-center">
                                            Cancel
                                        </a>
                                    </div>

                                    {{-- Danger Zone --}}
                                    <div class="mt-5 pt-5 border-t border-gray-50">
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Danger
                                            Zone</p>
                                        <form action="{{ route('admin-dashboard.roles.destroy', $role) }}" method="POST"
                                            onsubmit="return confirm('Permanently delete role \'{{ addslashes($role->name) }}\'? All users with this role will be affected.')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors border border-red-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete Role
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Role Info Card --}}
                                <div class="bg-white rounded-2xl p-6 fade-up d2">
                                    <h2 class="text-sm font-bold text-gray-700 mb-4">Role Info</h2>
                                    <dl class="divide-y divide-gray-50">
                                        <div class="flex items-center justify-between py-2.5">
                                            <dt class="text-xs text-gray-400">Role ID</dt>
                                            <dd class="text-xs font-mono font-semibold text-gray-700">#{{ $role->id }}
                                            </dd>
                                        </div>
                                        <div class="flex items-center justify-between py-2.5">
                                            <dt class="text-xs text-gray-400">Guard</dt>
                                            <dd class="text-xs font-semibold text-gray-700">{{ $role->guard_name }}</dd>
                                        </div>

                                        <div class="flex items-center justify-between py-2.5">
                                            <dt class="text-xs text-gray-400">Users</dt>
                                            <dd class="text-xs font-semibold text-gray-700">{{ $role->users->count() }}
                                            </dd>
                                        </div>
                                        <div class="flex items-center justify-between py-2.5">
                                            <dt class="text-xs text-gray-400">Created</dt>
                                            <dd class="text-xs font-semibold text-gray-700">
                                                {{ $role->created_at->format('d M, Y') }}</dd>
                                        </div>
                                    </dl>
                                </div>

                            </div>
                        </div>

    </main>
@endsection
