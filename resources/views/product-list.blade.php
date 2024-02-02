@extends('home')

@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="flex">
    <!-- Sidebar -->
    <div class="h-screen w-1/5 p-4 border">
        <!-- Add your filtering options here -->
        <h2 class="text-lg font-semibold mb-4 text-center">Filter Options</h2>
        <div>
            <!-- Category filter -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select id="categoryFilter" name="category" class="mt-1 p-2 border rounded-md w-full">
                    <!-- Options here -->
                    <option value="all">All</option>
                    <option value="salé">Salé</option>
                    <option value="sucré">Sucré</option>
                </select>
            </div>

            <!-- Subcategory filter -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Subcategory</label>
                <select id="subcategoryFilter" name="subcategory" class="mt-1 p-2 border rounded-md w-full">
                    <!-- Options here -->
                    <option value="all">All</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->name }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
            </div>
                <!-- Rating filter -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <input id="ratingFilter" type="number" placeholder="Enter rating" class="mt-1 p-2 border rounded-md w-full">
                </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Price Range</label>
                <div class="flex flex-col">
                    <input id="minPriceFilter" type="text" placeholder="Min Price" class="mb-2 p-2 border rounded-md text-sm">
                    <label class="block text-sm font-medium text-gray-700 text-center">to</label>
                    <input id="maxPriceFilter" type="text" placeholder="Max Price" class="p-2 border rounded-md text-sm">
                </div>
            </div>

            <!-- Filter button -->
            <div class="mb-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="filterProducts()">Filter</button>
            </div>
        </div>
    </div>

    <!-- Product List Content -->
    <div class="flex-1 p-4">
        <!-- Add your product list content here -->
        <h2 class="text-2xl font-semibold mb-4 text-center mb-5">Product List</h2>


        <!-- search bar -->
 
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search." required>
                <button onclick="filterProducts()" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>

        <!-- Product list container -->
        <div id="productListContainer" class="flex flex-wrap justify-between mx-auto max-w-screen-xl">
            @foreach($products as $product)
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function filterProducts() {
        // Get filter values
        var category = $('#categoryFilter').val();
        var subcategory = $('#subcategoryFilter').val();
        var minPrice = $('#minPriceFilter').val();
        var maxPrice = $('#maxPriceFilter').val();
        var searchQuery = $('#default-search').val();
        var rating = $('#ratingFilter').val();

        // Send Ajax request
        $.ajax({
            url: "{{ route('products.filter') }}",
            method: 'POST',
            data: {
                category: category,
                subcategory: subcategory,
                minPrice: minPrice,
                maxPrice: maxPrice,
                searchQuery: searchQuery,
                rating : rating
                
            },
            dataType: 'json',  // Specify JSON dataType
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response.products);

                // Clear existing products
                $('#productListContainer').empty();
                // Append new products
                // Append new products
response.products.forEach(function (product) {
    // Map product images to HTML
    var imagePaths = product.product_images;
    var firstImagePath = imagePaths.length > 0 ? "{{ asset('storage/') }}" + '/' + imagePaths[0] : "{{ asset('storage/default_image_path.jpg') }}";
    // Create the product card HTML
    var productCard = `
        <div class="relative m-4 flex-none w-full max-w-xs sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
            <a class="relative mx-3 mt-3 flex overflow-hidden rounded-t-xl rounded-b-none" href="#" style="height: 200px;">
                <img class="object-cover w-full h-full rounded-t-xl" src="${firstImagePath}" alt="product image" />

                <span class="absolute top-0 left-0 m-2 rounded-full bg-black px-2 text-center text-sm font-medium text-white">${product.category} - ${product.sub_category}</span>
            </a>
            <div class="mt-4 px-5 pb-5 rounded-b-xl">
                <a href="#">
                    <h5 class="text-xl tracking-tight text-slate-900">${product.name}</h5>
                </a>
                <p class="text-sm text-gray-500">Created by:        
                @php
                    echo $product->user->name;
                @endphp
                </p>
                <div class="mt-2 mb-5 flex items-center justify-between">
                    <p>
                        <span class="text-3xl font-bold text-slate-900">${product.price} DA</span>
                    </p>
                    <div class="flex items-center">
                        ${Array.from({ length: product.rating }, (_, index) => `
                            <svg aria-hidden="true" class="h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.810l-2.8 2-034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        `).join('')}
                        <span class="mr-2 ml-3 rounded bg-yellow-200 px-2.5 py-0.5 text-xs font-semibold">
                            @php
                    echo $product->averageRating();
                @endphp
                            </span>
                    </div>
                </div>
                <a href="/product/details/${product.id}" class="flex items-center justify-center rounded-md bg-slate-900 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    See the product
                </a>
            </div>
        </div>
    `;

    // Append the product card to the container
    $('#productListContainer').append(productCard);
});


            },
            error: function(error) {
                console.error(error.responseText);
            }
        });
    }
</script>
@endsection
