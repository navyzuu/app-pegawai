<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App Pegawai')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-container">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <i class="fas fa-users"></i>
                    <span>App Pegawai</span>
                </a>
                <ul class="navbar-nav">
                    <li><a href="{{ url('/employees') }}" class="nav-link">
                            <i class="fas fa-user-friends"></i>
                            <span>Employees</span>
                        </a></li>
                    <li><a href="{{ url('/departments') }}" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Departments</span>
                        </a></li>
                    <li><a href="{{ url('/attendance') }}" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Attendance</span>
                        </a></li>
                    <li><a href="{{ url('/salaries') }}" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Salaries</span>
                        </a></li>
                    <li><a href="{{ url('/report') }}" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a></li>
                    <li><a href="{{ url('/settings') }}" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="content-wrapper">
        <div class="page-header">
            <div class="container">
                <div class="page-header-content">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-description">@yield('page-description', 'Manage your employee data')</p>
                </div>
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} App Pegawai. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>