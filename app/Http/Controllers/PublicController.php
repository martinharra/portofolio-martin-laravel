<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get featured portfolio items (latest 3)
        $featuredPortfolio = Portfolio::where('status', 'published')
            ->latest()
            ->take(3)
            ->get();
            
        return view('public.home', compact('featuredPortfolio'));
    }
    
    /**
     * Display all published portfolio items
     */
    public function portfolio(Request $request)
    {
        $query = Portfolio::where('status', 'published');
        
        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        $portfolioItems = $query->latest()->paginate(9);
        
        // Get all unique categories for the filter
        $categories = Portfolio::where('status', 'published')
            ->select('category')
            ->distinct()
            ->pluck('category');
            
        return view('public.portfolio.index', compact('portfolioItems', 'categories'));
    }
    
    /**
     * Display a single portfolio item
     */
    public function portfolioDetail($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        // Get related items (same category, excluding current)
        $relatedItems = Portfolio::where('status', 'published')
            ->where('category', $portfolio->category)
            ->where('id', '!=', $portfolio->id)
            ->take(3)
            ->get();
            
        return view('public.portfolio.detail', compact('portfolio', 'relatedItems'));
    }
}
