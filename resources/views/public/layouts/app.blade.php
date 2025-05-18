<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease forwards',
                        'tracking-in-expand': 'trackingInExpand 0.7s cubic-bezier(0.215, 0.610, 0.355, 1.000) both',
                        'float': 'float 3s ease-in-out infinite'
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: 0, transform: 'translateY(20px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' }
                        },
                        trackingInExpand: {
                            '0%': { letterSpacing: '-.5em', opacity: 0 },
                            '40%': { opacity: .6 },
                            '100%': { opacity: 1, letterSpacing: 'normal' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Base styles -->
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --secondary: #3b82f6;
            --dark-bg: #0f172a;
            --dark-surface: #1e293b;
            --light-text: #e2e8f0;
            --muted-text: #94a3b8;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            color: var(--light-text);
            background-color: var(--dark-bg);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
        
        /* Navigation menu with glow effect */
        .nav-item {
            position: relative;
            padding: 0.5rem 0;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-image: linear-gradient(to right, #8b5cf6, #3b82f6);
            transition: width 0.3s ease;
            box-shadow: 0 0 8px rgba(139, 92, 246, 0.5);
        }
        
        .nav-item:hover::before,
        .nav-item.active::before {
            width: 100%;
        }
        
        /* Glow effect on hover */
        .glow-on-hover {
            position: relative;
            overflow: hidden;
        }
        
        .glow-on-hover::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.4) 0%, rgba(59, 130, 246, 0) 70%);
            opacity: 0;
            transition: opacity 0.6s;
            z-index: -1;
        }
        
        .glow-on-hover:hover::after {
            opacity: 1;
        }
        
        /* Logo animation */
        .logo-text {
            background: linear-gradient(to right, #8b5cf6, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }
        
        .logo-text::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -2px;
            height: 2px;
            background: linear-gradient(to right, #8b5cf6, #3b82f6);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.6);
        }
        
        .logo-text:hover::after {
            transform: scaleX(1);
        }
        
        /* Development Banner Styles */
        .dev-banner {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            background-size: 200% 200%;
            animation: gradient-shift 15s ease infinite;
            position: relative;
            overflow: hidden;
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .dev-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: repeating-linear-gradient(
                45deg,
                rgba(0, 0, 0, 0.1),
                rgba(0, 0, 0, 0.1) 10px,
                rgba(0, 0, 0, 0.2) 10px,
                rgba(0, 0, 0, 0.2) 20px
            );
            opacity: 0.1;
        }
        
        .dev-banner-icon {
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Development Status Banner -->
    <div class="dev-banner text-white">
        <div class="container mx-auto px-4">
            <div class="py-3 text-center flex flex-wrap items-center justify-center gap-2">
                <span class="dev-banner-icon inline-block">🚧</span>
                <span class="text-sm md:text-base font-medium">
                    This website is under active development and will be completed in the next 1-2 months.
                    <span class="hidden md:inline">More features and content coming soon!</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Header/Navbar with glass effect -->
    <header class="bg-slate-900 bg-opacity-80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div>
                    <a href="{{ route('home') }}" class="text-xl font-bold logo-text">Martin's Portfolio</a>
                </div>
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-slate-300 hover:text-white font-medium transition-colors nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('portfolio') }}" class="text-slate-300 hover:text-white font-medium transition-colors nav-item {{ request()->routeIs('portfolio') || request()->routeIs('portfolio.detail') ? 'active' : '' }}">Portfolio</a>
                    <!-- Add more navigation links as needed -->
                    <a href="{{ route('admin.dashboard') }}" class="ml-4 px-5 py-2 rounded-lg text-white font-medium bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-violet-500/25">
                        Admin
                    </a>
                </nav>
                <div class="md:hidden">
                    <button type="button" class="text-white hover:text-violet-300" id="mobileMenuButton">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="md:hidden hidden py-4" id="mobileMenu">
                <nav class="flex flex-col space-y-4">
                    <a href="{{ route('home') }}" class="text-slate-300 hover:text-white font-medium transition-colors">Home</a>
                    <a href="{{ route('portfolio') }}" class="text-slate-300 hover:text-white font-medium transition-colors">Portfolio</a>
                    <!-- Add more navigation links as needed -->
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 rounded-lg text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 transition-all duration-300 inline-block text-center mt-2">Admin</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-2xl font-bold mb-3 logo-text">Martin's Portfolio</h3>
                    <p class="text-slate-400">Showcasing creative works and projects</p>
                </div>
                <div class="flex space-x-5">
                    <a href="#" class="text-slate-400 hover:text-white transition transform hover:-translate-y-1 glow-on-hover p-2">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-white transition transform hover:-translate-y-1 glow-on-hover p-2">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-white transition transform hover:-translate-y-1 glow-on-hover p-2">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-white transition transform hover:-translate-y-1 glow-on-hover p-2">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-8 text-center text-slate-400 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Martin\'s Portfolio') }}. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- JavaScript for mobile menu toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
