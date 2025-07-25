<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'includes/header.php';
include 'includes/db.php';

// Handle score update via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['score'])) {
    $user_id = $_SESSION['user_id'];
    $score = intval($_POST['score']);
    // Get current top score
    $stmt = $pdo->prepare('SELECT MAX(score) AS top_score FROM flappy WHERE user_id = :user_id');
    $stmt->execute(['user_id' => $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $top_score = $row && $row['top_score'] !== null ? $row['top_score'] : 0;
    if ($score > $top_score) {
        $insert = $pdo->prepare('INSERT INTO flappy (user_id, score) VALUES (:user_id, :score)');
        $insert->execute(['user_id' => $user_id, 'score' => $score]);
        echo json_encode(['success' => true, 'newTopScore' => $score]);
    } else {
        echo json_encode(['success' => false, 'newTopScore' => $top_score]);
    }
    exit();
}
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 mx-auto">
            <div class="card shadow-lg rounded-4 p-4">
                <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Flappy Bird</h3>
<canvas id="flappyCanvas" width="800" height="500" style="border-radius:1rem; box-shadow:0 0 24px #000;"></canvas>
                <button id="restartFlappy" class="btn btn-success btn-lg mt-4" style="display:none;">Restart</button>
            </div>
        </div>
    </div>
</main>
<script src="flappy.js"></script>
<?php include 'includes/footer.php'; ?>
