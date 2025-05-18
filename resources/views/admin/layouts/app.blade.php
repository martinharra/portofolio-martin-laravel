<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* CRUD Success Animation */
        .crud-success-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .crud-success-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .crud-success-content {
            background: white;
            border-radius: 1rem;
            padding: 2.5rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.5s, opacity 0.5s;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .crud-success-overlay.active .crud-success-content {
            transform: translateY(0);
            opacity: 1;
        }
        
        .crud-icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .crud-icon-container.create {
            background-color: #10B981;
        }
        
        .crud-icon-container.update {
            background-color: #3B82F6;
        }
        
        .crud-icon-container.delete {
            background-color: #EF4444;
        }
        
        .crud-icon {
            color: white;
            font-size: 2rem;
        }
        
        .crud-success-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1F2937;
            margin-bottom: 0.5rem;
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
            animation-delay: 0.3s;
        }
        
        .crud-success-message {
            color: #6B7280;
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
            animation-delay: 0.5s;
        }
        
        .crud-continue-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #4F46E5;
            color: white;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
            animation-delay: 0.7s;
        }
        
        .crud-continue-button:hover {
            background-color: #4338CA;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes scaleIn {
            0% { transform: scale(0); }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .scale-animation {
            animation: scaleIn 0.5s ease forwards;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- CRUD Success Animation Overlay -->
    @if(session('crud_success'))
    <div class="crud-success-overlay" id="crudSuccessOverlay">
        <div class="crud-success-content">
            <div class="crud-icon-container {{ session('crud_success')['action'] }} scale-animation">
                @if(session('crud_success')['action'] == 'created')
                    <i class="fas fa-plus crud-icon"></i>
                @elseif(session('crud_success')['action'] == 'updated')
                    <i class="fas fa-edit crud-icon"></i>
                @elseif(session('crud_success')['action'] == 'deleted')
                    <i class="fas fa-trash crud-icon"></i>
                @endif
            </div>
            <h2 class="crud-success-title">Success!</h2>
            <p class="crud-success-message">
                @if(session('crud_success')['action'] == 'created')
                    The item "{{ session('crud_success')['title'] }}" has been created successfully.
                @elseif(session('crud_success')['action'] == 'updated')
                    @if(isset(session('crud_success')['message']))
                        {{ session('crud_success')['message'] }} successfully.
                    @else
                        The item "{{ session('crud_success')['title'] }}" has been updated successfully.
                    @endif
                @elseif(session('crud_success')['action'] == 'deleted')
                    The item "{{ session('crud_success')['title'] }}" has been deleted successfully.
                @endif
            </p>
            <button class="crud-continue-button" id="crudContinueButton">Continue</button>
        </div>
    </div>
    @endif
    
    <div class="min-h-screen flex flex-col">
        <!-- Sidebar -->
        <div class="flex flex-col md:flex-row flex-1">
            <aside class="bg-indigo-700 w-full md:w-64 md:min-h-screen">
                <div class="flex flex-col h-full">
                    <div class="px-4 py-6 text-center border-b border-indigo-800">
                        <h2 class="text-xl font-bold text-white">Portfolio Admin</h2>
                    </div>
                    <div class="py-4 flex-1 overflow-y-auto">
                        <nav class="mt-5 px-2">
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-indigo-100 hover:bg-indigo-600 rounded-md transition">
                                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.portfolio.index') }}" class="group flex items-center px-4 py-3 mt-1 text-indigo-100 hover:bg-indigo-600 rounded-md transition">
                                <i class="fas fa-briefcase mr-3"></i> Portfolio Items
                            </a>
                            <a href="{{ route('admin.profile.edit') }}" class="group flex items-center px-4 py-3 mt-1 text-indigo-100 hover:bg-indigo-600 rounded-md transition">
                                <i class="fas fa-user mr-3"></i> Profile
                            </a>
                            <a href="{{ route('admin.skills') }}" class="group flex items-center px-4 py-3 mt-1 text-indigo-100 hover:bg-indigo-600 rounded-md transition">
                                <i class="fas fa-tools mr-3"></i> Skills
                            </a>
                            <a href="{{ route('admin.experience') }}" class="group flex items-center px-4 py-3 mt-1 text-indigo-100 hover:bg-indigo-600 rounded-md transition">
                                <i class="fas fa-briefcase mr-3"></i> Experience
                            </a>
                            <a href="{{ route('admin.education') }}" class="group flex items-center px-4 py-3 mt-1 text-indigo-100 hover:bg-indigo-600 rounded-md transition">
                                <i class="fas fa-graduation-cap mr-3"></i> Education
                            </a>
                            <a href="{{ route('admin.settings') }}" class="group flex items-center px-4 py-3 mt-1 text-indigo-100 hover:bg-indigo-600 rounded-md transition">
                                <i class="fas fa-cog mr-3"></i> Settings
                            </a>
                        </nav>
                    </div>
                    <div class="p-4 border-t border-indigo-800">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 text-indigo-100 bg-indigo-800 hover:bg-indigo-900 rounded-md transition">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
            
            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <!-- Top Header -->
                <header class="bg-white shadow-sm py-4 px-4 md:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="text-xl font-semibold text-gray-800">@yield('header')</h1>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 mr-2">Admin User</span>
                            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Admin" alt="Profile">
                        </div>
                    </div>
                </header>
                
                <!-- Page Content -->
                <div class="p-4 md:p-8">
                    @if (session('status'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @yield('scripts')
    <script>
        // CRUD Success Animation
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('crudSuccessOverlay');
            if (overlay) {
                // Show the overlay with a slight delay for better effect
                setTimeout(() => {
                    overlay.classList.add('active');
                }, 300);
                
                // Handle the continue button click
                document.getElementById('crudContinueButton').addEventListener('click', function() {
                    overlay.classList.remove('active');
                    
                    // Hide completely after transition
                    setTimeout(() => {
                        overlay.style.display = 'none';
                    }, 300);
                });
            }
        });
    </script>
</body>
</html>
