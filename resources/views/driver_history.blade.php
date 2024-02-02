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
            @foreach ($assignedOrders as $order)
                    <tr class="bg-white border-b">
                        <!-- Your order details here -->
                        <td scope="col" class="px-6 py-3">{{ $order->product->name }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->user->phone }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->product->category }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->total_price }} da</td>
                        <td scope="col" class="px-6 py-3">{{ $order->user->adresse }}</td>
                        <td scope="col" class="px-6 py-3">{{ $order->total_price *0.35 }} da</td>
                        <td scope="col" class="px-6 py-3">{{$order->created_at}}
                        </td>
                    </tr>
                </form>
            @endforeach
        @endauth
    </tbody>
</table>
@endsection