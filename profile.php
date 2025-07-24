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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item bg-dark text-light">Email: <?php echo htmlspecialchars($user['email']); ?></li>
                        <li class="list-group-item bg-dark text-light">Member since: <?php echo htmlspecialchars($user['created_at']); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
