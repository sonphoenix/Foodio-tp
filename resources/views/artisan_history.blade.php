@extends('layoute')
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


@section('main')
<p class="text-center"> history</p>
<table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-5">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3">
                Product name
            </th>
            <th scope="col" class="px-6 py-3">
                phone number
            </th>
            <th scope="col" class="px-6 py-3">
                Category
            </th>
            <th scope="col" class="px-6 py-3">
                Price
            </th>
            <th scope="col" class="px-6 py-3">
                Address
            </th>
            <th scope="col" class="px-6 py-3">
                income
            </th>
            <th scope="col" class="px-6 py-3">
                date
            </th>
        </tr>
    </thead>
    <tbody>
        <!-- Check if the user is authenticated before accessing orders -->
        @auth
            @foreach ($orders as $order)

                    <tr class="bg-white border-b">
                        <!-- Your order details here -->
                        <td scope="col" class="px-6 py-3">{{ $order->product->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->user->phone }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->total_price }} da</td>
                        <td scope="col" class="px-6 py-3">{{ $order->user->adresse }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->total_price *0.65 }} da</td>
                        <td scope="col" class="px-6 py-3">{{$order->created_at}} </td>
                    </tr>
                </form>
            @endforeach
        @endauth
    </tbody>
</table>
@endsection