<?php
include 'includes/header.php';
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 mx-auto">
            <div class="card shadow-lg rounded-4 p-5 text-center">
                <h1 class="display-4 mb-4">Racing</h1>
                <canvas id="racingCanvas" width="800" height="500" style="border-radius:1rem; box-shadow:0 0 24px #000;"></canvas>
                <p class="lead mt-4">Use W A S D or Arrow keys to drive the car.</p>
                <script src="racing.js"></script>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
