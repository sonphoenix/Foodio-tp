@extends('layoute')
@section('main')
    <div class="container mx-auto mt-4">
        <div class="flex justify-center">
            <div class="w-full md:w-8/12">
                <div class="border p-4">
                    <h2 class="text-center mb-4 text-2xl font-semibold">Business Information</h2>
                    <form method="POST" action="{{ route('artisan.store_business_profile') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="businessName" class="form-label">Business Name</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-md" id="businessName" name="business_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="w-full px-3 py-2 border rounded-md" id="phoneNumber" name="phone_number" required>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-md" id="location" name="location" required>
                        </div>

                        <div class="mb-3">
                            <label for="businessLogo" class="form-label">Business Logo</label>
                            <input type="file" class="w-full px-3 py-2 border rounded-md" id="businessLogo" name="business_logo" accept="image/*">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


@endsection

