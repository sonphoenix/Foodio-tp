@extends('home')
@section('main')
    <!-- Hero Section -->
    <div class="content relative w-full flex justify-center py-0 px-[60px]">
        <div class="textBox relative max-w-[800px]">
            <h1 class="text-slate-900 text-9xl fot-medium">Spice Up to <br>Mood Up</h1>
            <p class="text-slate-800 text-7xl font-normal">With our Food</p>
            <div class="btn-group mt-10">
                <a href="#" class="px-6 py-5 mt-10 bg-transparent border-gray-900 border rounded-2xl text-white bg-gray-900 hover:tracking-widest">shop</a>
            </div>
        </div>
        <div class="imgBox">
            <div class="imgSlider">
                <img src="image/plate2.png" alt="" class="imgBlock" id="foodimg">
                <div class="controls flex w-30 justify-center">
                  <button id="dot1" class="dot1 m-2 cursor-pointer  bg-gray-700 rounded-2xl w-5 h-5" onclick="im1()"></button>
                  <button  id ="dot2" class="dot2 m-2 cursor-pointer  bg-gray-700 rounded-2xl w-5 h-5" onclick="im2()"></button>
                  <button id="dot3" class="dot3 m-2 cursor-pointer  bg-gray-700 rounded-2xl w-5 h-5" onclick="im3()"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Gradient Background -->
    <div class="blob w-[800px] h-[800px] rounded-[999px] absolute top-0 right-0 -z-10 blur-3xl bg-opacity-60 bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200"></div>
    <div class="blob w-[1000px] h-[1000px] rounded-[999px] absolute bottom-0 left-0 -z-10 blur-3xl bg-opacity-60 bg-gradient-to-r from-red-200 via-gray-100 to-blue-100"></div>
    <div class="blob w-[600px] h-[600px] rounded-[999px] absolute bottom-0 left-0 -z-10 blur-3xl bg-opacity-60 bg-gradient-to-r from-slate-100 via-teal-100 to-blue-100"></div>
    <div class="blob w-[300px] h-[300px] rounded-[999px] absolute bottom-[-10px] left-0 -z-10 blur-3xl bg-opacity-60 bg-gradient-to-r from-green-200 via-cyan-200 to-Fuchsia-300"></div>
    <script src="js/script.js"></script>   
@endsection