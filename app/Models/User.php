<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'adresse',
        'phone',
        'user_type',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    
    public function routeNotificationForDatabase()
    {
        return $this->id;
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }


    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

        public function artisan()
    {
        return $this->hasOne(Artisan::class);
    }

    public function livreur()
    {
        return $this->hasOne(livreur::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'livreur_id');
        }
    public function artisanOrders()
    {
        return Order::where('artisan_id', $this->id)
                     ->where('status', 'pending');
    }
    public function totalOrders()
    {
        return Order::where('artisan_id', $this->id)
                     ->where('status', 'accepted');
    }

    public function artisanOrders1()
    {
        return Order::where('artisan_id', $this->id)
                     ->where('status', 'accepted')
                     ->where('queue', 'false');
    }

    public function artisanProducts()
    {
        return Product::where('user_id', $this->id)->count();
    }

    public function artisanOrders2()
    {
        return Order::where('artisan_id', $this->id)
                     ->where('status', 'accepted')
                     ->where('queue', 1);
    }

    public function livreurOrders()
    {
        return Order::where('livreur_id', $this->id)
                     ->where('status', 'on delivery')
                     ->count();

    }

    public function history()
    {
        return Order::where('user_id', $this->id)
                     ->where('status', 'on delivery');

    }



    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function calculateEarnings()
    {
        $orders = $this->orders;

        $earnings = $orders->sum(function ($order) {
            return $order->total_price * 0.35;
        });

        return $earnings;
    }

    public function countOrdersOnDelivery()
    {
        $count = Order::where('livreur_id', $this->id)
            ->where('status', 'on delivery')
            ->count();

        return $count;
    }
    
    public function livreurOrdersCount()
    {
        return $this->orders()->count();
    }
    public function calculateTotalIncome()
    {
        $orders = $this->orders;

        $totalIncome = 0;

        foreach ($orders as $order) {
            $totalIncome += $order->total_price * 0.35;
        }

        return $totalIncome;
    }

}
