<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('edit', compact('user'));
    }


    public function history(){
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
        ->where('status', 'on delivery')
        ->orderBy('created_at', 'desc') 
        ->get();

    return view('history', compact('orders','user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'adresse' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = Auth::user();
    
        $updateData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'adresse' => $request->input('adresse'),
            'phone' => $request->input('phone'),
        ];
    
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $updateData['profile_picture'] = $path;
        }
    
        $user->update(array_filter($updateData));
    
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    
    
}

