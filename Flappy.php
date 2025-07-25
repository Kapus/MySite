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
        <div class="col-12">
            <div class="card shadow-lg rounded-4 p-4">
                <h2 class="text-center mb-4">Flappy Bird</h2>
                <div id="game-container" style="background:#222; width:100%; height:500px; position:relative; overflow:hidden; border-radius:1rem; margin-bottom:2rem;"></div>
                <div class="d-flex justify-content-center">
                    <button id="start-btn" class="btn btn-success btn-lg">Start Game</button>
                </div>
                <div class="mt-4 text-center">
                    <span id="score-display" class="fs-4">Score: 0</span>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
// Simple Flappy Bird JS
const gameContainer = document.getElementById('game-container');
const startBtn = document.getElementById('start-btn');
const scoreDisplay = document.getElementById('score-display');
let bird, gravity, velocity, isPlaying, score, pipes, pipeInterval, gameLoop;

function resetGame() {
    gameContainer.innerHTML = '';
    bird = document.createElement('div');
    bird.style.position = 'absolute';
    bird.style.left = '60px';
    bird.style.top = '180px';
    bird.style.width = '20px'; // 50% smaller
    bird.style.height = '20px'; // 50% smaller
    bird.style.background = 'yellow';
    bird.style.borderRadius = '50%';
    bird.style.boxShadow = '0 0 10px #fff';
    gameContainer.appendChild(bird);
    gravity = 0.6;
    velocity = 0;
    isPlaying = true;
    score = 0;
    pipes = [];
    scoreDisplay.textContent = 'Score: 0';
}

function jump() {
    velocity = -8;
}

document.addEventListener('keydown', function(e) {
    if (isPlaying && (e.code === 'Space' || e.key === ' ')) jump();
});
gameContainer.addEventListener('click', function() {
    if (isPlaying) jump();
});

function createPipe() {
    const gap = 120;
    const pipeWidth = 30; // 50% thinner than before
    const canvasHeight = 500;
    const minGapY = 60;
    const maxGapY = canvasHeight - gap - 60;
    const gapY = Math.floor(Math.random() * (maxGapY - minGapY)) + minGapY;
    // Top pipe
    const topPipe = document.createElement('div');
    topPipe.className = 'pipe';
    topPipe.style.position = 'absolute';
    topPipe.style.left = '800px';
    topPipe.style.top = '0';
    topPipe.style.width = pipeWidth + 'px';
    topPipe.style.height = gapY + 'px';
    topPipe.style.background = '#5A189A';
    topPipe.style.borderRadius = '1rem 1rem 0 0';
    // Bottom pipe
    const bottomPipe = document.createElement('div');
    bottomPipe.className = 'pipe';
    bottomPipe.style.position = 'absolute';
    bottomPipe.style.left = '800px';
    bottomPipe.style.top = (gapY + gap) + 'px';
    bottomPipe.style.width = pipeWidth + 'px';
    bottomPipe.style.height = (canvasHeight - gapY - gap) + 'px';
    bottomPipe.style.background = '#5A189A';
    bottomPipe.style.borderRadius = '0 0 1rem 1rem';
    gameContainer.appendChild(topPipe);
    gameContainer.appendChild(bottomPipe);
    pipes.push({top: topPipe, bottom: bottomPipe, x: 800, width: pipeWidth});
}

function updateGame() {
    velocity += gravity;
    let birdTop = parseInt(bird.style.top);
    birdTop += velocity;
    if (birdTop < 0) birdTop = 0;
    if (birdTop > 480) birdTop = 480;
    bird.style.top = birdTop + 'px';
    // Move pipes
    for (let i = 0; i < pipes.length; i++) {
        pipes[i].x -= 4;
        pipes[i].top.style.left = pipes[i].x + 'px';
        pipes[i].bottom.style.left = pipes[i].x + 'px';
        // Collision
        if (pipes[i].x < 70 && pipes[i].x + pipes[i].width > 60) {
            if (birdTop < parseInt(pipes[i].top.style.height) || birdTop + 20 > parseInt(pipes[i].bottom.style.top)) {
                endGame();
                return;
            }
        }
        // Score: increment when pipe passes bird's right edge
        const birdLeft = 60;
        const birdWidth = 20;
        if (!pipes[i].scored && pipes[i].x + pipes[i].width < birdLeft + birdWidth) {
            score++;
            pipes[i].scored = true;
            scoreDisplay.textContent = 'Score: ' + score;
        }
        // Remove pipes
        if (pipes[i].x + pipes[i].width < 0) {
            gameContainer.removeChild(pipes[i].top);
            gameContainer.removeChild(pipes[i].bottom);
        }
    }
    pipes = pipes.filter(p => p.x + p.width > 0);
}

function endGame() {
    isPlaying = false;
    clearInterval(gameLoop);
    clearInterval(pipeInterval);
    // Send score to server
    fetch('Flappy.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'score=' + score
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            scoreDisplay.textContent += ' | New Top Score!';
        } else {
            scoreDisplay.textContent += ' | Top Score: ' + data.newTopScore;
        }
    });
    startBtn.disabled = false;
}

startBtn.onclick = function() {
    resetGame();
    startBtn.disabled = true;
    createPipe();
    pipeInterval = setInterval(createPipe, 1800);
    gameLoop = setInterval(updateGame, 24);
};
</script>
<?php include 'includes/footer.php'; ?>
