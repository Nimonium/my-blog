<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Blog System</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6366F1;
            --primary-hover: #4F46E5;
            --secondary-color: #A855F7;
            --bg-color: #F8FAFC;
            --surface-color: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --glass-bg: rgba(255, 255, 255, 0.85);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        /* Premium Navbar */
        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 1rem 0;
        }
        .navbar-brand {
            font-size: 1.75rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        
        .nav-link {
            font-weight: 600;
            color: var(--text-muted);
            margin-left: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }

        /* Sidebar Widgets */
        .sidebar-widget {
            background: var(--surface-color);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease;
        }

        .sidebar-widget:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px -10px rgba(0, 0, 0, 0.06);
        }

        .sidebar-widget h4 {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: var(--text-main);
            display: flex;
            align-items: center;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .category-link {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            padding: 10px 16px;
            border-radius: 12px;
            background: var(--bg-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid transparent;
        }

        .category-link:hover, .category-link.active {
            background: #EEF2FF;
            color: var(--primary-color);
            border-color: #E0E7FF;
            transform: translateX(4px);
        }

        .category-link::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 8px;
            background: var(--secondary-color);
            border-radius: 50%;
            margin-right: 12px;
            opacity: 0.5;
            transition: all 0.3s;
        }

        .category-link:hover::before, .category-link.active::before {
            opacity: 1;
            transform: scale(1.2);
            background: var(--primary-color);
        }

        /* Search Box */
        .search-container {
            position: relative;
        }
        .search-input {
            border-radius: 50px;
            padding: 14px 20px 14px 45px;
            border: 2px solid #E2E8F0;
            background: #F8FAFC;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .search-input:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }
        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
        }

        /* Stunning Blog Cards */
        .blog-card {
            background: var(--surface-color);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -5px rgba(99, 102, 241, 0.15);
        }

        .blog-img-container {
            width: 100%;
            height: 240px;
            overflow: hidden;
            position: relative;
        }

        .blog-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .blog-card:hover img {
            transform: scale(1.08);
        }
        
        .category-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--glass-bg);
            backdrop-filter: blur(8px);
            color: var(--primary-color);
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .blog-content {
            padding: 28px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .blog-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 14px;
            color: var(--text-main);
            text-decoration: none;
            line-height: 1.4;
            transition: color 0.3s ease;
            font-family: 'Outfit', sans-serif;
        }

        .blog-title:hover {
            color: var(--primary-color);
        }

        .blog-excerpt {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 24px;
            flex-grow: 1;
        }

        .blog-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            border-top: 1px solid #F1F5F9;
            padding-top: 20px;
        }

        .read-more {
            background: #EEF2FF;
            color: var(--primary-hover);
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .blog-date {
            font-size: 0.85rem;
            color: #94A3B8;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Detail Page Styling */
        .blog-detail-header {
            margin-bottom: 40px;
            text-align: center;
        }
        .blog-detail-img {
            width: 100%;
            max-height: 550px;
            object-fit: cover;
            border-radius: 24px;
            margin-bottom: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        
        .blog-detail-content {
            background: var(--surface-color);
            padding: 50px;
            border-radius: 24px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
            font-size: 1.15rem;
            line-height: 1.9;
            color: #334155;
        }

        /* Loader */
        #loader {
            display: none;
            text-align: center;
            padding: 40px;
        }
        
        /* Headline Ticker */
        .headlines-ticker {
            background: linear-gradient(90deg, #1e1b4b, #312e81);
            color: white;
            padding: 10px 0;
            border-bottom: 2px solid var(--primary-color);
            position: relative;
            z-index: 999;
        }
        
        .ticker-wrapper {
            white-space: nowrap;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        
        .ticker-content {
            display: inline-block;
            padding-left: 100%;
            animation: ticker 30s linear infinite;
        }

        .ticker-content:hover {
            animation-play-state: paused;
        }

        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        .pulse-badge {
            animation: pulse 2s infinite;
            background-color: #ef4444;
            color: white;
            font-weight: 800;
            letter-spacing: 1px;
            padding: 6px 16px;
            border-radius: 50px;
            text-transform: uppercase;
            font-size: 0.8rem;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
            margin-right: 20px;
            z-index: 2;
            position: relative;
        }

        @keyframes pulse {
            0% { opacity: 1; box-shadow: 0 0 15px rgba(239, 68, 68, 0.5); }
            50% { opacity: 0.8; box-shadow: 0 0 5px rgba(239, 68, 68, 0.2); }
            100% { opacity: 1; box-shadow: 0 0 15px rgba(239, 68, 68, 0.5); }
        }

        .headline-link {
            color: #f8fafc;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .headline-link:hover {
            color: #818cf8;
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background: var(--surface-color);
            border-top: 1px solid var(--border-color);
            padding: 40px 0;
            margin-top: 80px;
            text-align: center;
            color: var(--text-muted);
            font-weight: 500;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">NovaBlog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#blogs">Blogs</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @if(isset($headlines) && $headlines->count() > 0)
    <div class="headlines-ticker">
        <div class="container d-flex align-items-center">
            <span class="pulse-badge">Breaking</span>
            <div class="ticker-wrapper flex-grow-1">
                <div class="ticker-content">
                    @foreach($headlines as $headline)
                        <span class="me-5">
                            @if($headline->url)
                                <a href="{{ $headline->url }}" class="headline-link" target="_blank">{{ $headline->title }}</a>
                            @else
                                <span class="text-white fw-medium">{{ $headline->title }}</span>
                            @endif
                            <span class="ms-5" style="color: var(--secondary-color); opacity: 0.5;">&bull;</span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="container my-5" id="main-container">
        @yield('content')
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} NovaBlog. Designed for excellence. All rights reserved.</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
