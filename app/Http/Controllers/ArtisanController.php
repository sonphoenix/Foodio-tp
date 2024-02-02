<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artisan;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ArtisanController extends Controller
{

    public function showBusinessProfileForm()
    {
        return view('artisan_business_profile');
    }

    public function index()
    {
        return view('artisan');
    }

    public function addProduct()
    {
        return view('addproduct');
    }

    public function allProducts()
    {
        return view('artisan_allproducts');
    }
    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'business_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        $artisan = new Artisan();
        $artisan->business_name = $request->input('business_name');
        $artisan->phone_number = $request->input('phone_number');
        $artisan->location = $request->input('location');

        if ($request->hasFile('business_logo')) {
            $logoPath = $request->file('business_logo')->store('business_logos', 'public');
            $artisan->business_logo = $logoPath;
        }

        $user->artisan()->save($artisan);

        return redirect()->back()->with('success', 'Business information saved successfully');
    }

    public function showBusinessProfile()
{
    $user = Auth::user();
    $artisan = $user->artisan;  
    return view('business_profile', compact('artisan'));
}

public function showBusinessProfilePicture($userId)
{   
    $user = User::find($userId);
    
    $artisan = $user->artisan;

    return view('business_profile', compact('artisan'));
}

public function asignlivreurs(){
    return view('artisan_asign_livreurs');
}


public function showArtisanList(Request $request)
{
    $artisans = Artisan::query();


    if ($request->filled('rating')) {
        $artisans->where('rating', '>=', $request->rating);
    }

    $filteredArtisans = $artisans->get();

    return view('artisan_list', ['artisans' => $filteredArtisans]);
}

public function filter(Request $request)
{
    $rating = $request->input('rating');
    $searchQuery = $request->input('searchQuery');

    $artisans = Artisan::all();

    $filteredArtisans = [];

    foreach ($artisans as $artisan) {
        $calculatedRating = number_format($artisan->calculateAverageRating($artisan->user_id), 2);

        $ratingMatch = ($rating && $calculatedRating >= $rating) || (!$rating);
        $searchMatch = (!$searchQuery || stripos($artisan->business_name, $searchQuery) !== false);

        if ($ratingMatch && $searchMatch) {
            $filteredArtisans[] = [
                'id' => $artisan->user_id,
                'business_name' => $artisan->business_name,
                'location' => $artisan->location,
                'calculatedRating' => $calculatedRating,
                'business_logo' => $artisan->business_logo,
            ];
        }
    }

    return response()->json(['artisans' => $filteredArtisans]);
}





public function getPieChartData(Request $request)
{
    $artisanId = $request->input('artisan_id');
    
    $saleCount = Product::where('user_id', $artisanId)->where('category', 'salé')->count();

    $sucreCount = Product::where('user_id', $artisanId)->where('category', 'sucré')->count();

    return response()->json(['saleCount' => $saleCount, 'sucreCount' => $sucreCount]);
}


public function totalRevenueChartData(Request $request)
{
    $artisanId = $request->input('artisan_id');

    $totalRevenueData = DB::table('orders')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->select('products.category', DB::raw('SUM(orders.total_price * 0.65) as total_revenue'))
        ->where('products.user_id', $artisanId)
        ->whereIn('orders.status', ['on delivery', 'accepted'])
        ->groupBy('products.category')
        ->get();

    $result = [];
    foreach ($totalRevenueData as $item) {
        $result[$item->category] = $item->total_revenue;
    }

    return response()->json(['totalRevenueData' => $result]);
}

public function driverHistory()
{
    $artisan = Artisan::find(auth()->id());

    $orders = Order::where('artisan_id', auth()->id())
        ->where('status', 'on delivery')
        ->orderBy('created_at', 'desc') 
        ->get();

    return view('artisan_history', compact('orders'));
}



    
}
