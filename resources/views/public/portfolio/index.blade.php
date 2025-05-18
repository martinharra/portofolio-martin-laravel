@extends('public.layouts.app')

@section('title', 'Portfolio - ' . config('app.name'))

@section('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Instrument+Serif:wght@400;500;600;700&display=swap">
<style>
    body {
        font-family: 'Outfit', sans-serif;
        background-color: #0f172a;
        color: #e2e8f0;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Instrument Serif', serif;
    }
    
    .neon-text {
        text-shadow: 0 0 10px rgba(111, 76, 255, 0.5), 0 0 20px rgba(111, 76, 255, 0.3);
    }
    
    .header-section {
        background: linear-gradient(to right, #1e1b4b, #4c1d95);
        position: relative;
        overflow: hidden;
    }
    
    .header-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%232d3748' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
        z-index: 0;
    }
    
    .card-glow {
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .card-glow::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(139, 92, 246, 0.15) 0%, transparent 50%);
        opacity: 0;
        z-index: -1;
        transform: scale(0.8);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .card-glow:hover::before {
        opacity: 1;
        transform: scale(1);
    }
    
    .card-glow:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
    }
    
    .image-hover-zoom {
        transition: transform 0.8s ease;
    }
    
    .image-hover-zoom:hover {
        transform: scale(1.05);
    }
    
    .filter-btn {
        transition: all 0.3s ease;
    }
    
    .filter-btn.active {
        background: linear-gradient(to right, #8b5cf6, #6366f1);
        border-color: #8b5cf6;
        box-shadow: 0 0 10px rgba(139, 92, 246, 0.4);
    }
    
    .filter-btn:not(.active):hover {
        background-color: #1e293b;
        color: #c4b5fd;
        border-color: #6366f1;
    }
    
    .category-tag {
        background: rgba(139, 92, 246, 0.15);
        color: #c4b5fd;
        border: 1px solid rgba(139, 92, 246, 0.3);
        box-shadow: 0 0 5px rgba(139, 92, 246, 0.2);
    }
    
    .pagination-link {
        transition: all 0.3s ease;
    }
    
    .pagination-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 92, 246, 0.3);
    }
</style>
@endsection

@section('content')
<div class="header-section relative z-0">
    <div class="container mx-auto px-4 py-16 md:py-20 relative z-10">
        <h1 class="text-3xl md:text-5xl font-bold mb-4 neon-text animate-tracking-in-expand">My Portfolio</h1>
        <p class="text-lg opacity-90 text-violet-200 max-w-2xl animate-fade-in-up" style="animation-delay: 0.2s">
            A collection of projects, designs and development work that showcase my skills and creativity
        </p>
    </div>
</div>

<div class="py-16 bg-slate-900">
    <div class="container mx-auto px-4">
        <!-- Category Filter -->
        <div class="mb-12 flex flex-wrap items-center justify-between">
            <div class="flex flex-wrap items-center gap-2 mb-4 md:mb-0">
                <span class="text-slate-300 font-medium mr-3">Filter by:</span>
                <a href="{{ route('portfolio') }}" class="px-4 py-2 rounded-lg text-sm filter-btn border {{ !request('category') ? 'active' : 'text-slate-300 border-slate-700' }}">
                    All Projects
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('portfolio', ['category' => $category]) }}" class="px-4 py-2 rounded-lg text-sm filter-btn border {{ request('category') == $category ? 'active' : 'text-slate-300 border-slate-700' }}">
                        {{ ucfirst($category) }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- Portfolio Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($portfolioItems as $key => $item)
                <div class="bg-slate-800 rounded-xl overflow-hidden shadow-lg card-glow opacity-0 translate-y-10 transition-all duration-700" style="animation-delay: {{ ($key % 6) * 0.1 }}s">
                    <div class="h-56 overflow-hidden">
                        <img 
                            src="{{ $item->thumbnail_url }}" 
                            alt="{{ $item->title }}" 
                            class="w-full h-full object-cover image-hover-zoom"
                        >
                    </div>
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-2 category-tag">
                            {{ $item->category }}
                        </span>
                        <h3 class="text-xl font-bold text-white mb-3">{{ $item->title }}</h3>
                        <p class="text-slate-300 mb-4">{{ Str::limit($item->description, 100) }}</p>
                        <a href="{{ route('portfolio.detail', $item->id) }}" class="text-violet-300 hover:text-violet-200 font-medium inline-flex items-center group">
                            <span>View Details</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 text-slate-400">
                    <div class="text-violet-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-white mb-2">No portfolio items found</h3>
                    <p>Check back soon for upcoming projects!</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-16">
            <div class="flex justify-center">
                {{ $portfolioItems->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation classes to elements as they scroll into view
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.card-glow');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('opacity-100');
                    element.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        };
        
        // Run once on load
        setTimeout(animateOnScroll, 300);
        
        // Run on scroll
        window.addEventListener('scroll', animateOnScroll);
    });
</script>
@endsection
