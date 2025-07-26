<?php
include 'includes/header.php';
include 'includes/db.php';

$stmt = $pdo->prepare('SELECT users.username, MAX(flappy.score) AS score FROM flappy JOIN users ON flappy.user_id = users.id GROUP BY flappy.user_id, users.username ORDER BY score DESC LIMIT 5');
$stmt->execute();
$leaders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg rounded-4 p-4" style="background: linear-gradient(135deg, #18122B 0%, #2D31FA 100%); color: #e0e0ff; border: none;">
                <h3 class="card-title mb-4 display-4 text-center" style="font-size:2.2rem;">Flappy Leaders</h3>
                <ul class="list-group list-group-flush mb-3">
                <?php foreach ($leaders as $i => $row): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background: transparent; color: #e0e0ff;">
                        <span><strong>#<?php echo $i+1; ?></strong> <?php echo htmlspecialchars($row['username']); ?></span>
                        <span class="badge bg-primary rounded-pill" style="font-size:1.1rem;"><?php echo $row['score']; ?></span>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
