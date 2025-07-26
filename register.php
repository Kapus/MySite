<?php
session_start();
include 'includes/db.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    if (!$username || !$email || !$password || !$confirm) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $email]);
        if ($stmt->fetch()) {
            $error = 'Username or email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
            $insert->execute(['username' => $username, 'email' => $email, 'password' => $hash]);
            $success = 'Registration successful! You can now log in.';
        }
    }
}
include 'includes/header.php';
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-3">
            <div class="card shadow-lg rounded-4 p-4">
                <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Register</h3>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger text-center"> <?= htmlspecialchars($error) ?> </div>
                <?php elseif (!empty($success)): ?>
                    <div class="alert alert-success text-center"> <?= htmlspecialchars($success) ?> </div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm" name="confirm" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                
            </div>
        </div>
        <div class="col-12 col-md-9 d-flex align-items-start">
            <div class="w-100">
                <div>
                    <h3 class="card-title mb-4 display-4 text-center pb-4" style="font-size:2.2rem;">Welcome to Kapus!</h3>
                    <p class="mt-3" style="font-size:1.1rem;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam euismod, urna eu tincidunt consectetur, nisi nisl aliquam enim, euismod tincidunt nisi nisi euismod enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
