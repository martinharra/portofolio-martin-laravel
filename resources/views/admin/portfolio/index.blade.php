@extends('admin.layouts.app')

@section('title', 'Portfolio Items')

@section('header', 'Portfolio Items')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .thumbnail-container {
        width: 40px;
        height: 40px;
        overflow: hidden;
        border-radius: 6px;
    }
    
    .portfolio-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .delete-animation {
        transition: all 0.5s ease;
    }
    
    .deleting {
        transform: translateX(10px);
        opacity: 0.5;
    }
</style>
@endsection

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-semibold text-gray-800">All Portfolio Items</h2>
    <a href="{{ route('admin.portfolio.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition">
        <i class="fas fa-plus mr-2"></i> Add New
    </a>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-200 flex justify-between items-center">
        <form action="{{ route('admin.portfolio.index') }}" method="GET" class="flex items-center">
            <div class="relative">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            <button type="submit" class="ml-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                Search
            </button>
        </form>
        
        <div class="flex items-center">
            <select name="category" id="category" class="border border-gray-300 rounded-lg py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Categories</option>
                <option value="web">Web Development</option>
                <option value="mobile">Mobile App</option>
                <option value="design">Design</option>
                <!-- Add more categories as needed -->
            </select>
        </div>
    </div>
    
    @if(count($portfolioItems ?? []))
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($portfolioItems as $item)
            <tr id="portfolio-row-{{ $item->id }}" class="delete-animation">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg overflow-hidden">
                            @if($item->thumbnail)
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="h-10 w-10 object-cover">
                            @else
                                <div class="h-10 w-10 flex items-center justify-center bg-indigo-100 text-indigo-500">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                        {{ $item->category }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($item->status === 'published')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Published
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Draft
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $item->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.portfolio.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button 
                        type="button" 
                        class="text-red-600 hover:text-red-900 delete-button" 
                        data-id="{{ $item->id }}"
                        data-title="{{ $item->title }}"
                    >
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.portfolio.destroy', $item->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $portfolioItems->links() }}
    </div>
    @else
    <div class="text-center py-10">
        <div class="text-indigo-500 mb-4">
            <i class="fas fa-folder-open text-5xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No portfolio items found</h3>
        <p class="text-gray-500 mb-6">Get started by creating a new portfolio item.</p>
        <a href="{{ route('admin.portfolio.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
            <i class="fas fa-plus mr-2"></i> Add New Item
        </a>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all delete buttons
        const deleteButtons = document.querySelectorAll('.delete-button');
        
        // Add click event to each delete button
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const form = document.getElementById(`delete-form-${id}`);
                const row = document.getElementById(`portfolio-row-${id}`);
                
                // Show confirmation with animation
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete "${title}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Add deleting class for animation
                        row.classList.add('deleting');
                        
                        // Show deleting state
                        Swal.fire({
                            title: 'Deleting...',
                            text: `Removing "${title}" from your portfolio`,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            },
                        });
                        
                        // Submit the form after a small delay for animation
                        setTimeout(() => {
                            form.submit();
                        }, 800);
                    }
                });
            });
        });
    });
</script>
@endsection
