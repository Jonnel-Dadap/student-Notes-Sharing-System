<?php

$conn = require("../config/database.php");
require_once "../includes/auth_check.php";

$subject_id = $_GET["subject_id"] ?? null;

if (!$subject_id) {
    header("Location: subjects.php");
    exit;
}

$sql = "SELECT materials.*, subjects.subject_name, users.name
        FROM materials
        INNER JOIN subjects ON materials.subject_id = subjects.id
        INNER JOIN users ON materials.user_id = users.id
        WHERE materials.subject_id = ?
        ORDER BY materials.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $subject_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>

<div class="container mt-5">

    <h2 class="mb-4">Study Materials</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>

        <div class="row">

            <?php while ($material = mysqli_fetch_assoc($result)): ?>

                <div class="col-md-6 mb-4">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">
                                <a href="material.php?id=<?= $material["id"] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($material["title"]) ?>
                                </a>
                            </h5>

                            <p class="text-muted mb-2">
                                Subject:
                                <?= htmlspecialchars($material["subject_name"]) ?>
                            </p>

                            <p>
                                <?= htmlspecialchars($material["description"]) ?>
                            </p>

                            <small class="text-muted">
                                Uploaded by:
                                <?= htmlspecialchars($material["name"]) ?>
                            </small>

                            <div class="mt-3">
                                <a
                                    href="../<?= htmlspecialchars($material["file_path"]) ?>"
                                    class="btn btn-primary"
                                    download>
                                    Download Material
                                </a>
                            </div>
                         

                        </div>


                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="alert alert-info">
            No study materials found for this subject.
        </div>

    <?php endif; ?>

</div>

<?php require_once "../includes/footer.php"; ?>