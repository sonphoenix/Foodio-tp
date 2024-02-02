<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{   
    public function getUserOrders()
{
    $userId = auth()->id();

    $userType = auth()->user()->user_type;

    if ($userType == 0) {
        $userOrders = Order::where('artisan_id', $userId)->get();
    } else if($userType == 2) {
        $userOrders = Order::where('user_id', $userId)->get();
    }

    return response()->json(['userOrders' => $userOrders]);
}



    public function store(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'user_id' => 'required',
                'product_id' => 'required',
                'quantity' => 'required|integer|min:1',
            ]);
    
            $product = Product::findOrFail($request->product_id);
    
            $artisanId = $product->user_id;
    
            $totalPrice = $product->price * $request->quantity;
    
            $order = new Order();
            $order->user_id = $request->user_id;
            $order->product_id = $request->product_id;
            $order->artisan_id = $artisanId;
            $order->quantity = $request->quantity;
            $order->total_price = $totalPrice;
            $order->status = 'pending'; 

            $order->save();
    
              
            return redirect()->back()->with('success', 'Order placed successfully!');
        } else {
            return redirect()->route('login')->with('warning', 'Please log in to place an order.');
        }
    }
    

    
    public function acceptOrder(Order $order)
    {
        $order->update(['status' => 'accepted']);
    
        $order->product->update(['storage' => $order->product->storage - $order->quantity]);
    
    
        return redirect()->back()->with('success', 'Order accepted successfully!');
    }
    

        public function refuseOrder(Order $order)
        {
            $order->delete();


            return redirect()->back()->with('success', 'Order refused and deleted successfully!');
        }

        public function updateOrderQueue(Request $request)
    {   
        $request->validate([
            'livreur' => 'required|exists:livreurs,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        $livreurId = $request->input('livreur');
        $orderId = $request->input('order_id');

        $order = Order::findOrFail($orderId);

        if ($order->status === 'accepted' && !$order->queue) {
            $order->update([
                'queue' => true,
                'livreur_id' => $livreurId,
            ]);

            return redirect()->back()->with('success', 'Order sent successfully.');
        }

        return redirect()->back()->with('error', 'Invalid order status or already in the queue.');
    }

    }

