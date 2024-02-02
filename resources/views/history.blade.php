@extends('home') 
@section('main')
   <!-- Sidenav -->
   <div class="sidenav">
    <div class="profile">
        <img src="{{ asset('storage/' . (Auth::user()->profile_picture ? Auth::user()->profile_picture : 'defaultpfp.jpg')) }}" alt="Profile Picture" width="100" height="100">

        <div class="name">
            {{ $user->name }}
        </div>
        <div class="job">
            @if( $user->user_type==0 )
            Artisan
            @endif
            @if( $user->user_type==1 )
            Livreur
            @endif
            @if( $user->user_type==2 )
            Client
            @endif
        </div>
    </div>

    <div class="sidenav-url">
        <div class="url">
            <a href="#profile" class="active">Profile</a>
            <hr align="center">
        </div>
        <div class="url">
            <a href="{{ route('profile.edit') }}">update</a>
            <hr align="center">
        </div>
        <div class="url">
            <a href="">history</a>
            <hr align="center">
        </div>
    </div>
</div>
<!-- End -->

<!-- Main -->
<div class="main">
    <h2>history</h2>
    <div class="card">
        <div class="card-body">
            <i class="fa fa-pen fa-xs edit"></i>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-5">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                           Order id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            product name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            total price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            status
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
        </div>
    </div>
@endsection
