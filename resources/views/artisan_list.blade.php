<!-- artisan_list.blade.php -->

@extends('home')

@section('main')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="flex">
        <!-- Sidebar -->
        <div class="h-screen w-1/5 p-4 border">
            <!-- Add your filtering options here -->
            <h2 class="text-lg font-semibold mb-4 text-center">Filter Options</h2>
            <div>
                <!-- Rating filter -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <input id="ratingFilter" type="number" placeholder="Enter rating" class="mt-1 p-2 border rounded-md w-full">
                </div>

                <!-- Filter button -->
                <div class="mb-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="filterArtisans()">Filter</button>
                </div>
            </div>
        </div>

        <!-- Artisan List Content -->
        <div class="flex-1 p-4">
            <!-- Add your artisan list content here -->
            <h2 class="text-2xl font-semibold mb-4 text-center mb-5">Artisan List</h2>

            <!-- Search bar -->

                <label for="artisan-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="artisan-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search." required>
                    <button onclick="filterArtisans()" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>


            <!-- Artisan list container -->
            <div id="artisanListContainer" class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4">
                @foreach($artisans as $artisan)
                    @php
                        // Assuming you have a relationship defined in the Artisan model to get the associated user
                        $user = $artisan->user;
                        $businessLogo = $artisan->business_logo ? asset('storage/' . $artisan->business_logo) : asset('storage/default_logo.jpg');
                    @endphp

                    @component('components.artisan_card', [
                        'creator' => $artisan->business_name,
                        'businessLogo' => $businessLogo,
                        'rating' => number_format($artisan->calculateAverageRating($artisan->user_id), 2), // Assuming you have a method to get average rating
                        'location' => $artisan->location,
                        'id'=>$artisan->user_id,
                    ])
                    @endcomponent

                @endforeach
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function filterArtisans() {
            // Get filter values
            var rating = $('#ratingFilter').val();
            var searchQuery = $('#artisan-search').val();

            // Send Ajax request
            $.ajax({
                url: "{{ route('artisans.filter') }}",
                method: 'POST',
                data: {
                    rating: rating,
                    searchQuery: searchQuery,
                },
                dataType: 'json',  // Specify JSON dataType
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
// JavaScript success code
success: function(response) {
    console.log(response.artisans);

    // Clear existing artisans
    $('#artisanListContainer').empty();

    // Check if response has artisans property and it is an object
    if (response.artisans && typeof response.artisans === 'object') {
        // Loop through each property in the artisans object
        for (const key in response.artisans) {
            if (Object.hasOwnProperty.call(response.artisans, key)) {
                const artisan = response.artisans[key];
var businessLogo = artisan.business_logo ? "{{ asset('storage/') }}" + '/' + artisan.business_logo : "{{ asset('storage/default_logo.jpg') }}";

                var artisanCard = `
                <div class="flex items-center h-screen w-full justify-center">
                    <div class="max-w-xs bg-white shadow-xl rounded-lg py-3">
                        <div class="photo-wrapper p-2">
                            <img class="w-32 h-32 rounded-full mx-auto" src="${businessLogo}" alt="${artisan.business_name}">
                        </div>
                        <div class="p-2">
                            <h3 class="text-center text-xl text-gray-900 font-medium leading-8">${artisan.business_name}</h3>
                            <div class="text-center text-gray-400 text-xs font-semibold">
                                <p>Artisan</p>
                            </div>
                            <table class="text-xs my-3">
                                <tbody>
                                    <tr>
                                        <td class="px-2 py-2 text-gray-500 font-semibold">Rating :</td>
                                        <td class="px-2 py-2">${artisan.calculatedRating}</td>

                                    </tr>
                                    <tr>
                                        <td class="px-2 py-2 text-gray-500 font-semibold">Location :</td>
                                        <td class="px-2 py-2">${artisan.location}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center my-3">
                                <a class="text-xs text-indigo-500 italic hover:underline hover:text-indigo-600 font-medium" href="/business-profile-picture/${artisan.id}">View Profile</a>
                            </div>
                        </div>
                    </div>
                    </div>
                `;

                // Append the artisan card to the container
                $('#artisanListContainer').append(artisanCard);
            }
        }
    }
},



                error: function(error) {
                    console.error(error.responseText);
                }
            });
        }
    </script>
@endsection
