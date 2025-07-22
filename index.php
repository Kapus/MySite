<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Site</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            background: #18122B;
            color: #e0e0ff;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #18122B 0%, #2D31FA 100%);
        }
        main {
            flex: 1;
        }
        .display-4 {
            text-shadow:
                0 8px 32px #2D31FA,
                0 4px 16px #5A189A,
                0 2px 8px #A5D7E8,
                0 1px 2px #000,
                0 0 24px #000;
        }
        .navbar {
            background: linear-gradient(90deg, #5A189A 0%, #2D31FA 100%) !important;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #e0e0ff !important;
        }
        .navbar-nav .nav-link.active {
            color: #A5D7E8 !important;
        }
        .btn-primary {
            background: linear-gradient(90deg, #5A189A 0%, #2D31FA 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #2D31FA 0%, #5A189A 100%);
        }
        .footer {
            background: linear-gradient(90deg, #5A189A 0%, #2D31FA 100%) !important;
            color: #e0e0ff !important;
        }
        .footer a {
            color: #A5D7E8 !important;
        }
        .footer h5, .footer h6 {
            color: #A5D7E8 !important;
        }
        .card {
            background: #18122B;
            color: #e0e0ff;
            border: 1px solid #5A189A;
        }
        .list-group-item {
            background: #18122B;
            color: #e0e0ff;
            border: none;
        }
        hr {
            border-top: 1px solid #5A189A;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Kapus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4">Welcome to Kapus</h1>
                <p class="lead">This is a sample page with Bootstrap navbar and footer.</p>
                <hr class="my-4">
                <p>You can customize this content as needed. This template includes a responsive navigation bar and a footer using Bootstrap 5.</p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Kapus</h5>
                    <p class="mb-0">Building amazing web experiences since 2025.</p>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-light text-decoration-none">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Services</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Follow Us</h6>
                    <div class="d-flex align-items-center" style="gap: 1rem;">
                        <a href="#" class="text-light fs-3" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="text-light fs-3" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="text-light fs-3" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Kapus. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-light text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
