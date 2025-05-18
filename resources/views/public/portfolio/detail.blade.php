@extends('public.layouts.app')

@section('title', $portfolio->title . ' - Portfolio')

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
    
    .neon-border {
        position: relative;
    }
    
    .neon-border::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 1px solid #8b5cf6;
        border-radius: inherit;
        box-shadow: 0 0 10px rgba(139, 92, 246, 0.5), inset 0 0 10px rgba(139, 92, 246, 0.2);
        pointer-events: none;
    }
    
    .card-glow {
        position: relative;
        overflow: hidden;
        z-index: 1;
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
    
    .gradient-border {
        position: relative;
        border-radius: 0.75rem;
        background: #1e293b;
        padding: 1px;
        z-index: 1;
        overflow: hidden;
    }
    
    .gradient-border::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 0.75rem;
        padding: 2px;
        background: linear-gradient(45deg, #6366f1, #a855f7, #3b82f6);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        z-index: -1;
        opacity: 0.7;
    }
    
    .gradient-border:hover::before {
        opacity: 1;
    }
    
    .project-header {
        background: linear-gradient(to right, #0f172a, #1e293b);
        position: relative;
        overflow: hidden;
    }
    
    .project-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232d3748' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
        z-index: 0;
    }
    
    .gallery-image {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        perspective: 1000px;
    }
    
    .gallery-image:hover {
        transform: translateY(-5px) rotateX(3deg);
        box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
    }

    .back-button {
        position: relative;
        overflow: hidden;
    }
    
    .back-button span {
        position: relative;
        z-index: 1;
        transition: color 0.4s ease;
    }
    
    .back-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: #8b5cf6;
        transition: width 0.4s ease;
        z-index: 0;
    }
    
    .back-button:hover::before {
        width: 100%;
    }
    
    .back-button:hover span {
        color: #fff;
    }
    
    .related-card {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .related-card:hover {
        transform: translateY(-8px) scale(1.01);
    }
    
    .image-hover-zoom {
        transition: transform 0.8s ease;
    }
    
    .image-hover-zoom:hover {
        transform: scale(1.05);
    }
    
    .skills-tag {
        background: rgba(139, 92, 246, 0.15);
        color: #c4b5fd;
        border: 1px solid rgba(139, 92, 246, 0.3);
        box-shadow: 0 0 5px rgba(139, 92, 246, 0.2);
    }
</style>
@endsection

@section('content')
<div class="project-header relative z-0">
    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="animate-fade-in-up">
                <span class="inline-block px-4 py-1 text-xs font-semibold bg-violet-900 bg-opacity-40 text-violet-200 rounded-full mb-5 backdrop-blur-sm border border-violet-800">
                    {{ $portfolio->category }}
                </span>
                <h1 class="text-4xl md:text-5xl font-bold mb-8 leading-tight text-white neon-text animate-tracking-in-expand">{{ $portfolio->title }}</h1>
                <div class="flex flex-wrap items-center text-violet-200 text-sm font-medium">
                    @if($portfolio->client)
                    <div class="mr-8 mb-3 animate-fade-in-up" style="animation-delay: 0.1s">
                        <span class="opacity-75 mr-1">Client:</span> {{ $portfolio->client }}
                    </div>
                    @endif
                    @if($portfolio->project_date)
                    <div class="mr-8 mb-3 animate-fade-in-up" style="animation-delay: 0.2s">
                        <span class="opacity-75 mr-1">Date:</span> {{ $portfolio->project_date->format('M Y') }}
                    </div>
                    @endif
                    @if($portfolio->technologies)
                    <div class="mb-3 animate-fade-in-up" style="animation-delay: 0.3s">
                        <span class="opacity-75 mr-1">Technologies:</span>
                        <div class="inline-flex flex-wrap gap-2 mt-2">
                            @foreach(explode(',', $portfolio->technologies) as $tech)
                                <span class="inline-block px-2 py-1 text-xs rounded-md skills-tag">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-16 bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Main Image -->
            <div class="rounded-xl overflow-hidden shadow-2xl mb-16 gradient-border">
                <img 
                    src="{{ $portfolio->thumbnail_url }}" 
                    alt="{{ $portfolio->title }}" 
                    class="w-full h-auto image-hover-zoom"
                >
            </div>
            
            <!-- Project Description -->
            <div class="prose prose-lg max-w-none mb-16 text-slate-300 leading-relaxed prose-headings:text-white prose-strong:text-violet-200">
                {!! nl2br(e($portfolio->description)) !!}
            </div>
            
            <!-- Project URL if available -->
            @if($portfolio->project_url)
            <div class="mb-16">
                <a href="{{ $portfolio->project_url }}" target="_blank" class="inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium px-8 py-4 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-purple-500/25 transform hover:-translate-y-1">
                    <span class="flex items-center">
                        <span>View Live Project</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </a>
            </div>
            @endif
            
            <!-- Gallery -->
            @if(count($portfolio->gallery_images) > 0)
            <h3 class="text-2xl font-bold text-white mb-8 neon-text">Project Gallery</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                @foreach($portfolio->gallery_images as $key => $image)
                <div class="rounded-xl overflow-hidden shadow-md gallery-image card-glow" style="animation-delay: {{ $key * 0.1 }}s">
                    <img 
                        src="{{ $portfolio->getGalleryImageUrl($image) }}" 
                        alt="{{ $portfolio->title }} gallery image" 
                        class="w-full h-auto"
                    >
                </div>
                @endforeach
            </div>
            @endif
            
            <!-- Back button -->
            <div class="mb-20">
                <a href="{{ route('portfolio') }}" class="inline-flex items-center px-5 py-2 rounded-lg text-violet-300 back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back to Portfolio</span>
                </a>
            </div>
            
            <!-- Related Projects -->
            @if(count($relatedItems) > 0)
            <div class="border-t border-slate-800 pt-16">
                <h3 class="text-2xl font-bold text-white mb-8 neon-text">Related Projects</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedItems as $item)
                    <div class="bg-slate-800 rounded-xl overflow-hidden shadow-lg hover:shadow-purple-900/20 transition-all duration-300 related-card">
                        <div class="h-48 overflow-hidden">
                            <img 
                                src="{{ $item->thumbnail_url }}" 
                                alt="{{ $item->title }}" 
                                class="w-full h-full object-cover image-hover-zoom"
                            >
                        </div>
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-white mb-3">{{ $item->title }}</h4>
                            <a href="{{ route('portfolio.detail', $item->id) }}" class="text-violet-300 hover:text-violet-200 font-medium text-sm inline-flex items-center group">
                                <span>View Details</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation classes to elements as they scroll into view
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.gallery-image, .related-card');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('opacity-100');
                    element.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        };
        
        // Initialize elements
        document.querySelectorAll('.gallery-image, .related-card').forEach(el => {
            el.classList.add('opacity-0', 'translate-y-10', 'transition-all', 'duration-700');
        });
        
        // Run once on load
        setTimeout(animateOnScroll, 300);
        
        // Run on scroll
        window.addEventListener('scroll', animateOnScroll);
    });
</script>
@endsection
