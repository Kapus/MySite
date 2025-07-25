document.addEventListener('DOMContentLoaded', () => {
    // Remove scale factor for game content
    const canvas = document.getElementById('flappyCanvas');
    if (!canvas) {
        alert('Canvas element not found.');
        return;
    }
    const ctx = canvas.getContext('2d');
    if (!ctx) {
        alert('Canvas context not available.');
        return;
    }
    const restartButton = document.getElementById('restartFlappy');
    if (!restartButton) {
        alert('Restart button not found.');
        return;
    }
    const gravity = 0.5;
    const bird = {
        x: 60,
        y: canvas.height / 2,
        width: 24,
        height: 16,
        velocity: 0
    };
    const pipeWidth = 18;
    const pipeGap = 140;
    let pipes = [];
    let score = 0;
    let gameOver = false;
    let gameInterval;

    function resetGame() {
        bird.y = canvas.height / 2;
        bird.velocity = 0;
        pipes = [];
        score = 0;
        gameOver = false;
        restartButton.style.display = 'none';
        clearInterval(gameInterval);
        gameInterval = setInterval(draw, 16);
    }

    function drawBird() {
        ctx.save();
        ctx.translate(bird.x, bird.y);
        ctx.scale(-1, 1); // Flip horizontally
        ctx.rotate(-bird.velocity * 0.05); // Adjust rotation for flipped
        ctx.font = `${bird.height * 1.5}px Arial`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('🐦', 0, 0);
        ctx.restore();
    }

    function drawPipes() {
        ctx.fillStyle = '#9D4EDD';
        pipes.forEach(pipe => {
            // Top pipe: from top to gap
            ctx.fillRect(pipe.x, 0, pipeWidth, pipe.top);
            // Bottom pipe: from gap to bottom
            ctx.fillRect(pipe.x, pipe.top + pipeGap, pipeWidth, canvas.height - (pipe.top + pipeGap));
        });
    }

    function drawScore() {
        ctx.font = '24px Poppins, Arial';
        ctx.fillStyle = '#E0B0FF';
        ctx.fillText('Score: ' + score, 20, 40);
    }

    function draw() {
        // Draw matching background gradient as login form
        const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
        gradient.addColorStop(0, '#18122B');
        gradient.addColorStop(1, '#2D31FA');
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        drawBird();
        drawPipes();
        drawScore();

        // Bird physics
        bird.velocity += gravity;
        bird.y += bird.velocity;

        // Bird collision with ground or ceiling
        if (bird.y + bird.height / 2 > canvas.height || bird.y - bird.height / 2 < 0) {
            endGame();
            return;
        }

        // Move pipes and check for collisions
        pipes.forEach(pipe => {
            pipe.x -= 2;
            // Collision detection
            if (
                bird.x + bird.width / 2 > pipe.x &&
                bird.x - bird.width / 2 < pipe.x + pipeWidth &&
                (bird.y - bird.height / 2 < pipe.top || bird.y + bird.height / 2 > pipe.top + pipeGap)
            ) {
                endGame();
            }
            // Score
            if (!pipe.passed && pipe.x + pipeWidth < bird.x) {
                score++;
                pipe.passed = true;
            }
        });

        // Remove off-screen pipes
        pipes = pipes.filter(pipe => pipe.x + pipeWidth > 0);

        // Add new pipes
        if (pipes.length === 0 || pipes[pipes.length - 1].x < canvas.width - 220) {
            const top = Math.random() * (canvas.height - pipeGap - 80) + 40;
            pipes.push({ x: canvas.width, top, passed: false });
        }
    }

    function endGame() {
        gameOver = true;
        clearInterval(gameInterval);
        restartButton.style.display = 'block';
        // Send score to server
        fetch('flappy.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'score=' + score
        })
        .then(res => res.json())
        .then(data => {
            // Optionally handle response, e.g. show top score
        });
    }

    function flap() {
        if (!gameOver) {
            bird.velocity = -8;
        }
    }

    document.addEventListener('keydown', e => {
        if (e.code === 'Space') flap();
    });
    canvas.addEventListener('mousedown', flap);
    restartButton.addEventListener('click', resetGame);

    resetGame();
});