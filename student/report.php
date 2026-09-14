<?php

$conn = require("../config/database.php");
require_once "../includes/auth_check.php";

$material_id = $_GET["id"] ?? null;

if (!$material_id) {
    header("Location: subjects.php");
    exit;
}

$sql = "SELECT id, title FROM materials WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $material_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$material = mysqli_fetch_assoc($result);

if (!$material) {
    header("Location: subjects.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $reason = trim($_POST["reason"]);
    $user_id = $_SESSION["user_id"];

    if ($reason === "") {

        $message = "Please provide a reason.";

    } else {

        $sql = "INSERT INTO reports (material_id, user_id, reason)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "iis",
            $material_id,
            $user_id,
            $reason
        );

        mysqli_stmt_execute($stmt);

        header("Location: material.php?id=" . $material_id);
        exit;
    }
}

?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container mt-5">
    <h2>Report Material</h2>
    <p>
        Material:
        <strong><?= htmlspecialchars($material["title"]) ?></strong>
    </p>
    <?php if ($message): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">
                Reason
            </label>
            <textarea
                name="reason"
                class="form-control"
                rows="4"
                placeholder="Why are you reporting this material?"
                required
            ></textarea>
        </div>
        <button type="submit"   class="btn btn-danger">
            Submit Report
        </button>
        <a
            href="material.php?id=<?= $material["id"] ?>"
            class="btn btn-secondary"
        >
            Cancel
        </a>
    </form>
</div>
<?php require_once "../includes/footer.php"; ?>