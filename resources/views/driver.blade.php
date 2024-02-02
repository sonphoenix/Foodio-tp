@extends('layoute')
@section('sidebar')
<ul>
    <li>
        <a href="#">
            <span class="icon">
                <ion-icon name="logo-apple"></ion-icon>
            </span>
            <span class="title ">Foodio</span>
        </a>
    </li>

    <li>
        <a href="/driver">
            <span class="icon">
                <ion-icon name="home-outline"></ion-icon>
            </span>
            <span class="title">Dashboard</span>
        </a>
    </li>




    <li>
        <a href="{{route('livreur.working-hours')}}">
            <span class="icon">
                <ion-icon name="settings-outline"></ion-icon>
            </span>
            <span class="title">work time</span>
        </a>
    </li>

    <li>
        <a href="{{route('livreur.edit-working-hours')}}">
            <span class="icon">
                <ion-icon name="settings-outline"></ion-icon>
            </span>
            <span class="title">edit work time</span>
        </a>
    </li>

    <li>
        <a href="/history">
            <span class="icon">
                <ion-icon name="lock-closed-outline"></ion-icon>
            </span>
            <span class="title">history</span>
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
@endsection
@section('main')
<ul class="box-info">
    
    <li class="border border-gray-300 rounded p-4 m-2">
        <i class='bx bxs-calendar-check'></i>
        <span class="text">
            <h3>{{$totalc}}</h3>
            <p>commands done</p>
        </span>
    </li>
    <li class="border border-gray-300 rounded p-4 m-2">
        <i class='bx bxs-group'></i>
        <span class="text">
            <h3>{{$totali}}</h3>
            <p>incoming requests</p>
        </span>
    </li>
    <li class="border border-gray-300 rounded p-4 m-2">
        <i class='bx bxs-dollar-circle'></i>
        <span class="text">
            <h3>{{$totalIncome}} DA</h3>
            <p>Total Income</p>
        </span>
    </li>
</ul>



<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <h3 class="text-center ">Recent Commands</h3>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
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
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- Check if the user is authenticated before accessing orders -->
            @auth
                @foreach ($assignedOrders as $order)
                    <form action="{{ route('livreur.updateOrderStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <tr class="bg-white border-b">
                            <!-- Your order details here -->
                            <td scope="col" class="px-6 py-3">{{ $order->product->name }}</td>
                            <td scope="col" class="px-6 py-3">{{ $order->user->name }}</td>
                            <td scope="col" class="px-6 py-3">{{ $order->product->category }}</td>
                            <td scope="col" class="px-6 py-3">${{ number_format($order->product->price, 2) }}</td>
                            <td scope="col" class="px-6 py-3">{{ $order->user->adresse }}</td>
                            <td scope="col" class="px-6 py-3">{{ $order->status }}</td>
                            <td scope="col" class="px-6 py-3">
                                <select name="livreur_action" id="livreurSelect">
                                    <option value="accept">Accept</option>
                                    <option value="refuse">Refuse</option>
                                </select>
                            </td>
                            <td scope="col" class="px-6 py-3">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Send
                                </button>
                            </td>
                        </tr>
                    </form>
                @endforeach
            @endauth
        </tbody>
    </table>
</div>

@endsection
