<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'user_id', 'storage', 'price', 'min_pieces', 'product_images', 'description', 'category', 'sub_category', 'rating'
    ];
    protected $casts = [
        'product_images' => 'json',
    ];

    // Define relationships if needed (e.g., user relationship)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        // Assuming you have a 'ratings' relationship on your Product model
        return $this->ratings()->average('rating');
    }

    /**
     * Get the total number of ratings for the product.
     *
     * @return int
     */
    public function totalRatings()
    {
        return $this->ratings()->count();
    }
    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }

}