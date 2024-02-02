@extends('layoute')
@section('main')
<script>
    if (window.jQuery) {
        console.log("jQuery is loaded!");
    } else {
        console.log("jQuery is NOT loaded!");
    }
</script>

<ul class="box-info">
    <li class="border border-gray-300 rounded p-4 m-2">
        <i class='bx bxs-calendar-check'></i>
        <span class="text">
            <h3>{{ auth()->user()->artisanOrders()->count() }}</h3>
            <p>New Order</p>
        </span>
    </li>
    <li class="border border-gray-300 rounded p-4 m-2">
        <i class='bx bxs-group'></i>
        <span class="text">
            <h3>{{auth()->user()->artisanProducts()}}</h3>
            <p>products</p>
        </span>
    </li>
    <li class="border border-gray-300 rounded p-4 m-2">
        <i class='bx bxs-dollar-circle'></i>
        <span class="text">
            <h3 id="total sales"> </h3>
            <p>Total Sales</p>
        </span>
    </li>

    <!-- Display user-specific information only if the user is authenticated -->
    @auth
    <li class="border border-gray-300 rounded p-4 m-2">
        <i class='bx bxs-archive'></i>
        <span class="text">
            <h3>{{ auth()->user()->totalOrders()->count() }}</h3>
            <p>Orders</p>
        </span>
    </li>
    @endauth
</ul>
<div class="flex space-x-8">
    <!-- Pie Chart for Total Number of Products -->
    <div class="flex-1 pl-2">
        <h2 class="text-2xl font-semibold mb-4 text-center">Total Number of Products</h2>
        <canvas id="productCategoryChart" width="400" height="400" class="rounded-lg border border-gray-300"></canvas>
    </div>

    <!-- Pie Chart for Total Revenue -->
    <div class="flex-1 pr-2">
        <h2 class="text-2xl font-semibold mb-4 text-center">Total Revenue</h2>
        <canvas id="totalRevenueChart" width="400" height="400" class="rounded-lg border border-gray-300"></canvas>
    </div>
</div>




<div class="relative overflow-x-auto shadow-md sm:rounded-lg pr-2 pl-2">
    <h3 class="text-center">Recent Commands</h3>
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
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- Check if the user is authenticated before accessing orders -->
            @auth
                @forelse (Auth::user()->artisanOrders()->where('status', 'pending')->latest()->get() as $order)
                    <tr class="bg-white border-b">
                        <!-- Your order details here -->
                        <td scope="col" class="px-6 py-3">{{ $order->product->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->user->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->sub_category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->quantity}}</td>
                        <td scope="col" class="px-6 py-3">${{ number_format($order->total_price, 2) }}</td>
                        <td>
                            <!-- Your action buttons here -->
                            <a href="#" class="font-medium text-blue-600 hover:underline px-2" name="details"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('orders.accept', $order) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="font-medium text-blue-600 hover:underline px-2" name="accept">
                                    <i class="fa-solid fa-check"></i> Accept
                                </button>
                            </form>
                            <form action="{{ route('orders.refuse', $order) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-blue-600 hover:underline" name="refuse">
                                    <i class="fa-solid fa-trash"></i> Refuse
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No orders available</td>
                    </tr>
                @endforelse
            @endauth
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            // Fetch data when the page loads
            fetchDataAndRenderCharts();
    
            // Function to fetch data and render the charts
            function fetchDataAndRenderCharts() {
                // Fetch total number of products data
                $.ajax({
                    url: "{{ route('artisan.pie-chart-data') }}",
                    method: 'POST',
                    data: {
                        artisan_id: {{ auth()->id() }},
                    },
                    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
                    dataType: 'json',
                    success: function(response) {
                        // Render the product category pie chart with the fetched data
                        renderProductCategoryPieChart(response);
                    },
                    error: function(error) {
                        console.error(error.responseText);
                    }
                });
    
                // Fetch total revenue data
                $.ajax({
                    url: "{{ route('artisan.total-revenue-chart-data') }}",
                    method: 'POST',
                    data: {
                        artisan_id: {{ auth()->id() }},
                    },
                    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
                    dataType: 'json',
                    success: function(response) {
                        // Render the total revenue pie chart with the fetched data
                        renderTotalRevenuePieChart(response);
                    },
                    error: function(error) {
                        console.error(error.responseText);
                    }
                });
            }
    
            // Function to render the product category pie chart
            function renderProductCategoryPieChart(data) {
                var ctx = document.getElementById('productCategoryChart').getContext('2d');
    
                var pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Salé', 'Sucré'],
                        datasets: [{
                            data: [data.saleCount, data.sucreCount],
                            backgroundColor: ['#FF5733', '#33FF57'], // Update with your desired colors
                        }]
                    }
                });
            }
    
            // Function to render the total revenue pie chart
            function renderTotalRevenuePieChart(data) {
                var ctx = document.getElementById('totalRevenueChart').getContext('2d');
// Calculate the sum of all total sales
var totalSalesSum = Object.values(data.totalRevenueData)
    .map(Number)  // Convert values to numbers
    .reduce((acc, value) => acc + value, 0);

// Update the inner HTML of the element with the ID "total sales"
document.getElementById('total sales').innerHTML = totalSalesSum.toFixed(2)+"da";

    
                var pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data.totalRevenueData),
                        datasets: [{
                            data: Object.values(data.totalRevenueData),
                            backgroundColor: ['#FF5733', '#33FF57'], // Update with your desired colors
                        }]
                    }
                });
            }
        });
    </script>
    
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


