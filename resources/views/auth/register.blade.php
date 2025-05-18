<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        /* Background Animation Styles */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-shape {
            position: absolute;
            background: linear-gradient(45deg, rgba(99, 102, 241, 0.15) 0%, rgba(168, 85, 247, 0.15) 100%);
            border-radius: 50%;
            animation-timing-function: ease-in-out;
            animation-iteration-count: infinite;
            animation-direction: alternate;
        }
        
        .shape-1 {
            top: 15%;
            left: -10%;
            width: 600px;
            height: 600px;
            animation-name: float-1;
            animation-duration: 20s;
        }
        
        .shape-2 {
            bottom: -10%;
            right: -5%;
            width: 500px;
            height: 500px;
            animation-name: float-2;
            animation-duration: 17s;
        }
        
        .shape-3 {
            top: 40%;
            right: 25%;
            width: 300px;
            height: 300px;
            animation-name: float-3;
            animation-duration: 13s;
        }
        
        .shape-4 {
            bottom: 30%;
            left: 15%;
            width: 200px;
            height: 200px;
            animation-name: float-4;
            animation-duration: 15s;
        }
        
        @keyframes float-1 {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(100px, 50px) rotate(10deg); }
        }
        
        @keyframes float-2 {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-80px, -40px) rotate(-8deg); }
        }
        
        @keyframes float-3 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-40px, 60px) scale(1.1); }
        }
        
        @keyframes float-4 {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            100% { transform: translate(60px, -30px) scale(1.15) rotate(15deg); }
        }
        
        /* Glass morphism effect for form */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="bg-shape shape-1"></div>
        <div class="bg-shape shape-2"></div>
        <div class="bg-shape shape-3"></div>
        <div class="bg-shape shape-4"></div>
    </div>
    
    <div class="w-full max-w-md relative z-10">
        <div class="glass-card rounded-xl p-8">
            <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Create Admin Account</h1>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition @error('name') border-red-300 @enderror" 
                        id="name" name="name" placeholder="John Doe" 
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition @error('email') border-red-300 @enderror" 
                        id="email" name="email" placeholder="name@example.com" 
                        value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition @error('password') border-red-300 @enderror" 
                        id="password" name="password" placeholder="••••••••" 
                        required autocomplete="new-password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition" 
                        id="password_confirmation" name="password_confirmation" placeholder="••••••••" 
                        required autocomplete="new-password">
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Admin Role</label>
                    <select name="role" id="role" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition @error('role') border-red-300 @enderror">
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-200 transform hover:-translate-y-0.5 shadow-sm">
                    Register
                </button>
                
                <div class="text-center pt-3">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'Portofolio Martin') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
