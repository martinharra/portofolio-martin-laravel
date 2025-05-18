@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('header', 'Edit Profile')

@section('content')
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-6 flex flex-col items-center">
            <div class="relative mb-4">
                @if($profile->avatar ?? null)
                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Profile Avatar" class="w-32 h-32 object-cover rounded-full border-4 border-indigo-100">
                @else
                    <div class="w-32 h-32 rounded-full bg-indigo-100 flex items-center justify-center border-4 border-indigo-100">
                        <i class="fas fa-user text-indigo-500 text-4xl"></i>
                    </div>
                @endif
                
                <label for="avatar" class="absolute bottom-0 right-0 bg-indigo-600 hover:bg-indigo-700 rounded-full p-2 text-white cursor-pointer shadow-sm">
                    <i class="fas fa-camera"></i>
                    <input type="file" name="avatar" id="avatar" class="sr-only" accept="image/*">
                </label>
            </div>
            
            <p class="text-xs text-gray-500">Click the camera icon to change your profile picture</p>
            @error('avatar')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" id="name" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror" value="{{ old('name', $profile->name ?? '') }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title / Position</label>
                <input type="text" name="job_title" id="job_title" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('job_title') border-red-300 @enderror" value="{{ old('job_title', $profile->job_title ?? '') }}" required>
                @error('job_title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio / About Me</label>
            <textarea name="bio" id="bio" rows="5" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('bio') border-red-300 @enderror" required>{{ old('bio', $profile->bio ?? '') }}</textarea>
            @error('bio')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror" value="{{ old('email', $profile->email ?? '') }}" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone" id="phone" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('phone') border-red-300 @enderror" value="{{ old('phone', $profile->phone ?? '') }}">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
            <input type="text" name="location" id="location" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('location') border-red-300 @enderror" value="{{ old('location', $profile->location ?? '') }}" placeholder="City, Country">
            @error('location')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <h3 class="text-lg font-medium text-gray-800 mb-3">Social Media Links</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fab fa-linkedin text-indigo-500"></i> LinkedIn
                </label>
                <input type="url" name="linkedin" id="linkedin" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('linkedin', $profile->linkedin ?? '') }}" placeholder="https://linkedin.com/in/username">
            </div>
            
            <div>
                <label for="github" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fab fa-github text-indigo-500"></i> GitHub
                </label>
                <input type="url" name="github" id="github" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('github', $profile->github ?? '') }}" placeholder="https://github.com/username">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fab fa-twitter text-indigo-500"></i> Twitter
                </label>
                <input type="url" name="twitter" id="twitter" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('twitter', $profile->twitter ?? '') }}" placeholder="https://twitter.com/username">
            </div>
            
            <div>
                <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fab fa-instagram text-indigo-500"></i> Instagram
                </label>
                <input type="url" name="instagram" id="instagram" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('instagram', $profile->instagram ?? '') }}" placeholder="https://instagram.com/username">
            </div>
        </div>
        
        <div class="mb-6">
            <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-globe text-indigo-500"></i> Personal Website
            </label>
            <input type="url" name="website" id="website" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('website', $profile->website ?? '') }}" placeholder="https://example.com">
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                Save Profile
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Avatar preview
    document.getElementById('avatar').onchange = function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            const avatarContainer = event.target.closest('.relative');
            const avatarImg = avatarContainer.querySelector('img') || document.createElement('img');
            
            if (!avatarContainer.querySelector('img')) {
                // Replace the placeholder with an actual image
                avatarContainer.querySelector('div')?.remove();
                avatarImg.classList.add('w-32', 'h-32', 'object-cover', 'rounded-full', 'border-4', 'border-indigo-100');
                avatarContainer.prepend(avatarImg);
            }
            
            reader.onload = function(e) {
                avatarImg.src = e.target.result;
                avatarImg.alt = "Profile Avatar";
            }
            
            reader.readAsDataURL(file);
        }
    };
</script>
@endsection
