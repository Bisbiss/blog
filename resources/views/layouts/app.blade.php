<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Syaifulloh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            color: #333;
            padding-top: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .card {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: background-color 0.3s ease;
        }
        [data-bs-theme="dark"] body {
            background: #121212;
            color: #f0f0f0;
        }
        [data-bs-theme="dark"] .navbar {
            background-color: #1e1e1e !important;
        }
        [data-bs-theme="dark"] .navbar-light .navbar-brand,
        [data-bs-theme="dark"] .navbar-light .nav-link {
            color: #f0f0f0;
        }
        [data-bs-theme="dark"] .card {
            background-color: #2d2d2d;
            color: #f0f0f0;
        }
        .theme-icon {
            font-size: 1.2rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="/">Syaifulloh Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/posts">Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact Us</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div id="themeToggle" class="ms-3">
                        <i class="bi bi-sun-fill theme-icon" id="lightIcon"></i>
                        <i class="bi bi-moon-fill theme-icon d-none" id="darkIcon"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark mode toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const lightIcon = document.getElementById('lightIcon');
            const darkIcon = document.getElementById('darkIcon');
            const htmlElement = document.documentElement;
            
            // Check for saved theme preference or use default
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                lightIcon.classList.add('d-none');
                darkIcon.classList.remove('d-none');
            }
            
            // Toggle theme
            themeToggle.addEventListener('click', function() {
                if (htmlElement.getAttribute('data-bs-theme') === 'dark') {
                    htmlElement.setAttribute('data-bs-theme', 'light');
                    lightIcon.classList.remove('d-none');
                    darkIcon.classList.add('d-none');
                    localStorage.setItem('theme', 'light');
                } else {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    lightIcon.classList.add('d-none');
                    darkIcon.classList.remove('d-none');
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    </script>
</body>
</html>