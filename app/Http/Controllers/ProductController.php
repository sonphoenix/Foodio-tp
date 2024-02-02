<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;

class ProductController extends Controller
{
    
public function store(Request $request)
{       

    $request->validate([
        'productName' => 'required|string|max:255',
        'productPrice' => 'required|numeric',
        'productDescription' => 'required|string',
        'productImages.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'productCategory' => 'required|string',
        'productSubcategory' => 'required|string',
        'productStorage' => 'required|string',
        'minPieces' => 'required|integer',
    ]);
    $product = new Product();
    $product->name = $request->input('productName');
    $product->price = $request->input('productPrice');
    $product->description = $request->input('productDescription');
    $product->category = $request->input('productCategory');
    $product->sub_category = $request->input('productSubcategory');
    $product->storage = $request->input('productStorage');
    $product->min_pieces = $request->input('minPieces');
    $product->rating = 0;

    $imagePaths = [];
    if ($request->hasFile('productImages')) {
        foreach ($request->file('productImages') as $image) {
            $imagePath = $image->store('product_images', 'public');
            $imagePaths[] = $imagePath;
        }
    }
    $product->product_images = $imagePaths;

    auth()->user()->products()->save($product);

    return redirect()->back()->with('success', 'Product added successfully');
}

public function edit($id)
{
    $product = Product::findOrFail($id);

    return view('artisan_modify_product', compact('product'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'productName' => 'required|string',
        'productPrice' => 'required|numeric',
        'productDescription' => 'required|string',
        'productImages' => 'sometimes|array',
        'productCategory' => 'required|string',
        'productSubcategory' => 'sometimes|string',
        'productStorage' => 'required|string',
        'minPieces' => 'required|integer',
    ]);

    $product = Product::findOrFail($id);

    $product->name = $request->input('productName');
    $product->price = $request->input('productPrice');
    $product->description = $request->input('productDescription');
    $product->category = $request->input('productCategory');
    $product->sub_category = $request->input('productSubcategory');
    $product->storage = $request->input('productStorage');
    $product->min_pieces = $request->input('minPieces');

    if ($request->hasFile('productImages')) {

        $imagePaths = [];
        foreach ($request->file('productImages') as $image) {
            $path = $image->store('public/products');
            $imagePaths[] = asset('storage/' . str_replace('public/', '', $path));
        }

        $product->product_images = json_encode($imagePaths);
    }

    $product->save();

    return redirect()->route('artisan.all.products')->with('success', 'Product updated successfully');
}



public function showProductList(Request $request)
{
    $products = Product::query();

    if ($request->filled('category')) {
        $products->where('category', $request->category);
    }

    if ($request->filled('subcategory')) {
        $products->where('sub_category', $request->subcategory);
    }

    if ($request->filled('price')) {
        $products->where('price', '<=', $request->price);
    }

    $filteredProducts = $products->get();

    return view('product-list', ['products' => $filteredProducts]);

}


public function showDetails($id)
{
    $product = Product::find($id);

    return view('product', ['product' => $product]);
}

public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('artisan.all.products')->with('success', 'Product deleted successfully');
}


public function rate(Request $request, Product $product)
{
    $request->validate([
        'rating' => 'required|integer|between:1,5',
    ]);

    $user = auth()->user();

    if ($user->ratings()->where('product_id', $product->id)->exists()) {
        return redirect()->back()->with('error', 'You have already rated this product.');
    }

    $rating = new Rating([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'rating' => $request->input('rating'),
    ]);

    $rating->save();

    return redirect()->back()->with('success', 'Thank you for rating this product!');
}
public function filter(Request $request)
{
    $category = $request->input('category');
    $subcategory = $request->input('subcategory');
    $minPrice = $request->input('minPrice');
    $maxPrice = $request->input('maxPrice');
    $search=$request->input('searchQuery');
    $rating = $request->input('rating'); 


    $query = Product::query();

    if ($category && $category !== 'all') {
        $query->where('category', $category);
    }

    if ($subcategory && $subcategory !== 'all') {
        $query->where('sub_category', $subcategory);
    }

    if ($minPrice && $maxPrice) {
        $query->whereBetween('price', [$minPrice, $maxPrice]);
    }
    if($search){
        $query->where('name', $search);
    }


    $query->leftJoin('ratings', 'products.id', '=', 'ratings.product_id');
    $query->selectRaw('products.*, AVG(ratings.rating) as avg_rating');
    $query->groupBy('products.id');

    if ($rating) {
        $query->having('avg_rating', '>=', $rating);
    }



    $filteredProducts = $query->get();
    $filteredProducts->transform(function ($product) {
        if (is_string($product->product_images)) {
            $product->product_images = json_decode($product->product_images);
        }
        return $product;
    });

    return response()->json(['products' => $filteredProducts]);
}




}