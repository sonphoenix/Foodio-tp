<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'phone_number',
        'location',
        'business_logo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'user_id');
    }
public function ratings()
{
    return $this->hasManyThrough(Rating::class, Product::class);
}

public function calculateAverageRating($i)
{
    // Assuming you have a property named $idartisan in your Artisan model
    $idartisan = $i;

    // Get all products for the artisan
    $totalProducts = Product::where('user_id', $idartisan)->get();

    $totalRating = 0;

    if ($totalProducts->count() > 0) {
        foreach ($totalProducts as $product) {
            $totalRating += $product->ratings->avg('rating');
        }

        return $totalRating / $totalProducts->count();
    }

    return 0; 
}


}
