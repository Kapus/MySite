<?php
include 'includes/header.php';
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 mx-auto">
            <div class="card shadow-lg rounded-4 p-5 text-center">
                <h1 class="display-4 mb-4">Shooter</h1>
                <canvas id="shooterCanvas" width="800" height="500" style="border-radius:1rem; box-shadow:0 0 24px #000;"></canvas>
                <p class="lead mt-4">Use W A S D to move the player.</p>
                <script>
                const canvas = document.getElementById('shooterCanvas');
                const ctx = canvas.getContext('2d');
                const player = {
                    x: 60, // spawn in a clear area (top left room)
                    y: 60,
                    size: 12, // even smaller character
                    speed: 2,
                    color: '#FFD700',
                };
                const keys = { w: false, a: false, s: false, d: false };

                let mouseAngle = 0;
                // Define walls as rectangles: {x, y, w, h}
                const walls = [
                    // Outer boundaries (thick walls)
                    {x: 0, y: 0, w: 800, h: 20}, // Top
                    {x: 0, y: 480, w: 800, h: 20}, // Bottom
                    {x: 0, y: 0, w: 20, h: 500}, // Left
                    {x: 780, y: 0, w: 20, h: 500}, // Right
                ];

                function drawWalls() {
                    ctx.save();
                    ctx.fillStyle = '#222';
                    ctx.shadowColor = '#000';
                    ctx.shadowBlur = 6;
                    for (const wall of walls) {
                        ctx.fillRect(wall.x, wall.y, wall.w, wall.h);
                    }
                    ctx.restore();
                }

                // Helper: check if a circle collides with any wall
                function collidesWithWalls(x, y, radius) {
                    for (const wall of walls) {
                        // Find closest point on wall to circle center
                        const closestX = Math.max(wall.x, Math.min(x, wall.x + wall.w));
                        const closestY = Math.max(wall.y, Math.min(y, wall.y + wall.h));
                        const dx = x - closestX;
                        const dy = y - closestY;
                        if (dx * dx + dy * dy < radius * radius) {
                            return true;
                        }
                    }
                    return false;
                }

                function drawPlayer() {
                    ctx.save();
                    // Draw main body (smaller circle with white border)
                    ctx.beginPath();
                    ctx.arc(player.x, player.y, 7, 0, Math.PI * 2);
                    ctx.fillStyle = '#3A86FF';
                    ctx.shadowColor = '#3A86FF';
                    ctx.shadowBlur = 6;
                    ctx.fill();
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = '#fff';
                    ctx.stroke();

                    // Draw face (smaller eyes and smile)
                    ctx.beginPath();
                    ctx.arc(player.x - 2.5, player.y - 1.2, 0.7, 0, Math.PI * 2);
                    ctx.arc(player.x + 2.5, player.y - 1.2, 0.7, 0, Math.PI * 2);
                    ctx.fillStyle = '#fff';
                    ctx.fill();
                    ctx.beginPath();
                    ctx.arc(player.x, player.y + 1.2, 2.2, 0, Math.PI);
                    ctx.lineWidth = 0.8;
                    ctx.strokeStyle = '#fff';
                    ctx.stroke();

                    // Draw left arm (shorter)
                    ctx.beginPath();
                    ctx.moveTo(player.x - 4.5, player.y + 1.2);
                    ctx.lineTo(player.x - 9, player.y + 5);
                    ctx.strokeStyle = '#fff';
                    ctx.lineWidth = 1.5;
                    ctx.stroke();

                    // Draw right arm with gun (rotates with mouse, shorter)
                    ctx.save();
                    ctx.translate(player.x + 4.5, player.y + 1.2);
                    ctx.rotate(mouseAngle);
                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.lineTo(7, 0);
                    ctx.strokeStyle = '#fff';
                    ctx.lineWidth = 1.5;
                    ctx.stroke();
                    // Draw gun (smaller rectangle)
                    ctx.beginPath();
                    ctx.rect(5, -1, 4, 2);
                    ctx.fillStyle = '#222';
                    ctx.fill();
                    ctx.restore();

                    // Draw left leg (shorter)
                    ctx.beginPath();
                    ctx.moveTo(player.x - 2.2, player.y + 7);
                    ctx.lineTo(player.x - 3.5, player.y + 13);
                    ctx.strokeStyle = '#fff';
                    ctx.lineWidth = 1.5;
                    ctx.stroke();

                    // Draw right leg (shorter)
                    ctx.beginPath();
                    ctx.moveTo(player.x + 2.2, player.y + 7);
                    ctx.lineTo(player.x + 3.5, player.y + 13);
                    ctx.stroke();

                    ctx.restore();
                }
                // Bullets array
                const bullets = [];
                // Enemies array
                const enemies = [];
                // Score
                let score = 0;

                function spawnEnemy() {
                    // Spawn at a random position inside the canvas, not too close to walls
                    let ex = Math.random() * (canvas.width - 60) + 30;
                    let ey = Math.random() * (canvas.height - 60) + 30;
                    // Give each enemy a random direction and speed
                    let angle = Math.random() * Math.PI * 2;
                    let speed = Math.random() * 1.5 + 0.5; // 0.5 to 2.0
                    let vx = Math.cos(angle) * speed;
                    let vy = Math.sin(angle) * speed;
                    enemies.push({ x: ex, y: ey, radius: 10, vx: vx, vy: vy });
                }

                function drawEnemies() {
                    ctx.save();
                    for (const e of enemies) {
                        ctx.beginPath();
                        ctx.arc(e.x, e.y, e.radius, 0, Math.PI * 2);
                        ctx.fillStyle = '#FF3B3B';
                        ctx.shadowColor = '#FF3B3B';
                        ctx.shadowBlur = 8;
                        ctx.fill();
                        ctx.lineWidth = 2;
                        ctx.strokeStyle = '#fff';
                        ctx.stroke();
                    }
                    ctx.restore();
                }

                function updateEnemies() {
                    for (const e of enemies) {
                        // Move in their own direction
                        let nextX = e.x + e.vx;
                        let nextY = e.y + e.vy;
                        // Bounce off walls
                        if (collidesWithWalls(nextX, e.y, e.radius)) {
                            e.vx *= -1;
                        } else {
                            e.x = nextX;
                        }
                        if (collidesWithWalls(e.x, nextY, e.radius)) {
                            e.vy *= -1;
                        } else {
                            e.y = nextY;
                        }
                    }
                    // Remove enemies hit by bullets
                    for (let i = enemies.length - 1; i >= 0; i--) {
                        let e = enemies[i];
                        for (let j = bullets.length - 1; j >= 0; j--) {
                            let b = bullets[j];
                            let dx = e.x - b.x;
                            let dy = e.y - b.y;
                            let dist = Math.sqrt(dx * dx + dy * dy);
                            if (dist < e.radius + 2) {
                                enemies.splice(i, 1);
                                bullets.splice(j, 1);
                                score += 1;
                                break;
                            }
                        }
                    }
                }

                // Spawn an enemy every 2 seconds
                setInterval(spawnEnemy, 2000);

                function drawBullets() {
                    ctx.save();
                    for (const b of bullets) {
                        ctx.beginPath();
                        ctx.arc(b.x, b.y, 1.5, 0, Math.PI * 2); // even smaller bullet
                        ctx.fillStyle = '#A5D7E8';
                        ctx.shadowColor = '#A5D7E8';
                        ctx.shadowBlur = 5;
                        ctx.fill();
                    }
                    ctx.restore();
                }

                function updateBullets() {
                    for (const b of bullets) {
                        b.x += b.vx;
                        b.y += b.vy;
                    }
                    // Remove bullets out of bounds or if they hit a wall
                    for (let i = bullets.length - 1; i >= 0; i--) {
                        const b = bullets[i];
                        if (
                            b.x < 0 || b.x > canvas.width ||
                            b.y < 0 || b.y > canvas.height ||
                            collidesWithWalls(b.x, b.y, 2) // bullet radius
                        ) {
                            bullets.splice(i, 1);
                        }
                    }
                }

                let isGameOver = false;
                let scoreSent = false;

                function update() {
                    if (isGameOver) return;
                    let nextX = player.x;
                    let nextY = player.y;
                    const r = 7; // match body radius
                    if (keys.w) nextY -= player.speed;
                    if (keys.s) nextY += player.speed;
                    if (keys.a) nextX -= player.speed;
                    if (keys.d) nextX += player.speed;
                    // Only move if not colliding with any wall
                    if (!collidesWithWalls(nextX, player.y, r)) player.x = nextX;
                    if (!collidesWithWalls(player.x, nextY, r)) player.y = nextY;

                    // Check collision with enemies
                    for (const e of enemies) {
                        let dx = player.x - e.x;
                        let dy = player.y - e.y;
                        let dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < r + e.radius) {
                            isGameOver = true;
                        }
                    }
                }

                function drawScore() {
                    ctx.save();
                    ctx.font = 'bold 24px sans-serif';
                    ctx.fillStyle = '#FFD700';
                    ctx.textAlign = 'left';
                    ctx.shadowColor = '#000';
                    ctx.shadowBlur = 4;
                    ctx.fillText('Score: ' + score, 28, 38);
                    ctx.restore();
                }

                function gameLoop() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    update();
                    updateBullets();
                    updateEnemies();
                    drawWalls();
                    drawPlayer();
                    drawBullets();
                    drawEnemies();
                    drawScore();
                    if (typeof drawAimingIcon === 'function') drawAimingIcon();
                    if (isGameOver) {
                        if (!scoreSent) {
                            scoreSent = true;
                            // Send score to server
                            fetch('save_shooter_score.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: 'score=' + encodeURIComponent(score)
                            });
                        }
                        ctx.save();
                        ctx.globalAlpha = 0.8;
                        ctx.fillStyle = '#000';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        ctx.globalAlpha = 1;
                        ctx.fillStyle = '#FFD700';
                        ctx.font = 'bold 48px sans-serif';
                        ctx.textAlign = 'center';
                        ctx.fillText('Game Over', canvas.width / 2, canvas.height / 2);
                        ctx.font = '24px sans-serif';
                        ctx.fillStyle = '#fff';
                        ctx.fillText('Refresh to play again', canvas.width / 2, canvas.height / 2 + 40);
                        ctx.restore();
                        return;
                    }
                    requestAnimationFrame(gameLoop);
                }

                gameLoop();
                // Track mouse position for aiming
                canvas.addEventListener('mousemove', (e) => {
                    const rect = canvas.getBoundingClientRect();
                    const mx = e.clientX - rect.left;
                    const my = e.clientY - rect.top;
                    mouseAngle = Math.atan2(my - player.y, mx - player.x);
                });

                // Fire bullets on left mouse click
                canvas.addEventListener('mousedown', (e) => {
                    if (e.button === 0) {
                        const angle = mouseAngle;
                        const speed = 10;
                        const bx = player.x + 10 + Math.cos(angle) * 22;
                        const by = player.y + Math.sin(angle) * 22;
                        bullets.push({
                            x: bx,
                            y: by,
                            vx: Math.cos(angle) * speed,
                            vy: Math.sin(angle) * speed
                        });
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'w' || e.key === 'W') keys.w = true;
                    if (e.key === 'a' || e.key === 'A') keys.a = true;
                    if (e.key === 's' || e.key === 'S') keys.s = true;
                    if (e.key === 'd' || e.key === 'D') keys.d = true;
                });
                document.addEventListener('keyup', (e) => {
                    if (e.key === 'w' || e.key === 'W') keys.w = false;
                    if (e.key === 'a' || e.key === 'A') keys.a = false;
                    if (e.key === 's' || e.key === 'S') keys.s = false;
                    if (e.key === 'd' || e.key === 'D') keys.d = false;
                });

                gameLoop();
                </script>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
