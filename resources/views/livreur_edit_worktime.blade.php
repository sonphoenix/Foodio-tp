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
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-semibold mb-4 text-center">Edit Livreur Working Hours</h1>

    <!-- Livreur Working Hours Form -->
    <form action="{{ route('livreur.update-working-hours') }}" method="post" class="max-w-md mx-auto">
        @csrf
        @method('PUT') <!-- Use PUT method for updates -->

        <!-- Display Current Working Hours -->
        <div class="mb-4">
            <p class="block text-sm font-medium text-gray-600">Current Working Hours</p>
            <p>Start Time: {{ $livreur->start_work_time }}</p>
            <p>End Time: {{ $livreur->end_work_time }}</p>
        </div>

        <!-- Start Working Time (Allow user to update) -->
        <div class="mb-4">
            <label for="start_work_time" class="block text-sm font-medium text-gray-600">New Start Working Time</label>
            <input type="time" id="start_work_time" name="start_work_time" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <!-- End Working Time (Allow user to update) -->
        <div class="mb-4">
            <label for="end_work_time" class="block text-sm font-medium text-gray-600">New End Working Time</label>
            <input type="time" id="end_work_time" name="end_work_time" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <!-- Submit Button -->
        <div class="mb-6">
            <button type="submit"
                    class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                Save Updated Working Hours
            </button>
        </div>
    </form>
</div>
@endsection
