<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Livreur extends Model
{
    protected $fillable = [
        'user_id',
        'start_work_time',
        'end_work_time',
        'is_working',
    ];
    public function scopeNotWorking($query)
    {
        return $query->where('is_working', false);
                   
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function calculateEarnings()
    {
        $orders = $this->orders;

        // Calculate the sum of 35% of each order's total_price
        $earnings = $orders->sum(function ($order) {
            return $order->total_price * 0.35;
        });

        return $earnings;
    }
    public function countOrdersOnDelivery()
    {
        // Get the count of orders with the status "on delivery"
        $count = $this->orders()->where('status', 'on delivery')->count();

        return $count;
    }

    
}
