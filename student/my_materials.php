<?php
$conn = require("../config/database.php");
require_once "../includes/auth_check.php";
$user_id = $_SESSION["user_id"];
$sql = "SELECT materials.*, subjects.subject_name
        FROM materials
        INNER JOIN subjects ON materials.subject_id = subjects.id
        WHERE materials.user_id = ?
        ORDER BY materials.created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container py-5">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1">MY CONTENT</p>
        <h2 class="fw-bold mb-2">My Materials</h2>
        <p class="text-muted mb-0">Manage the study materials you have uploaded.</p>
    </div>
    <a href="upload.php" class="btn btn-primary">
        <i class="bi bi-cloud-arrow-up me-1"></i>
        Upload
    </a>
</div>
<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="row g-4">
        <?php while ($material = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="dashboard-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <span class="badge text-bg-light border align-self-start mb-3">
                            <?= htmlspecialchars($material["subject_name"]) ?>
                        </span>
                        <h5 class="card-title mb-2">
                            <a
                                href="material.php?id=<?= $material["id"] ?>"
                                class="text-decoration-none text-dark"
                            >
                                <?= htmlspecialchars($material["title"]) ?>
                            </a>
                        </h5>
                        <p class="text-muted small mb-3">
                            <?= htmlspecialchars($material["description"]) ?>
                        </p>
                        <div class="small text-muted mb-4">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?= date("M d, Y", strtotime($material["created_at"])) ?>
                        </div>
                        <div class="mt-auto">
                            <div class="d-flex gap-2 mb-2">
                                <a
                                    href="material.php?id=<?= $material["id"] ?>"
                                    class="btn btn-outline-primary flex-grow-1"
                                >
                                    <i class="bi bi-eye me-1"></i>
                                    View
                                </a>
                                <a
                                    href="../<?= htmlspecialchars($material["file_path"]) ?>"
                                    class="btn btn-primary"
                                    download
                                    title="Download"
                                >
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <a
                                    href="edit_material.php?id=<?= $material["id"] ?>"
                                    class="btn btn-warning flex-grow-1"
                                >
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit
                                </a>
                                <a
                                    href="delete_material.php?id=<?= $material["id"] ?>"
                                    class="btn btn-danger flex-grow-1"
                                    onclick="return confirm('Are you sure you want to delete this material?')"
                                >
                                    <i class="bi bi-trash me-1"></i>
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <div class="dashboard-icon mx-auto">
                <i class="bi bi-folder2-open"></i>
            </div>
            <h5 class="fw-bold mb-2">
                No materials yet
            </h5>
            <p class="text-muted mb-4">
                You haven't uploaded any study materials yet.
            </p>
            <a href="upload.php" class="btn btn-primary">
                <i class="bi bi-cloud-arrow-up me-1"></i>
                Upload Your First Material
            </a>
        </div>
    </div>
<?php endif; ?>
</div>
<?php require_once "../includes/footer.php"; ?>
