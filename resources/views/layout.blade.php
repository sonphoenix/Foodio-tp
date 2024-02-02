
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ======== Main wrapper for dashboard =========== -->

    <div class="wrapper">
        <!-- =========== Sidebar for admin dashboard =========== -->

        <aside id="sidebar" class="js-sidebar">

            <!-- ======== Content For Sidebar ========-->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#" class="">@yield('title2')</a>
                    @yield('sidebar')
                </div>


                <!-- ======= Navigation links for sidebar ======== -->
                <ul class="sidebar-nav">



                </ul>
            </div>
        </aside>

        <!-- ========= Main section of dashboard ======= -->

        <div class="main">

            <!-- ========= Main navbar section of dashboard ======= -->

            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" class="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li>
                            <button class="btn">
                                notifications
                            </button>
                        </li>
                        <li class="navitem dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="image/avatar.png" class="avatar img-fluid rounded">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">profile</a>
                                <a href="#" class="dropdown-item">settings</a>
                                <a href="#" class="dropdown-item">logout</a>
                            </div>
                        </li>
                    </ul>

                </div>

            </nav>

            <!-- ========= Main content section of dashboard ======= -->

            <main class="content px-3 py-2">
                @yield('main')
            </main>

            <!-- ========= light and dark mode toggle button ======= -->

            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>

            <footer class="footer">
                <div class="container">
                    <p>&copy; 2023 my project all rights are reserved</p>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
