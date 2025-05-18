<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PublicController;

Route::get('/', function () {
    return view('welcome');
});

// Public routes for portfolio
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/portfolio', [PublicController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{id}', [PublicController::class, 'portfolioDetail'])->name('portfolio.detail');

// Auth routes
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AdminController::class, 'register'])->name('register.submit');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// For testing without login requirement
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        // Mock data for testing
        $data = [
            'portfolioCount' => 6,
            'skillsCount' => 12,
            'pageViews' => 1254,
            'recentActivities' => collect([
                (object)['description' => 'Updated profile information', 'created_at' => now()->subHours(2)],
                (object)['description' => 'Added new portfolio item', 'created_at' => now()->subHours(5)],
                (object)['description' => 'Updated skills section', 'created_at' => now()->subDays(1)],
            ])
        ];
        return view('admin.dashboard', $data);
    })->name('dashboard');
    
    // Portfolio management with controller
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolio/{id}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/{id}', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
    Route::get('/portfolio/{id}/remove-gallery-image/{imagePath}', [PortfolioController::class, 'removeGalleryImage'])->name('portfolio.removeGalleryImage');
    
    // Profile management
    Route::get('/profile/edit', function () {
        // Mock data for testing
        $profile = (object)[
            'name' => 'Martin Johnson',
            'job_title' => 'Full Stack Developer',
            'bio' => 'Experienced web developer with a passion for creating beautiful and functional websites.',
            'avatar' => null,
            'email' => 'martin@example.com',
            'phone' => '+1234567890',
            'location' => 'New York, USA',
            'linkedin' => 'https://linkedin.com/in/martin',
            'github' => 'https://github.com/martin',
            'twitter' => 'https://twitter.com/martin',
            'instagram' => 'https://instagram.com/martin',
            'website' => 'https://martin-portfolio.com'
        ];
        
        return view('admin.profile.edit', ['profile' => $profile]);
    })->name('profile.edit');
    
    // Also keep the original profile route as a redirect to edit
    Route::get('/profile', function () {
        return redirect()->route('admin.profile.edit');
    })->name('profile');
    
    Route::put('/profile', function () {
        return redirect()->route('admin.profile.edit')->with('status', 'Profile updated successfully!');
    })->name('profile.update');
    
    // Skills management
    Route::get('/skills', function () {
        return view('admin.skills');
    })->name('skills');
    
    Route::get('/skills/create', function () {
        return view('admin.skills.create');
    })->name('skills.create');
    
    // Experience management
    Route::get('/experience', function () {
        return view('admin.experience');
    })->name('experience');
    
    // Education management
    Route::get('/education', function () {
        return view('admin.education');
    })->name('education');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

// For production with login requirement (commented out for now)
/*
Route::prefix('admin')->name('admin.')->middleware(['web', function ($request, $next) {
    if (!AdminController::isLoggedIn()) {
        return redirect()->route('login');
    }
    return $next($request);
}])->group(function () {
    // Add your admin routes here
});
*/
