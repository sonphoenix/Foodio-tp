<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Auth::user()->subcategories()->create([
            'name' => $request->input('name'),
        ]);

        return redirect()->back()->with('success', 'Subcategory created successfully');
    }

    public function create()
    {
        return view('addcategory');
    }
}
