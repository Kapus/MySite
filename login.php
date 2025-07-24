<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: profile.php');
        exit();
    } else {
        echo '<div class="alert alert-danger">Invalid username or password.</div>';
    }
}
?>

    <main class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="row align-items-start">
                    <div class="col-md-3">
                        <div class="card shadow h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h3 class="card-title mb-4 display-4" style="font-size:2.2rem;">Login</h3>
                                <form method="post" action="#">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </form>
                                <div class="mt-3 text-center">
                                    <a href="register.php" class="text-light">Don't have an account? Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 d-none d-md-flex align-items-center">
                        <div class="w-100 ps-md-5">
                            <h2 class="display-6 mb-3">Create Your Account</h2>
                            <p class="lead">Register to join Kapus and unlock exclusive features. Already have an account? Login to access your dashboard and more.</p>
                            <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque euismod, nisi eu consectetur consectetur, nisl nisi consectetur nisi, euismod euismod nisi nisi euismod. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi. Duis aliquet egestas purus in blandit. Curabitur vulputate, ligula lacinia scelerisque tempor, lacus lacus ornare ante, ac egestas est urna sit amet arcu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php'; ?>
