
<?php
include 'includes/header.php';
include 'includes/db.php';

// Flappy leaders
$stmt = $pdo->prepare('SELECT users.username, MAX(flappy.score) AS score FROM flappy JOIN users ON flappy.user_id = users.id GROUP BY flappy.user_id, users.username ORDER BY score DESC LIMIT 5');
$stmt->execute();
$leaders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Shooter leaders
$shooter_stmt = $pdo->prepare('SELECT users.username, MAX(shooter.score) AS score FROM shooter JOIN users ON shooter.user_id = users.id GROUP BY shooter.user_id, users.username ORDER BY score DESC LIMIT 5');
$shooter_stmt->execute();
$shooter_leaders = $shooter_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card shadow-lg rounded-4 p-4" style="color: #e0e0ff; border: none;">
                <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Flappy Leaders</h3>
                <ul class="list-group list-group-flush mb-3">
                <?php foreach ($leaders as $i => $row): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background: transparent; color: #e0e0ff;">
                        <span style="font-size:1.3rem;<?php echo $i === 0 ? 'color:gold;text-shadow:0 0 8px gold,0 0 16px #ffd700;font-weight:bold;' : ($i === 1 ? 'color:silver;text-shadow:0 0 8px silver,0 0 16px #c0c0c0;' : ($i === 2 ? 'color:#cd7f32;text-shadow:0 0 8px #cd7f32,0 0 16px #cd7f32;' : '')); ?>">
                            <strong>#<?php echo $i+1; ?></strong> <?php echo $i === 0 ? '<span style="font-weight:bold;">'.htmlspecialchars($row['username']).'</span>' : htmlspecialchars($row['username']); ?>
                            <?php if ($i === 0): ?>
                                <span style="margin-left:6px;" title="Top scorer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gold" viewBox="0 0 16 16">
                                        <path d="M3 2a1 1 0 0 0-1 1v2a5 5 0 0 0 4 4.9V14H5a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2h-1V9.9A5 5 0 0 0 14 5V3a1 1 0 0 0-1-1H3zm0 1h10v2a4 4 0 0 1-8 0V3z"/>
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </span>
                        <span class="badge bg-primary rounded-pill" style="font-size:1.1rem;"><?php echo $row['score']; ?></span>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>

            <div class="card shadow-lg rounded-4 p-4 mt-4" style="color: #e0e0ff; border: none;">
                <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Shooter Leaders</h3>
                <ul class="list-group list-group-flush mb-3">
                <?php foreach ($shooter_leaders as $i => $row): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background: transparent; color: #e0e0ff;">
                        <span style="font-size:1.3rem;<?php echo $i === 0 ? 'color:gold;text-shadow:0 0 8px gold,0 0 16px #ffd700;font-weight:bold;' : ($i === 1 ? 'color:silver;text-shadow:0 0 8px silver,0 0 16px #c0c0c0;' : ($i === 2 ? 'color:#cd7f32;text-shadow:0 0 8px #cd7f32,0 0 16px #cd7f32;' : '')); ?>">
                            <strong>#<?php echo $i+1; ?></strong> <?php echo $i === 0 ? '<span style="font-weight:bold;">'.htmlspecialchars($row['username']).'</span>' : htmlspecialchars($row['username']); ?>
                            <?php if ($i === 0): ?>
                                <span style="margin-left:6px;" title="Top scorer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gold" viewBox="0 0 16 16">
                                        <path d="M3 2a1 1 0 0 0-1 1v2a5 5 0 0 0 4 4.9V14H5a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2h-1V9.9A5 5 0 0 0 14 5V3a1 1 0 0 0-1-1H3zm0 1h10v2a4 4 0 0 1-8 0V3z"/>
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </span>
                        <span class="badge bg-primary rounded-pill" style="font-size:1.1rem;"><?php echo $row['score']; ?></span>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
