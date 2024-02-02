@extends('home')

@section('main')
<div class="card-wrapper flex">
    <!-- card left -->
    <div class="product-imgs w-1/2 p-4">
        <div class="img-display">
            <div class="img-showcase">
                @foreach ((is_array($product->product_images) ? $product->product_images : json_decode($product->product_images, true)) as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="product image" class="w-full h-full object-cover">
                @endforeach
            </div>
        </div>
        <div class="img-select mt-4 flex gap-2">
            @foreach ($product->product_images as $index => $image)
                <div class="img-item">
                    <a data-id="{{ $index + 1 }}" onclick="changeImage('{{ asset('storage/' . $image) }}')">
                        <img src="{{ asset('storage/' . $image) }}" alt="product image" class="w-16 h-16 object-cover">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- card right -->
    <div class="product-content w-1/2 p-4">
        <h2 class="product-title text-2xl font-semibold mb-2">{{ $product->name }}</h2>
        <p>Creator: <a href="{{ route('artisan.show_business_profile_picture', $product->user_id) }}" class="product-link">{{ $product->user->name }}</a></p>

        <!-- Display Ratings -->
        <div class="product-rating flex items-center mt-2">
            @for ($i = 0; $i < 5; $i++)
                @if ($i < $product->averageRating())
                    <i class="fas fa-star text-yellow-500"></i>
                @else
                    <i class="fas fa-star-half-alt text-yellow-500"></i>
                @endif
            @endfor
            <span id="rating" class="ml-2">{{ $product->averageRating() }} ({{ $product->totalRatings() }})</span>
        </div>

        <div class="product-detail mt-4">
            <h2 class="text-xl font-semibold mb-2">About this item:</h2>
            <p>{{ $product->description }}</p>
        </div>

        <div class="product-storage mt-4">
            <h2 class="text-xl font-semibold mb-2">Storage:</h2>
            <p>{{ $product->storage }}</p>
        </div>

        <!-- Purchase Info with Rating Form -->
        <div class="purchase-info mt-4">
            <form method="POST" action="{{ route('orders.store') }}" onsubmit="return orderProduct()">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <label for="quantity" class="block mb-2">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="{{ $product->min_pieces }}" value="{{ $product->min_pieces }}" class="w-16 p-2 border border-gray-300 rounded mb-2">
                <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded">Order<i class="fas fa-shopping-cart ml-2"></i></button>
            </form>

            <!-- Rating Form -->
            <form method="POST" action="{{ route('products.rate', $product->id) }}" class="mt-4">
                @csrf
                <label for="rating" class="block mb-2">Rate This Product:</label>
                <select name="rating" id="rating" class="w-16 p-2 border border-gray-300 rounded mb-2">
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
                <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded">Submit Rating</button>
            </form>
        </div>

        <div class="social-links mt-4">
            <p class="mb-2">Share At: </p>
            <a href="#" class="mr-2">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="mr-2">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="mr-2">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="mr-2">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="#">
                <i class="fab fa-pinterest"></i>
            </a>
        </div>
    </div>
</div>

<script src="js/product.js"></script>
<script>
    function changeImage(imagePath) {
        document.querySelector('.img-showcase img').src = imagePath;
    }

    function orderProduct() {
        // Get the quantity input value
        var quantity = parseInt(document.getElementById('quantity').value);

        // Check if the quantity is greater than or equal to minpieces
        if (quantity < {{ $product->min_pieces }} ) {
            alert('Please enter a quantity of at least {{ $product->min_pieces }}.');
            return false; // prevent form submission
        }
        else if(quantity > {{$product->storage}}){
            alert('Please enter a quantity of at equal or less than  {{ $product->storage }}.');
            return false; // prevent form submission
        }

        // Allow form submission if quantity is valid
        return true;
    }
</script>

@endsection
