<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo 'Not logged in';
    exit();
}
include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$score = isset($_POST['score']) ? (int)$_POST['score'] : 0;
if ($score > 0) {
    $stmt = $pdo->prepare('INSERT INTO shooter (user_id, score) VALUES (?, ?)');
    $stmt->execute([$user_id, $score]);
    echo 'ok';
} else {
    echo 'invalid score';
}
