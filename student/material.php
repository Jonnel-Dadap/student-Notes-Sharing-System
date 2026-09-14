<?php
$conn = require("../config/database.php");
require_once "../includes/auth_check.php";
$material_id = $_GET["id"] ?? null;

if (!$material_id) {
    header("Location: subjects.php");
    exit;
}
$sql = "SELECT materials.*, subjects.subject_name, users.name
        FROM materials
        INNER JOIN subjects ON materials.subject_id = subjects.id
        INNER JOIN users ON materials.user_id = users.id
        WHERE materials.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $material_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) !== 1) {
    header("Location: subjects.php");
    exit;
}
$material = mysqli_fetch_assoc($result);
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="mb-3">
                        <?= htmlspecialchars($material["title"]) ?>
                    </h2>
                    <p class="text-muted">
                        Subject:
                        <?= htmlspecialchars($material["subject_name"]) ?>
                    </p>
                    <hr>
                    <p>
                        <?= nl2br(htmlspecialchars($material["description"])) ?>
                    </p>
                    <div class="mt-4">
                        <p class="mb-1">
                            <strong>Uploaded by:</strong>
                            <?= htmlspecialchars($material["name"]) ?>
                        </p>
                        <p>
                            <strong>Uploaded:</strong>
                            <?= htmlspecialchars($material["created_at"]) ?>
                        </p>
                        <a href="../<?= htmlspecialchars($material["file_path"]) ?>" class="btn btn-primary mt-3" download>
                            Download Material
                        </a>
                        <a
                            href="report.php?id=<?= $material["id"] ?>"
                              class="btn btn-warning mt-3">
                            Report Material
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>