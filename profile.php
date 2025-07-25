<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'includes/header.php';
include 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT username, email, created_at FROM users WHERE id = :id');
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch Flappy top score for this user
$score_stmt = $pdo->prepare('SELECT MAX(score) AS top_score FROM flappy WHERE user_id = :user_id');
$score_stmt->execute(['user_id' => $user_id]);
$score_row = $score_stmt->fetch(PDO::FETCH_ASSOC);
$flappy_top_score = $score_row && $score_row['top_score'] !== null ? $score_row['top_score'] : 0;
?>
<main class="container my-5">
    <div class="row align-items-start">
        <div class="col-12 col-md-3">
            <div class="card shadow-lg rounded-4 h-100 mb-4">
                <div class="card-body d-flex flex-column justify-content-center p-4">
                    <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Profile</h3>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item" style="background: transparent;">Username: <?php echo htmlspecialchars($user['username']); ?></li>
                        <li class="list-group-item" style="background: transparent;"><?php echo htmlspecialchars($user['email']); ?></li>
                        <li class="list-group-item" style="background: transparent;">Member since: <?php echo date('Y-m-d', strtotime($user['created_at'])); ?></li>
                        <li class="list-group-item" style="background: transparent;">Flappy Top Score: <?php echo $flappy_top_score; ?></li>
                    </ul>
                </div>
            </div>
            <div class="card shadow-lg rounded-4 h-100 mt-4">
                <div class="card-body d-flex flex-column justify-content-center p-4">
                    <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Games</h3>
                    <div class="d-flex justify-content-center">
                        <a href="flappy.php" class="btn btn-primary btn-lg rounded-3">Flappy</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 align-items-center">
            <div class="w-100 ps-md-5">
                <!-- Right side content (optional) -->
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>