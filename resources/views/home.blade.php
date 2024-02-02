<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/product.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" 
    integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <script src="js/script.js"> </script>


<script>
    // Assuming you're using jQuery for simplicity
    $(document).ready(function() {
        // Make an Ajax request to fetch user orders
        $.ajax({
            type: 'GET',
            url: '/user-orders',
            success: function(response) {

                console.log(response.userOrders);
                var userType = {{ Auth::check() ? Auth::user()->user_type : -1 }};

                // Handle the response
                if (response.userOrders.length > 0  && userType == 2) {
                    // Create a dropdown menu with user orders
                    var dropdownContent = '<div id="dropdownNotification" class="z-20 hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg" aria-labelledby="dropdownNotificationButton">';
                    dropdownContent += '<div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-md bg-gray-50 dark:bg-gray-800 dark:text-white">';
                    dropdownContent += 'Notifications';
                    dropdownContent += '</div>';
                    dropdownContent += '<div class="divide-y divide-gray-100 dark:divide-gray-700">';
                    
                    response.userOrders.forEach(function(order) {
                        dropdownContent += '<a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">';
                        dropdownContent += '<div class="w-full ps-3">';
                        dropdownContent += '<div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">';
                        dropdownContent += 'Order ID: ' + order.id + ' - Status ' + order.status;
                        dropdownContent += '</div>';
                        dropdownContent += '<div class="text-xs text-blue-600 dark:text-blue-500">' + order.created_at + '</div>';
                        dropdownContent += '</div>';
                        dropdownContent += '</a>';
                    });

                    dropdownContent += '</div>';
                    dropdownContent += '<a href="#" class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-md bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">';
                    dropdownContent += '<div class="inline-flex items-center ">';
                    dropdownContent += '<svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">';
                    dropdownContent += '<path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>';
                    dropdownContent += '</svg>';
                    dropdownContent += 'View all';
                    dropdownContent += '</div>';
                    dropdownContent += '</a>';
                    dropdownContent += '</div>';

                    // Append the dropdown menu to the navbar
                    $('button[name="notifications"]').after(dropdownContent);

                    // Toggle the visibility of the dropdown on button click
                    $('button[name="notifications"]').on('click', function() {
                        $('#dropdownNotification').toggleClass('hidden');
                    });
                }
                if(response.userOrders.length > 0  && userType == 0){
                    var dropdownContent = '<div id="dropdownNotification" class="z-20 hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg" aria-labelledby="dropdownNotificationButton">';
                    dropdownContent += '<div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-md bg-gray-50 dark:bg-gray-800 dark:text-white">';
                    dropdownContent += 'Notifications';
                    dropdownContent += '</div>';
                    dropdownContent += '<div class="divide-y divide-gray-100 dark:divide-gray-700">';
                    
                    response.userOrders.forEach(function(order) {
                        if(order.status==='on delivery' ){
                        dropdownContent += '<a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">';
                        dropdownContent += '<div class="w-full ps-3">';
                        dropdownContent += '<div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">';
                        dropdownContent += 'Order ID: ' + order.id + 'has been accepted' ;
                        dropdownContent += '</div>';
                        dropdownContent += '<div class="text-xs text-blue-600 dark:text-blue-500">' + order.created_at + '</div>';
                        dropdownContent += '</div>';
                        dropdownContent += '</a>';
                        }
                        if(order.status==='accepted' && order.queue===0 && order.livreur_id===null){
                        dropdownContent += '<a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">';
                        dropdownContent += '<div class="w-full ps-3">';
                        dropdownContent += '<div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">';
                        dropdownContent += 'Order ID: ' + order.id + 'has been refused' ;
                        dropdownContent += '</div>';
                        dropdownContent += '<div class="text-xs text-blue-600 dark:text-blue-500">' + order.created_at + '</div>';
                        dropdownContent += '</div>';
                        dropdownContent += '</a>';
                        }

                    });

                    dropdownContent += '</div>';
                    dropdownContent += '<a href="#" class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-md bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">';
                    dropdownContent += '<div class="inline-flex items-center ">';
                    dropdownContent += '<svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">';
                    dropdownContent += '<path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>';
                    dropdownContent += '</svg>';
                    dropdownContent += 'View all';
                    dropdownContent += '</div>';
                    dropdownContent += '</a>';
                    dropdownContent += '</div>';

                    // Append the dropdown menu to the navbar
                    $('button[name="notifications"]').after(dropdownContent);

                    // Toggle the visibility of the dropdown on button click
                    $('button[name="notifications"]').on('click', function() {
                        $('#dropdownNotification').toggleClass('hidden');
                    });
                }
                
                else {
                    // No orders for the user
                    console.log('No orders for the user.');
                }
            },
            error: function(error) {
                // Handle any errors
                console.error('Error fetching user orders:', error);
            }
        });
    });
</script>



    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
@vite('resources/css/app.css')
    <title>Foodio</title>
</head>
<body>
    <!-- Navbar -->
    <header class="z-10">
        <nav class="navbar bg-transparent flex items-center justify-between">
            <div class="topBar">
                <a href="/home2"><h1 class="text-3xl text-red-600 font-semibold">Foodio</h1></a>

                <img src="image\menu.svg" alt="menu" class="menuIcon toggle">
            </div>
            <ul class="navMenu flex">
                <li class="hover:tracking-widest">
                    <a href="{{ route('artisans.list') }}" class="underline-none hover:underline-offset-8 hover:underline font-medium text-sm text-slate-800">
                        Artisans
                    </a>
                </li>                <li class="hover:tracking-widest"><a href="{{route('products.list')}}" class="underline-none hover:underline-offset-8 hover:underline font-medium text-sm text-slate-800">Shop</a></li>
                <li class="hover:tracking-widest"><a href="#" class="underline-none hover:underline-offset-8 hover:underline font-medium text-sm text-slate-800">Contact</a></li>
            </ul>
            @guest
            <div class="btn-group">
                <a href="{{ route('login') }}"></a><button class="px-4 py-3 bg-transparent rounded-xl hover:shadow-lg hover:tracking-widest" onclick="window.location='{{ route("login") }}'">Login</button></a>
                <a href="{{ route('register') }}"></a><button class="px-4 py-3 bg-transparent rounded-xl hover:shadow-lg hover:tracking-widest border-gray-900 border text-gray-900 hover:bg-gray-900 hover:text-white" onclick="window.location='{{ route("register") }}'">Register</button>
            </div>
            @endguest
            <div x-data="{ open: false }" class="btn-group relative">
                <!-- Display buttons based on user_type for authenticated users -->
                @auth
                <button name="notifications"> <i class='bx bxs-bell' ></i></button>
                
    <button @click="open = !open" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 " name="userbutton">
        {{ Auth::user()->name }}
    </button>

    <!-- Dropdown menu for profile and logout -->
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
        @if(Auth::user()->user_type == 0)
            <a href="{{ route('artisan') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Dashboard</a>
        @endif
        @if(Auth::user()->user_type == 1)
            <a href="{{ route('livreur') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Dashboard</a>
        @endif
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</button>
        </form>



    
    
    

    </div>

@endauth

        </nav>
    </header>
      <!-- Gradient Background -->
<div class="blob w-[800px] h-[800px] rounded-[999px] absolute top-0 right-0 -z-10 blur-3xl bg-opacity-80 bg-gradient-to-r from-purple-500 via-indigo-500 to-pink-500"></div>
<div class="blob w-[1000px] h-[1000px] rounded-[999px] absolute bottom-0 left-0 -z-10 blur-3xl bg-opacity-80 bg-gradient-to-r from-red-500 via-gray-300 to-blue-300"></div>
<div class="blob w-[600px] h-[600px] rounded-[999px] absolute bottom-0 left-0 -z-10 blur-3xl bg-opacity-80 bg-gradient-to-r from-slate-300 via-teal-300 to-blue-300"></div>
<div class="blob w-[300px] h-[300px] rounded-[999px] absolute bottom-[-10px] left-0 -z-10 blur-3xl bg-opacity-80 bg-gradient-to-r from-green-500 via-cyan-500 to-fuchsia-500"></div>
    @yield('main')
</body>
</html>