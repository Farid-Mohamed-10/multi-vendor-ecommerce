@extends('buyer-dashboard.master')
@section('title', 'My Profile')
@section('profile active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6">My Profile</h1>

        {{-- Flash --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buyer-dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- Avatar Card --}}
                <div class="bg-white rounded-2xl p-6 flex flex-col items-center"
                    style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 overflow-hidden"
                        style="background:linear-gradient(135deg,#7C3AED,#EC4899)" id="avatarPreviewContainer">
                        @if ($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                class="w-full h-full object-cover" id="avatarPreview" alt="">
                        @else
                            <span id="avatarInitials">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <label
                        class="cursor-pointer px-4 py-2 rounded-xl text-sm font-semibold text-purple-600 border border-purple-200 hover:border-purple-300 hover:bg-purple-50 transition-colors">
                        Change Photo
                        <input type="file" name="avatar" class="hidden" accept="image/*"
                            onchange="if(this.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('avatarPreviewContainer').innerHTML='<img src=\''+e.target.result+'\' class=\'w-full h-full object-cover\' />'};r.readAsDataURL(this.files[0])}">
                    </label>
                    <p class="text-xs text-gray-400 mt-2">JPG, PNG. Max 2MB</p>
                </div>

                {{-- Details --}}
                <div class="xl:col-span-2 bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <h2 class="text-sm font-bold text-gray-700 mb-5">Personal Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs text-gray-500 font-medium mb-1.5">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 font-medium mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 font-medium mb-1.5">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white">
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
