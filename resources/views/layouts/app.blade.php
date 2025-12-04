<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #222831;
            --secondary-color: #393E46;
            --accent-color: #00ADB5;
            --light-color: #EEEEEE;
            --text-primary: #222831;
            --text-secondary: #393E46;
            --border-color: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #eeeeee 100%);
            color: var(--text-primary);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-bottom: 3px solid var(--accent-color);
            padding: 1rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--light-color) !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            margin-right: 0.75rem;
            color: var(--accent-color);
            font-size: 1.6rem;
        }

        .nav-link {
            color: #ccc !important;
            font-weight: 600;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.25rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
            background-color: rgba(0, 173, 181, 0.1);
        }

        .nav-link i {
            margin-right: 0.5rem;
        }

        /* Main Container */
        main {
            flex: 1;
            padding: 2rem 0;
        }

        .container {
            max-width: 1200px;
        }

        /* Alerts */
        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background-color: #ecfdf5;
            border-color: #10b981;
            color: #047857;
        }

        .alert-danger {
            background-color: #fef2f2;
            border-color: #ef4444;
            color: #dc2626;
        }

        .alert i {
            margin-right: 0.75rem;
        }

        /* Buttons */
        .btn {
            font-weight: 700;
            border-radius: 6px;
            padding: 0.625rem 1.25rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--light-color);
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 173, 181, 0.3);
        }

        .btn-success {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #009099;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 173, 181, 0.4);
        }

        .btn-info {
            background-color: #0891b2;
            color: white;
        }

        .btn-info:hover {
            background-color: #0e7490;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3);
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-lg {
            padding: 0.75rem 2rem;
            font-size: 1rem;
        }

        .btn-sm {
            padding: 0.4rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Forms */
        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 6px;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 173, 181, 0.1);
        }

        .form-label {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 173, 181, 0.15);
            border-color: var(--accent-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--light-color);
            border: none;
        }

        .table thead th {
            font-weight: 700;
            padding: 1.2rem;
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 173, 181, 0.05);
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        /* Badges */
        .badge {
            font-weight: 700;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .badge-success {
            background-color: #10b981;
            color: white;
        }

        .badge-warning {
            background-color: #f59e0b;
            color: white;
        }

        .badge-danger {
            background-color: #ef4444;
            color: white;
        }

        .badge-info {
            background-color: var(--accent-color);
            color: white;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--accent-color);
        }

        .page-header h1 {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 8px;
            border: 2px dashed var(--accent-color);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
            opacity: 0.6;
        }

        .empty-state h3 {
            color: var(--primary-color);
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-top: 3px solid var(--accent-color);
            padding: 2rem 0;
            margin-top: auto;
        }

        footer p {
            color: var(--light-color);
            margin: 0;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 1.5rem;
            }

            main {
                padding: 1rem 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-book-half"></i> BookManager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/books">
                            <i class="bi bi-collection"></i> Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/borrowings">
                            <i class="bi bi-arrow-left-right"></i> Borrowings
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <strong>Success!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>&copy; 2025 Book Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>