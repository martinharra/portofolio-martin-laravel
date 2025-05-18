<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Portfolio::query();
        
        // Handle search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('client', 'LIKE', "%{$searchTerm}%");
        }
        
        // Handle category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        // Handle status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $portfolioItems = $query->latest()->paginate(10);
        
        return view('admin.portfolio.index', compact('portfolioItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'client' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'project_url' => 'nullable|url|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'technologies' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,published',
        ]);
        
        $data = $request->except(['thumbnail', 'gallery']);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('portfolio/thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }
        
        // Handle gallery uploads
        $galleryImages = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('portfolio/gallery', 'public');
                $galleryImages[] = $path;
            }
            $data['gallery'] = json_encode($galleryImages);
        }
        
        // Set status
        $data['status'] = $request->input('status', 'draft');
        
        Portfolio::create($data);
        
        // Set success flag for animation
        session()->flash('crud_success', [
            'action' => 'created',
            'title' => $request->title
        ]);
        
        return redirect()->route('admin.portfolio.index')
            ->with('status', 'Portfolio item created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        // Log gallery info for debugging
        Log::info('Portfolio ID: ' . $id);
        Log::info('Gallery (raw): ' . $portfolio->gallery);
        Log::info('Gallery images count: ' . count($portfolio->gallery_images));
        Log::info('Gallery images: ' . json_encode($portfolio->gallery_images));
        
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:100',
                'description' => 'required|string',
                'client' => 'nullable|string|max:255',
                'project_date' => 'nullable|date',
                'project_url' => 'nullable|url|max:255',
                'thumbnail' => 'nullable|image|max:2048',
                'gallery.*' => 'nullable|image|max:2048',
                'technologies' => 'nullable|string|max:255',
                'status' => 'nullable|in:draft,published',
            ]);
            
            $portfolio = Portfolio::findOrFail($id);
            $data = $request->except(['thumbnail', 'gallery', '_token', '_method']);
            
            // Handle thumbnail upload
            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                // Delete previous thumbnail if exists
                if ($portfolio->thumbnail && Storage::disk('public')->exists($portfolio->thumbnail)) {
                    Storage::disk('public')->delete($portfolio->thumbnail);
                }
                
                $thumbnailPath = $request->file('thumbnail')->store('portfolio/thumbnails', 'public');
                $data['thumbnail'] = $thumbnailPath;
            }
            
            // Handle gallery uploads - using the accessor to ensure we have an array
            if ($request->hasFile('gallery')) {
                $galleryImages = $portfolio->gallery_images; // Now guaranteed to be an array
                Log::info('Original gallery images: ' . json_encode($galleryImages));
                
                foreach ($request->file('gallery') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('portfolio/gallery', 'public');
                        $galleryImages[] = $path;
                        Log::info('Added new gallery image: ' . $path);
                    }
                }
                
                // Log the gallery images before saving
                Log::info('Updated gallery images: ' . json_encode($galleryImages));
                
                // Store gallery directly as a JSON string
                $data['gallery'] = json_encode($galleryImages);
            }
            
            $portfolio->update($data);
            
            // Log the updated gallery for debugging
            Log::info('After update - Gallery: ' . $portfolio->fresh()->gallery);
            
            // Set success flag for animation
            session()->flash('crud_success', [
                'action' => 'updated',
                'title' => $portfolio->title
            ]);
            
            return redirect()->route('admin.portfolio.index')
                ->with('status', 'Portfolio item updated successfully!');
                
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Portfolio update error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Failed to update portfolio: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $title = $portfolio->title;
        
        // Soft delete the portfolio item
        $portfolio->delete();
        
        // Set success flag for animation
        session()->flash('crud_success', [
            'action' => 'deleted',
            'title' => $title
        ]);
        
        return redirect()->route('admin.portfolio.index')
            ->with('status', 'Portfolio item deleted successfully!');
    }

    /**
     * Remove a gallery image from a portfolio item.
     *
     * @param  int  $id
     * @param  string  $imagePath
     * @return \Illuminate\Http\Response
     */
    public function removeGalleryImage($id, $imagePath)
    {
        $portfolio = Portfolio::findOrFail($id);
        $galleryImages = $portfolio->gallery_images;
        
        $decodedPath = urldecode($imagePath);
        Log::info('Removing gallery image: ' . $decodedPath);
        Log::info('Current gallery images: ' . print_r($galleryImages, true));
        
        if (is_array($galleryImages) && ($key = array_search($decodedPath, $galleryImages)) !== false) {
            // Try to delete the file
            try {
                Storage::disk('public')->delete($decodedPath);
            } catch (\Exception $e) {
                Log::error('Failed to delete gallery image: ' . $e->getMessage());
            }
            
            // Remove from the array
            unset($galleryImages[$key]);
            $portfolio->gallery = json_encode(array_values($galleryImages));
            $portfolio->save();
            
            Log::info('Gallery after removal: ' . $portfolio->gallery);
        } else {
            Log::warning('Gallery image not found in array: ' . $decodedPath);
        }
        
        // Set success flag for animation
        session()->flash('crud_success', [
            'action' => 'updated',
            'message' => 'Gallery image removed'
        ]);
        
        return redirect()->route('admin.portfolio.edit', $id)
            ->with('status', 'Gallery image removed successfully!');
    }
}
