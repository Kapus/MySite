<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kapus</title>
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
            background: transparent;
            color: #e0e0ff;
            border: none;
            box-shadow: 0 8px 32px 0 rgba(45,49,250,0.25), 0 2px 8px 0 rgba(90,24,154,0.18), 0 1.5px 8px 0 #000;
            margin-bottom: 2rem;
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
            <a class="navbar-brand" href="index.php">Kapus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
                    <li class="nav-item">
                        <a class="nav-link" href="leaderboard.php">Leaderboard</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link p-0 me-2" href="profile.php" title="Profile"><i class="bi bi-person-circle fs-5"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
