<?php
$conn = require("../config/database.php");
require_once "../includes/auth_check.php";
$sql = "SELECT * FROM subjects ORDER BY subject_name ASC";
$result = mysqli_query($conn, $sql);
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container py-5">
    <div class="mb-4">
        <p class="text-primary fw-semibold mb-1">LEARNING MATERIALS</p>
        <h2 class="fw-bold mb-2">Subjects</h2>
        <p class="text-muted mb-0">Choose a subject to explore available learning materials.</p>
    </div>
    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($subject = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="dashboard-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <h5 class="card-title mb-2">
                                <?= htmlspecialchars($subject["subject_name"]) ?>
                            </h5>
                            <p class="text-muted small mb-4">
                                Browse notes, reviewers, and other learning materials.
                            </p>
                            <a
                                href="materials.php?subject_id=<?= $subject["id"] ?>"
                                class="btn btn-primary" >
                                <i class="bi bi-folder2-open me-1"></i>
                                View Materials
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="dashboard-icon mx-auto">
                            <i class="bi bi-book"></i>
                        </div>
                        <h5 class="fw-bold">No subjects available</h5>
                        <p class="text-muted mb-0">
                            There are currently no subjects to display.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once "../includes/footer.php"; ?>