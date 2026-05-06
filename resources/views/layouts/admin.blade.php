<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Blog Management</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
        }
        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: #fff;
            padding-top: 20px;
        }
        .sidebar a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            transition: all 0.3s ease;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #1abc9c;
            color: #fff;
        }
        .main-content {
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="text-center mb-4">
                    <h4 class="font-weight-bold m-0 text-white">Jobs Yaari</h4>
                    <small class="text-success">&bull; Online</small>
                </div>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.headlines.*') ? 'active' : '' }}" href="{{ route('admin.headlines.index') }}">Headlines</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.help_videos.*') ? 'active' : '' }}" href="{{ route('admin.help_videos.index') }}">Help Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-info" data-bs-toggle="collapse" href="#manageBlogMenu" role="button" aria-expanded="{{ request()->routeIs('admin.blogs.*', 'admin.categories.*', 'admin.tags.*') ? 'true' : 'false' }}" aria-controls="manageBlogMenu">
                            $ Manage Blog
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.blogs.*', 'admin.categories.*', 'admin.tags.*') ? 'show' : '' }}" id="manageBlogMenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link py-1 {{ request()->routeIs('admin.blogs.*') ? 'active text-primary' : '' }}" href="{{ route('admin.blogs.index') }}">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-1 {{ request()->routeIs('admin.categories.*') ? 'active text-primary' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-1 {{ request()->routeIs('admin.tags.*') ? 'active text-primary' : '' }}" href="{{ route('admin.tags.index') }}">Tags</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mt-4 border-top pt-2 border-secondary">
                        <a class="nav-link text-warning" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') ?? '#' }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ml-sm-auto px-4 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    @stack('scripts')
</body>
</html>
