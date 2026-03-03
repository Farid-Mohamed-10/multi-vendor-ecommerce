@extends('admin-dashboard.master')
@section('title', 'Edit User')
@section('users active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin-dashboard.users.index') }}"
                class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Edit User</h1>
                <p class="text-sm text-gray-400 mt-0.5">
                    Updating details for <span class="text-purple-500 font-medium">{{ $user->name }}</span>
                </p>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl p-6 sm:p-8" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6">
                    <p class="text-sm font-semibold text-red-600 mb-2">Please fix the following errors:</p>
                    <ul class="text-xs text-red-500 space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin-dashboard.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                {{-- Avatar Preview --}}
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-2xl font-bold overflow-hidden relative"
                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" id="avatarImg"
                                    class="w-full h-full object-cover absolute inset-0" alt="{{ $user->name }}" />
                            @else
                                <span id="avatarInitials">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                <img id="avatarImg" src="" alt=""
                                    class="hidden w-full h-full object-cover absolute inset-0" />
                            @endif
                        </div>
                        <label for="avatar"
                            class="absolute -bottom-2 -right-2 w-7 h-7 rounded-full bg-white border-2 border-purple-200 flex items-center justify-center cursor-pointer hover:border-purple-400 transition-colors shadow-sm">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                            </svg>
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Name --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Full
                            Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-purple-100 bg-purple-50/30' }} text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email
                            Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-purple-100 bg-purple-50/30' }} text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            New Password <span class="text-gray-300 font-normal normal-case">(leave blank to keep)</span>
                        </label>
                        <input type="password" name="password" placeholder="Min 8 characters"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-purple-100 bg-purple-50/30' }} text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Confirm
                            Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat new password"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                    </div>

                    {{-- Role --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Role</label>
                        <select name="role"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 text-gray-600 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                            <option value="">Select a role…</option>
                            @foreach (\Spatie\Permission\Models\Role::where('name', '!=', 'admin')->get() as $role)
                                <option value="{{ $role->name }}" @selected($user->roles->pluck('name')->contains($role->name))>
                                    {{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Phone --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Phone <span class="text-gray-300 font-normal normal-case">(optional)</span>
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                            placeholder="+91 00000 00000"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border {{ $errors->has('phone') ? 'border-red-300 bg-red-50' : 'border-purple-100 bg-purple-50/30' }} text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-400 focus:bg-white transition-colors">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between gap-3 mt-8 pt-6 border-t border-gray-50">

                    {{-- Delete --}}
                    {{-- <form action="{{ route('admin-dashboard.users.destroy', $user) }}" method="POST"
                        onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form> --}}

                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('admin-dashboard.users.index') }}"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                    </div>

                </div>

            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('avatar').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('avatarImg');
                img.src = e.target.result;
                img.classList.remove('hidden');
                const initials = document.getElementById('avatarInitials');
                if (initials) initials.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush
