@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('styles')
<style>
    /* Login success animation styles */
    .login-success-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
    }
    
    .login-success-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .login-success-content {
        background: white;
        border-radius: 1rem;
        padding: 3rem;
        text-align: center;
        max-width: 500px;
        width: 90%;
        transform: translateY(20px);
        opacity: 0;
        transition: transform 0.5s, opacity 0.5s;
    }
    
    .login-success-overlay.active .login-success-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .checkmark-circle {
        width: 80px;
        height: 80px;
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin-bottom: 1.5rem;
    }
    
    .checkmark-circle .background {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #4ade80;
        position: absolute;
    }
    
    .checkmark-circle .checkmark {
        border-radius: 5px;
    }
    
    .checkmark-circle .checkmark.draw:after {
        animation-delay: 100ms;
        animation-duration: 1s;
        animation-timing-function: ease;
        animation-name: checkmark;
        transform: scaleX(-1) rotate(135deg);
        animation-fill-mode: forwards;
    }
    
    .checkmark-circle .checkmark:after {
        opacity: 0;
        height: 40px;
        width: 20px;
        transform-origin: left top;
        border-right: 8px solid white;
        border-top: 8px solid white;
        content: '';
        left: 25px;
        top: 45px;
        position: absolute;
    }
    
    @keyframes checkmark {
        0% {
            height: 0;
            width: 0;
            opacity: 1;
        }
        20% {
            height: 0;
            width: 20px;
            opacity: 1;
        }
        40% {
            height: 40px;
            width: 20px;
            opacity: 1;
        }
        100% {
            height: 40px;
            width: 20px;
            opacity: 1;
        }
    }
    
    @keyframes fadeInSuccess {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .welcome-text {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        opacity: 0;
        animation: fadeInSuccess 0.5s ease forwards;
        animation-delay: 0.7s;
    }
    
    .success-message {
        color: #6b7280;
        margin-bottom: 1.5rem;
        opacity: 0;
        animation: fadeInSuccess 0.5s ease forwards;
        animation-delay: 0.9s;
    }
    
    .continue-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background-color: #4f46e5;
        color: white;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        opacity: 0;
        animation: fadeInSuccess 0.5s ease forwards;
        animation-delay: 1.1s;
    }
    
    .continue-button:hover {
        background-color: #4338ca;
    }
</style>
@endsection

@section('content')
<!-- Login Success Animation (shows only when session has login_success) -->
@if(session('login_success'))
<div class="login-success-overlay" id="loginSuccessOverlay">
    <div class="login-success-content">
        <div class="checkmark-circle">
            <div class="background"></div>
            <div class="checkmark draw"></div>
        </div>
        <h2 class="welcome-text">Welcome, {{ session('admin_name') ?? 'Admin' }}!</h2>
        <p class="success-message">You have successfully logged in to the admin dashboard.</p>
        <button class="continue-button" id="continueButton">Continue to Dashboard</button>
    </div>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                <i class="fas fa-briefcase text-xl"></i>
            </div>
            <div class="ml-4">
                <h2 class="font-semibold text-gray-800">Portfolio Items</h2>
                <p class="text-2xl font-bold text-gray-700">{{ $portfolioCount ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-tools text-xl"></i>
            </div>
            <div class="ml-4">
                <h2 class="font-semibold text-gray-800">Skills</h2>
                <p class="text-2xl font-bold text-gray-700">{{ $skillsCount ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-eye text-xl"></i>
            </div>
            <div class="ml-4">
                <h2 class="font-semibold text-gray-800">Page Views</h2>
                <p class="text-2xl font-bold text-gray-700">{{ $pageViews ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h2>
        <div class="space-y-4">
            @forelse($recentActivities ?? [] as $activity)
            <div class="flex items-start pb-4 border-b border-gray-100">
                <div class="p-2 rounded-full bg-indigo-50 text-indigo-600">
                    <i class="fas fa-history"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">{{ $activity->description }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-sm">No recent activities found.</p>
            @endforelse
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.portfolio.create') }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 p-4 rounded-lg flex flex-col items-center justify-center transition">
                <i class="fas fa-plus-circle text-2xl mb-2"></i>
                <span class="text-sm font-medium">Add Portfolio Item</span>
            </a>
            
            <a href="{{ route('admin.profile.edit') }}" class="bg-green-50 hover:bg-green-100 text-green-700 p-4 rounded-lg flex flex-col items-center justify-center transition">
                <i class="fas fa-user-edit text-2xl mb-2"></i>
                <span class="text-sm font-medium">Edit Profile</span>
            </a>
            
            <a href="{{ route('admin.skills.create') }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 p-4 rounded-lg flex flex-col items-center justify-center transition">
                <i class="fas fa-tools text-2xl mb-2"></i>
                <span class="text-sm font-medium">Add Skill</span>
            </a>
            
            <a href="{{ route('admin.settings') }}" class="bg-purple-50 hover:bg-purple-100 text-purple-700 p-4 rounded-lg flex flex-col items-center justify-center transition">
                <i class="fas fa-cog text-2xl mb-2"></i>
                <span class="text-sm font-medium">Settings</span>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Login success animation logic
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('loginSuccessOverlay');
        if (overlay) {
            // Show the overlay with a slight delay for better effect
            setTimeout(() => {
                overlay.classList.add('active');
            }, 300);
            
            // Handle the continue button click
            document.getElementById('continueButton').addEventListener('click', function() {
                overlay.classList.remove('active');
                
                // Hide completely after transition
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 300);
            });
        }
    });
</script>
@endsection
