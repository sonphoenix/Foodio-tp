@extends('layoute')
@section ('main')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg pr-2 pl-2">
    <h3 class="text-center">asign livreurs for Orders</h3>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <!-- Your table header -->
            <tr>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3">
                    User
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Subcategory
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantity
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Price
                </th>
                <th scope="col" class="px-6 py-3">
                    livreur
                </th>
                <th scope="col" class="px-6 py-3">
                    send
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- Check if the user is authenticated before accessing orders -->
            @auth
                @foreach (Auth::user()->artisanOrders1()->where('status', 'accepted')->latest()->get() as $order)
                    <tr class="bg-white border-b">
                        <!-- Your order details here -->
                        <td scope="col" class="px-6 py-3">{{ $order->product->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->user->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->sub_category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->quantity}}</td>
                        <td scope="col" class="px-6 py-3">${{ number_format($order->total_price, 2) }}</td>
                        
                        <form action="{{ route('update.order.queue') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <td scope="col" class="px-6 py-3">
                                <select name="livreur" id="livreurSelect">
                                    @foreach (\App\Models\Livreur::notWorking()->get() as $livreur)
                                        <option value="{{ $livreur->id }}">{{ $livreur->user->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td scope="col" class="px-6 py-3">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Send
                                </button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            @endauth
        </tbody>
    </table>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg pr-2 pl-2">
    <h3 class="text-center">requests sent</h3>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <!-- Your table header -->
            <tr>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3">
                    User
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Subcategory
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantity
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Price
                </th>
                <th scope="col" class="px-6 py-3">
                    livreur
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- Check if the user is authenticated before accessing orders -->
            @auth
                @foreach (Auth::user()->artisanOrders2()->where('status', 'accepted')->latest()->get() as $order)
                    <tr class="bg-white border-b">
                        <!-- Your order details here -->
                        <td scope="col" class="px-6 py-3">{{ $order->product->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->user->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->sub_category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->quantity}}</td>
                        <td scope="col" class="px-6 py-3">${{ number_format($order->total_price, 2) }}</td>
                        <td scope="col" class="px-6 py-3"> {{ $order->livreur->user->name }}</td>
                    </tr>
                @endforeach
            @endauth
        </tbody>
    </table>
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
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


@endsection