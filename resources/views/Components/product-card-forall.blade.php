<!-- resources/views/components/product-card.blade.php -->

<div class="relative m-4 flex-none w-full max-w-xs sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
    <a class="relative mx-3 mt-3 flex overflow-hidden rounded-t-xl rounded-b-none" href="#" style="height: 200px;">
        <img class="object-cover w-full h-full rounded-t-xl" src="{{ $image }}" alt="product image" />
        <span class="absolute top-0 left-0 m-2 rounded-full bg-black px-2 text-center text-sm font-medium text-white">{{ $category . ' - ' . $sub_category }}</span>
    </a>
    <div class="mt-4 px-5 pb-5 rounded-b-xl">
        <a href="#">
            <h5 class="text-xl tracking-tight text-slate-900">{{ $title }}</h5>
        </a>
        <p class="text-sm text-gray-500">Created by: {{ $creator }}</p>
        <div class="mt-2 mb-5 flex items-center justify-between">
            <p>
                <span class="text-3xl font-bold text-slate-900">{{ $price }} DA</span>
            </p>
            <div class="flex items-center">
                @for ($i = 0; $i < $rating; $i++)
                    <svg aria-hidden="true" class="h-5 w-5 text-yellow-300" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.810l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                @endfor
                <span class="mr-2 ml-3 rounded bg-yellow-200 px-2.5 py-0.5 text-xs font-semibold">{{ $rating }}</span>
            </div>
        </div>
        <a href="{{ route('product.details', ['id' =>$id])}}" class="flex items-center justify-center rounded-md bg-slate-900 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            See the product
            </a>
    </div>
</div>
