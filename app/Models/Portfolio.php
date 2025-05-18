<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'description',
        'client',
        'project_date',
        'project_url',
        'thumbnail',
        'gallery',
        'technologies',
        'status',
    ];

    protected $casts = [
        'project_date' => 'date',
        // Remove gallery from casts to handle it manually
    ];

    /**
     * Get the gallery images as an array
     * 
     * @return array
     */
    public function getGalleryImagesAttribute()
    {
        // Handle null/empty case
        if (empty($this->gallery)) {
            return [];
        }
        
        // If it's already an array, return it
        if (is_array($this->gallery)) {
            return $this->gallery;
        }
        
        // If it's a JSON string, decode it
        if (is_string($this->gallery)) {
            $decoded = json_decode($this->gallery, true);
            // Check if decoding worked
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }
        
        // Fallback to empty array
        return [];
    }
    
    /**
     * Set the gallery attribute with proper handling of arrays and strings
     *
     * @param mixed $value
     * @return void
     */
    public function setGalleryAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['gallery'] = json_encode($value);
        } else {
            $this->attributes['gallery'] = $value;
        }
    }
    
    /**
     * Get thumbnail URL
     * 
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        if (empty($this->thumbnail)) {
            return asset('images/placeholder.jpg');
        }
        
        // Check if thumbnail starts with http(s):// - external URL
        if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
            return $this->thumbnail;
        }
        
        // Extra debug info - remove this after fixing
        Log::info('Thumbnail path: ' . $this->thumbnail);
        
        // Return proper storage URL with cleaner path handling
        $cleanPath = ltrim($this->thumbnail, '/');
        return asset('storage/' . $cleanPath);
    }
    
    /**
     * Get gallery URL for a specific image
     *
     * @param string $imagePath
     * @return string
     */
    public function getGalleryImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return asset('images/placeholder.jpg');
        }
        
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }
        
        $cleanPath = ltrim($imagePath, '/');
        return asset('storage/' . $cleanPath);
    }
    
    /**
     * Get formatted project date
     */
    public function getFormattedDateAttribute()
    {
        return $this->project_date ? $this->project_date->format('Y-m-d') : null;
    }
}
