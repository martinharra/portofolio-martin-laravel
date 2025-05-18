<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');
        
        // Attempt to find the admin by email
        $admin = Admin::where('email', $credentials['email'])->first();
        
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Store admin session data
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->name);
            $request->session()->put('admin_email', $admin->email);
            $request->session()->put('admin_role', $admin->role);
            
            // Set a flag to trigger the login success animation
            $request->session()->flash('login_success', true);
            
            return redirect()->route('admin.dashboard')->with('status', 'Welcome back, ' . $admin->name);
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }
    
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    /**
     * Handle admin registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|in:admin,editor',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }
        
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'admin', // Default to 'admin' if not provided
        ]);
        
        if ($admin) {
            // Store admin session data
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->name);
            $request->session()->put('admin_email', $admin->email);
            $request->session()->put('admin_role', $admin->role);
            
            return redirect()->route('admin.dashboard')->with('status', 'Registration successful! Welcome, ' . $admin->name);
        }
        
        return back()->with('error', 'Registration failed. Please try again.')->withInput($request->except('password', 'password_confirmation'));
    }
    
    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_name', 'admin_email', 'admin_role']);
        $request->session()->flush();
        
        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
    
    /**
     * Check if admin is logged in
     */
    public static function isLoggedIn()
    {
        return session()->has('admin_id');
    }
    
    /**
     * Custom middleware for admin authentication
     */
    public function adminAuth()
    {
        return function ($request, $next) {
            if (!self::isLoggedIn()) {
                return redirect()->route('login');
            }
            return $next($request);
        };
    }
}
