@extends('admin.layouts.app')

@section('title', 'Add Portfolio Item')

@section('header', 'Add Portfolio Item')

@section('content')
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" id="title" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-300 @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" id="category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('category') border-red-300 @enderror" required>
                    <option value="">Select Category</option>
                    <option value="web" {{ old('category') == 'web' ? 'selected' : '' }}>Web Development</option>
                    <option value="mobile" {{ old('category') == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                    <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>Design</option>
                    <!-- Add more categories as needed -->
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-300 @enderror" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="client" class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                <input type="text" name="client" id="client" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('client') }}">
            </div>
            
            <div>
                <label for="project_date" class="block text-sm font-medium text-gray-700 mb-1">Project Date</label>
                <input type="date" name="project_date" id="project_date" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('project_date') }}">
            </div>
        </div>
        
        <div class="mb-6">
            <label for="project_url" class="block text-sm font-medium text-gray-700 mb-1">Project URL</label>
            <input type="url" name="project_url" id="project_url" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('project_url') }}" placeholder="https://example.com">
        </div>
        
        <div class="mb-6">
            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Image</label>
            <div class="mt-1 flex items-center">
                <div class="w-full">
                    <label class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        <span>Choose file</span>
                        <input type="file" name="thumbnail" id="thumbnail" class="sr-only" accept="image/*">
                    </label>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Max 2MB. Recommended dimensions: 800x600 pixels.</p>
            @error('thumbnail')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            
            <div id="image-preview" class="mt-3 hidden">
                <img src="#" alt="Image Preview" class="h-48 w-auto object-cover rounded-lg border border-gray-200">
            </div>
        </div>
        
        <div class="mb-6">
            <label for="gallery" class="block text-sm font-medium text-gray-700 mb-1">Project Gallery (Optional)</label>
            <div class="mt-1">
                <label class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                    <span>Choose multiple files</span>
                    <input type="file" name="gallery[]" id="gallery" class="sr-only" accept="image/*" multiple>
                </label>
            </div>
            <p class="text-xs text-gray-500 mt-1">You can select multiple images. Max 5 images, 2MB each.</p>
            @error('gallery')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            
            <div id="gallery-preview" class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 hidden">
                <!-- Preview images will be inserted here via JS -->
            </div>
        </div>
        
        <div class="mb-6">
            <label for="technologies" class="block text-sm font-medium text-gray-700 mb-1">Technologies Used</label>
            <input type="text" name="technologies" id="technologies" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('technologies') }}" placeholder="HTML, CSS, JavaScript, Laravel">
            <p class="text-xs text-gray-500 mt-1">Comma separated list of technologies used in this project.</p>
        </div>
        
        <div class="flex items-center mb-6">
            <input type="checkbox" name="status" id="status" value="published" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('status') == 'published' ? 'checked' : '' }}>
            <label for="status" class="ml-2 block text-sm text-gray-700">Publish immediately</label>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.portfolio.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                Save Portfolio Item
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Image preview functionality
    document.getElementById('thumbnail').onchange = function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.getElementById('image-preview');
            const previewImage = preview.querySelector('img');
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    };
    
    // Gallery preview functionality
    document.getElementById('gallery').onchange = function(event) {
        const files = event.target.files;
        const preview = document.getElementById('gallery-preview');
        
        // Clear previous previews
        preview.innerHTML = '';
        
        if (files.length > 0) {
            preview.classList.remove('hidden');
            
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-24 w-full object-cover rounded-lg border border-gray-200';
                    
                    div.appendChild(img);
                    preview.appendChild(div);
                }
                
                reader.readAsDataURL(file);
            });
        } else {
            preview.classList.add('hidden');
        }
    };
</script>
@endsection
