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

// Fetch Shooter top score for this user
$shooter_stmt = $pdo->prepare('SELECT MAX(score) AS top_score FROM shooter WHERE user_id = :user_id');
$shooter_stmt->execute(['user_id' => $user_id]);
$shooter_row = $shooter_stmt->fetch(PDO::FETCH_ASSOC);
$shooter_top_score = $shooter_row && $shooter_row['top_score'] !== null ? $shooter_row['top_score'] : 0;

// Check if this user has the highest Flappy score overall
$global_stmt = $pdo->query('SELECT user_id, MAX(score) AS top_score FROM flappy GROUP BY user_id ORDER BY top_score DESC LIMIT 1');
$global_row = $global_stmt->fetch(PDO::FETCH_ASSOC);
$is_top_user = $global_row && $global_row['user_id'] == $user_id;

// Check if this user has the highest Shooter score overall
$shooter_global_stmt = $pdo->query('SELECT user_id, MAX(score) AS top_score FROM shooter GROUP BY user_id ORDER BY top_score DESC LIMIT 1');
$shooter_global_row = $shooter_global_stmt->fetch(PDO::FETCH_ASSOC);
$is_top_shooter = $shooter_global_row && $shooter_global_row['user_id'] == $user_id;
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
                        <li class="list-group-item d-flex align-items-center" style="background: transparent;">Flappy Top Score: <span class="ms-1"><?php echo $flappy_top_score; ?></span>
                        <?php if ($is_top_user): ?>
                            <span class="ms-2" style="display:inline-flex; align-items:center; height:1em;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="gold" style="vertical-align:middle;filter:drop-shadow(0 4px 12px #bfa700) drop-shadow(0 0 24px gold);">
                                    <path d="M3 2a1 1 0 0 0-1 1v2a5 5 0 0 0 4 4.9V14H5a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2h-1V9.9A5 5 0 0 0 14 5V3a1 1 0 0 0-1-1H3zm0 1h10v2a4 4 0 0 1-8 0V3z"/>
                                </svg>
                            </span>
                        <?php endif; ?>
                        </li>
                        <li class="list-group-item d-flex align-items-center" style="background: transparent;">Shooter Top Score: <span class="ms-1"><?php echo $shooter_top_score; ?></span>
                        <?php if ($is_top_shooter): ?>
                            <span class="ms-2" style="display:inline-flex; align-items:center; height:1em;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="gold" style="vertical-align:middle;filter:drop-shadow(0 4px 12px #bfa700) drop-shadow(0 0 24px gold);">
                                    <path d="M3 2a1 1 0 0 0-1 1v2a5 5 0 0 0 4 4.9V14H5a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2h-1V9.9A5 5 0 0 0 14 5V3a1 1 0 0 0-1-1H3zm0 1h10v2a4 4 0 0 1-8 0V3z"/>
                                </svg>
                            </span>
                        <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card shadow-lg rounded-4 h-100 mt-4">
                <div class="card-body d-flex flex-column justify-content-center p-4">
                    <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Games</h3>
                    <div class="d-flex flex-column align-items-center gap-2">
                        <a href="flappy.php" class="btn btn-primary btn-lg rounded-3">Flappy</a>
                        <a href="shooter.php" class="btn btn-primary btn-lg rounded-3">Shooter</a>
                        <a href="racing.php" class="btn btn-primary btn-lg rounded-3">Racing</a>
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