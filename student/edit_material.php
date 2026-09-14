<?php

$conn = require("../config/database.php");
require_once "../includes/auth_check.php";

$user_id = $_SESSION["user_id"];
$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: my_materials.php");
    exit;
}

$sql = "SELECT * FROM materials
        WHERE id = ? AND user_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$material = mysqli_fetch_assoc($result);

if (!$material) {
    header("Location: my_materials.php");
    exit;
}
$subjects_sql = "SELECT * FROM subjects ORDER BY subject_name ASC";
$subjects_result = mysqli_query($conn, $subjects_sql);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $subject_id = $_POST["subject_id"];
    if ($title === "" || $subject_id === "") {
        $message = "Title and subject are required.";
    } else {
        $sql = "UPDATE materials
                SET title = ?, description = ?, subject_id = ?
                WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssiii",
            $title,
            $description,
            $subject_id,
            $id,
            $user_id
        );
        if (mysqli_stmt_execute($stmt)) {

            header("Location: my_materials.php");
            exit;

        } else {

            $message = "Failed to update material.";
        }
    }
}
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container mt-5">
    <h2 class="mb-4">Edit Material</h2>
    <?php if ($message): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">
                Title
            </label>
            <input
                type="text"
                name="title"
                class="form-control"
                value="<?= htmlspecialchars($material["title"]) ?>"
                required
            >
        </div>
        <div class="mb-3">
            <label class="form-label">
                Description
            </label>
            <textarea
                name="description"
                class="form-control"
                rows="4"
            ><?= htmlspecialchars($material["description"]) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">
                Subject
            </label>
            <select name="subject_id" class="form-select" required>
                <?php while ($subject = mysqli_fetch_assoc($subjects_result)): ?>
                    <option
                        value="<?= $subject["id"] ?>"
                        <?= $material["subject_id"] == $subject["id"] ? "selected" : "" ?>
                    >
                        <?= htmlspecialchars($subject["subject_name"]) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>
        <a href="my_materials.php" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>

<?php require_once "../includes/footer.php"; ?>