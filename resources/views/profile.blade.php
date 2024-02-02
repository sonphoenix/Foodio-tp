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
            <a href="/profile_history">history</a>
            <hr align="center">
        </div>
    </div>
</div>
<!-- End -->

<!-- Main -->
<div class="main">
    <h2>IDENTITY</h2>
    <div class="card">
        <div class="card-body">
            <i class="fa fa-pen fa-xs edit"></i>
            <table>
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td>{{ $user->adresse }}</td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>:</td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td>********</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
