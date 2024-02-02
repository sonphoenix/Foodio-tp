@extends('layoute')

@section('main')
    <div class="container mx-auto mt-4">
        <div class="flex justify-center">
            <div class="w-full md:w-8/12">
                <div class="border p-4">
                    <h2 class="text-center mb-4 text-2xl font-semibold">Modify Product</h2>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('products.update', $product->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-md" id="productName" name="productName" value="{{ $product->name }}" required>
                        </div>

                        <!-- Product Price -->
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Product Price</label>
                            <input type="number" class="w-full px-3 py-2 border rounded-md" id="productPrice" name="productPrice" value="{{ $product->price }}" required>
                        </div>

                        <!-- Product Description -->
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Product Description</label>
                            <textarea class="w-full px-3 py-2 border rounded-md" id="productDescription" name="productDescription" rows="3" required>{{ $product->description }}</textarea>
                        </div>

                        <!-- Product Images -->
                        <div class="mb-3">
                            <label for="productImages" class="form-label">Product Images</label>
                            <input type="file" class="w-full px-3 py-2 border rounded-md" id="productImages" name="productImages[]" multiple accept="image/*">
                        </div>

                        <!-- Product Category -->
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Product Category</label>
                            <select class="w-full px-3 py-2 border rounded-md" id="productCategory" name="productCategory" required>
                                <option value="salé" {{ $product->category == 'salé' ? 'selected' : '' }}>salé</option>
                                <option value="sucré" {{ $product->category == 'sucré' ? 'selected' : '' }}>sucré</option>
                            </select>
                        </div>

                        <!-- Product Subcategory -->
                        <div class="mb-3">
                            <label for="productSubcategory" class="form-label">Product Subcategory</label>
                            <select class="w-full px-3 py-2 border rounded-md" id="productSubcategory" name="productSubcategory">
                                @foreach(Auth::user()->subcategories as $subcategory)
                                    <option value="{{ $subcategory->name }}" {{ $product->sub_category == $subcategory->name ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Storage -->
                        <div class="mb-3">
                            <label for="productStorage" class="form-label">Product Storage</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-md" id="productStorage" name="productStorage" value="{{ $product->storage }}" required>
                        </div>

                        <!-- Minimum Pieces -->
                        <div class="mb-3">
                            <label for="minPieces" class="form-label">Minimum Pieces</label>
                            <input type="number" class="w-full px-3 py-2 border rounded-md" id="minPieces" name="minPieces" value="{{ $product->min_pieces }}" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Changes</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md text-center">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this product?')) {
                // If the user confirms, submit the form for deletion
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection
@section('sidebar')

<ul>
    <li>
        <a href="/home2">
            <span class="icon">
                <ion-icon name="pizza-outline"></ion-icon>
            </span>
            <span class="title ">Foodio</span>
        </a>
    </li>

    <li>
        <a href="/artisan">
            <span class="icon">
                <ion-icon name="home-outline"></ion-icon>
            </span>
            <span class="title">Dashboard</span>
        </a>
    </li>

    
    <li>
        <a href="/artisan_allproducts">
            <span class="icon">
                <ion-icon name="grid-outline"></ion-icon>
                        </span>
            <span class="title">All Products</span>
        </a>
    </li>


    <li>
        <a href="{{ route('artisan.asign_livreurs') }}">
            <span class="icon">
                <ion-icon name="people-outline"></ion-icon>
            </span>
            <span class="title">asign livreurs</span>
        </a>
    </li>

    <li>
        <a href="/addproduct">
            <span class="icon">
                <ion-icon name="add-circle-outline"></ion-icon>
            </span>
            <span class="title">Add Product</span>
        </a>
    </li>

    <li>
        <a href="/driver_history">
            <span class="icon">
                <ion-icon name="help-outline"></ion-icon>
            </span>
            <span class="title">historyys</span>
        </a>
    </li>
    <li>
        <a href="{{ route('subcategories.create') }}">
            <span class="icon">
                <ion-icon name="add-circle-outline"></ion-icon>
            </span>
            <span class="title">Add subcategory</span>
        </a>
    </li>


    <li>
        @if(auth()->user()->artisan)
        <!-- User has filled business info -->
        <a href="{{ route('artisan.show_business_profile') }}" >
    @else
        <!-- User has not filled business info -->
        <a href="{{ route('artisan.business_profile') }}">
    @endif
            <span class="icon">
                <ion-icon name="accessibility-outline"></ion-icon>
            </span>
            <span class="title">Profile</span>
        </a>
    </li>

    <li>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="icon">
                <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
    
</ul>
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


@endsection
