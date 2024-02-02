<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'artisan_id',
        'livreur_id',
        'status',
        'queue',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }



    public function livreur()
    {
        return $this->belongsTo(Livreur::class)->withDefault();
    }
        public function artisanOrders()
    {
        return $this->hasMany(Order::class)
            ->where('artisan_id', $this->id)
            ->getQuery()
            ->macro('latest', function (Builder $builder) {
                return $builder->orderByDesc($this->getQualifiedCreatedAtColumn());
            });
    }
    public function scopeAcceptedByLivreur($query, $livreurId)
    {
        return $query->where('livreur_id', $livreurId)->where('status', 'accepted')->first();
    }
        public function scopeLivreurOrders($query, $livreurId)
    {
        return $query->where('livreur_id', $livreurId)->where('queue', true);
    }
}

