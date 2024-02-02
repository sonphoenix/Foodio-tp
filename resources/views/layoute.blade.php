<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>artisan / driver side</title>

    <!-- ======= Styles ====== -->
    @vite('resources/css/app.css')
     <link rel="stylesheet" href="{{asset('css/style2.css')}}">
     <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
     <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
     <script src="{{asset('js/main.js')}}"></script>

</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">  
        <div class="navigation">    
            @yield('sidebar')
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="{{ asset('storage/' . (Auth::user()->profile_picture ? Auth::user()->profile_picture : 'defaultpfp.jpg')) }}" alt="Profile Picture" width="100" height="100">
                </div>
            </div>
            @yield('main')




    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>