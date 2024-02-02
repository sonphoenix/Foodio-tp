<!-- artisan_card.blade.php -->

<div class="flex items-center h-screen w-full justify-center">
    <div class="max-w-xs">
        <div class="bg-white shadow-xl rounded-lg py-3">
            <div class="photo-wrapper p-2">
                <!-- Display Artisan's Logo -->
                <img class="w-32 h-32 rounded-full mx-auto" src="{{ asset($businessLogo) }}" alt="{{ $creator }}">
            </div>
            <div class="p-2">
                <!-- Display Artisan's Name -->
                <h3 class="text-center text-xl text-gray-900 font-medium leading-8">{{ $creator }}</h3>
                <div class="text-center text-gray-400 text-xs font-semibold">
                    <p>Artisan</p>
                </div>
                <table class="text-xs my-3">
                    <tbody>
                        <!-- Display Artisan's Rating -->
                        <tr>
                            <td class="px-2 py-2 text-gray-500 font-semibold">Rating</td>
                            <td class="px-2 py-2">{{ $rating }}</td>
                        </tr>
                        <!-- Display Artisan's Location -->
                        <tr>
                            <td class="px-2 py-2 text-gray-500 font-semibold">Location</td>
                            <td class="px-2 py-2">{{ $location }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center my-3">
                    <!-- Add a link to view the artisan's profile -->
                    <a class="text-xs text-indigo-500 italic hover:underline hover:text-indigo-600 font-medium" href="{{ route('artisan.show_business_profile_picture', $id) }}">View Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
