const canvas = document.getElementById('racingCanvas');
const ctx = canvas.getContext('2d');

const track = [
    // Outer boundaries
    {x: 0, y: 0, w: 800, h: 20},
    {x: 0, y: 480, w: 800, h: 20},
    {x: 0, y: 0, w: 20, h: 500},
    {x: 780, y: 0, w: 20, h: 500},
    // Simple inner obstacles (curves)
    {x: 200, y: 100, w: 400, h: 20},
    {x: 200, y: 380, w: 400, h: 20},
    {x: 200, y: 120, w: 20, h: 260},
    {x: 580, y: 120, w: 20, h: 260}
];

const car = {
    x: 60,
    y: 60,
    angle: 0,
    speed: 0,
    maxSpeed: 4,
    accel: 0.15,
    friction: 0.07,
    turnSpeed: 0.045,
    radius: 14
};

const keys = { up: false, down: false, left: false, right: false };

function drawTrack() {
    ctx.save();
    ctx.fillStyle = '#222';
    ctx.shadowColor = '#000';
    ctx.shadowBlur = 6;
    for (const wall of track) {
        ctx.fillRect(wall.x, wall.y, wall.w, wall.h);
    }
    ctx.restore();
}

function drawCar() {
    ctx.save();
    ctx.translate(car.x, car.y);
    ctx.rotate(car.angle);
    ctx.beginPath();
    ctx.rect(-12, -7, 24, 14);
    ctx.fillStyle = '#FF3B3B';
    ctx.shadowColor = '#FFD700';
    ctx.shadowBlur = 10;
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = '#fff';
    ctx.stroke();
    // Draw wheels
    ctx.fillStyle = '#222';
    ctx.fillRect(-12, -9, 6, 4);
    ctx.fillRect(6, -9, 6, 4);
    ctx.fillRect(-12, 5, 6, 4);
    ctx.fillRect(6, 5, 6, 4);
    ctx.restore();
}

function collidesWithTrack(x, y, radius) {
    for (const wall of track) {
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

function updateCar() {
    // Acceleration
    if (keys.up) car.speed += car.accel;
    if (keys.down) car.speed -= car.accel;
    // Friction
    if (!keys.up && !keys.down) {
        if (car.speed > 0) car.speed -= car.friction;
        if (car.speed < 0) car.speed += car.friction;
    }
    // Clamp speed
    if (car.speed > car.maxSpeed) car.speed = car.maxSpeed;
    if (car.speed < -car.maxSpeed/2) car.speed = -car.maxSpeed/2;
    // Turning
    if (keys.left) car.angle -= car.turnSpeed * (car.speed > 0 ? 1 : -1);
    if (keys.right) car.angle += car.turnSpeed * (car.speed > 0 ? 1 : -1);
    // Move
    let nextX = car.x + Math.cos(car.angle) * car.speed;
    let nextY = car.y + Math.sin(car.angle) * car.speed;
    if (!collidesWithTrack(nextX, nextY, car.radius)) {
        car.x = nextX;
        car.y = nextY;
    } else {
        car.speed *= -0.4; // bounce back
    }
}

function gameLoop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawTrack();
    updateCar();
    drawCar();
    requestAnimationFrame(gameLoop);
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') keys.up = true;
    if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') keys.down = true;
    if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = true;
    if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = true;
});
document.addEventListener('keyup', (e) => {
    if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') keys.up = false;
    if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') keys.down = false;
    if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = false;
    if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = false;
});

gameLoop();
