@extends('home')

@section('main')
    <!-- Main Content Area -->
    <div class="min-h-screen flex justify-center items-center w-full">
        <div class="bg-gradient-to-r from-purple-500 via-indigo-500 to-pink-500 p-8 rounded-md shadow-md text-white text-center">
            <!-- Circular background for the business image -->
            <div class="bg-white rounded-full h-32 w-32 mx-auto mb-4 overflow-hidden">
                <img src="{{ asset('storage/' . $artisan->business_logo) }}" alt="Business Logo" class="w-full h-full object-cover">
            </div>
            <!-- Display other business information below -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="mb-6">
                    <label class="text-gray-600 text-sm block">Business Name</label>
                    <p class="text-lg font-semibold">{{ $artisan->business_name }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-600 text-sm block">Phone Number</label>
                    <p>{{ $artisan->phone_number }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-600 text-sm block">Location</label>
                    <p>{{ $artisan->location }}</p>
                </div>
                <div class="mb-6">
                    <label class="text-gray-600 text-sm block">Rating</label>
                    <p class="text-lg font-semibold text-green-400">{{ number_format($artisan->calculateAverageRating($artisan->user_id), 2) }}</p>
                </div>
            </div>

            <!-- Display all products of the artisan -->
            <div class="mt-8 w-full">
                <h2 class="text-2xl font-semibold mb-4">Artisan's Products</h2>
                <div class="flex flex-wrap -mx-4">
                    @foreach($artisan->user->products as $product)
                    @php
                    $imagePaths = $product->product_images;
                    $firstImagePath = isset($imagePaths[0]) ? asset('storage/' . $imagePaths[0]) : asset('storage/default_image_path.jpg');
                @endphp
                @component('components.product-card-forall', [
                    'image' => $firstImagePath,
                    'category' => $product->category,
                    'sub_category' => $product->sub_category,
                    'title' => $product->name,
                    'price' => $product->price,
                    'creator' => $product->user->name,
                    'rating' => $product->averageRating(),
                    'id' => $product->id,
                ])
                @endcomponent
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
