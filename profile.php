<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'includes/header.php';
include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT username, email, created_at FROM users WHERE id = :id');
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<main class="container my-5">
    <div class="row align-items-start">
        <div class="col-md-3">
            <div class="card shadow h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h3 class="card-title mb-4 display-4" style="font-size:2.2rem;">Profile</h3>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item" style="background: transparent;">Username: <?php echo htmlspecialchars($user['username']); ?></li>
                        <li class="list-group-item" style="background: transparent;">Email: <?php echo htmlspecialchars($user['email']); ?></li>
                        <li class="list-group-item" style="background: transparent;">Member since: <?php echo date('Y-m-d', strtotime($user['created_at'])); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 d-none d-md-flex align-items-center">
            <div class="w-100 ps-md-5">
                <!-- Right side content (optional) -->
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
