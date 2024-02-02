<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Livreur;
use  Illuminate\Support\Facades\Auth;
use App\Models\Order;


class livreurcontroller extends Controller
{

    public function index()
    {
        $user = auth()->user();
    
        if ($user->user_type == 1 || $user->livreur) {
            $assignedOrders = Order::where('livreur_id', optional($user->livreur)->id)
                ->where('queue', true)
                ->get();
                $totalc = Order::where('livreur_id',  optional($user->livreur)->id)
                ->where('status', 'on delivery')
                ->orderBy('created_at', 'desc')
                ->count();
                $totali = Order::where('livreur_id',  optional($user->livreur)->id)
                ->where('queue',1)
                ->orderBy('created_at', 'desc') 
                ->count();
                $totalIncome = Order::where('livreur_id', optional($user->livreur)->id)
                ->sum('total_price')*0.35;
           
            return view('driver', compact('assignedOrders','totalc','totalIncome','totali'));
        }
    
  
        return view('driver', ['assignedOrders' => []]);
    }

    public function history()
    {
        
        $user = auth()->user();
    
        if ($user->user_type == 1 || $user->livreur) {
            $assignedOrders = Order::where('livreur_id', optional($user->livreur)->id)
                ->where('status', 'on delivery')
                ->get();
    
            return view('driver_history', ['assignedOrders' => $assignedOrders]);
        }
    
        return view('driver', ['assignedOrders' => []]);
    }
    
    


    public function workingHoursForm(){
        return view('livreur_worktime');
    }

    public function editworkingHoursForm(){
       
        $user = auth()->user();

        
        $livreur = $user->livreur;

        if (!$livreur) {
            return redirect()->back()->with('error', 'Livreur not found');
        }

      
        return view('livreur_edit_worktime', compact('livreur'));
    }


    public function saveWorkingHours(Request $request)
    {   
       
        $request->validate([
            'start_work_time' => 'required',
            'end_work_time' => 'required',
        ]);

        $user = auth()->user();

   
    $livreur = $user->livreur;

    if (!$livreur) {
        $livreur = new Livreur();
    }

    $livreur->start_work_time = $request->input('start_work_time');
    $livreur->end_work_time = $request->input('end_work_time');

    $user->livreur()->save($livreur);

        return redirect()->back()->with('success', 'working information saved successfully');
    }

    public function updateWorkingHours(Request $request)
    {
        $request->validate([
            'start_work_time' => 'required',
            'end_work_time' => 'required',
        ]);

        $user = auth()->user();

        $livreur = $user->livreur;


        $livreur->update([
            'start_work_time' => $request->input('start_work_time'),
            'end_work_time' => $request->input('end_work_time'),
        ]);

        return redirect()->back()->with('success', 'Working hours updated successfully');
    }


    public function updateOrderStatus(Order $order)
    {
        $livreurAction = request('livreur_action');
    
        if ($livreurAction === 'accept') {
            $order->update([
                'queue' => false,
                'status' => 'on delivery',
            ]);
        } elseif ($livreurAction === 'refuse') {
            $order->update([
                'livreur_id' => null,
                'queue' => false,
            ]);
        }
    
        return redirect()->back();
    }


    public function livreurProfile()
    {
        $livreur = Livreur::find(auth()->id());
    
        $totalIncome = $livreur->calculateEarnings();
        $ordersOnDeliveryCount = $livreur->countOrdersOnDelivery();
    
        dd($totalIncome, $ordersOnDeliveryCount);
    
        return view('driver', compact('totalIncome', 'ordersOnDeliveryCount'));
    }

    public function driverHistory()
    {
        $livreur = Auth::user();

        $orders = Order::where('livreur_id', $livreur->id)
            ->where('status', 'on delivery')
            ->orderBy('created_at', 'desc') 
            ->get();
        
            $orders1 = Order::where('livreur_id', $livreur->id)
            ->where('status', 'on delivery')
            ->orderBy('created_at', 'desc')
            ->count();

        return view('driver_history', compact('orders','order1'));
    }


    

}
