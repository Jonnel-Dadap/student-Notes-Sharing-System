<?php

$conn = require("../config/database.php");
require_once "../includes/auth_check.php";
$message = "";
$message_type = "";
$subjects_sql = "SELECT * FROM subjects ORDER BY subject_name ASC";
$subjects_result = mysqli_query($conn, $subjects_sql);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $subject_id = $_POST["subject_id"];
    $user_id = $_SESSION["user_id"];
    if ($title === "" || $subject_id === "" || !isset($_FILES["file"])) {
        $message = "Please complete all required fields.";
        $message_type = "danger";
    } else {
        $file = $_FILES["file"];
        $original_name = $file["name"];
        $tmp_name = $file["tmp_name"];
        $file_error = $file["error"];
        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $allowed_extensions = ["pdf", "doc", "docx", "ppt", "pptx"];
        if ($file_error !== UPLOAD_ERR_OK) {
            $message = "File upload failed.";
            $message_type = "danger";
        } elseif (!in_array($extension, $allowed_extensions)) {
            $message = "Invalid file type.";
            $message_type = "danger";
        } else {
            $new_file_name = uniqid() . "." . $extension;
            $upload_directory = "../uploads/materials/";
            $file_path = "uploads/materials/" . $new_file_name;
            if (move_uploaded_file($tmp_name, $upload_directory . $new_file_name)) {
                $sql = "INSERT INTO materials (user_id, subject_id, title, description, file_name, file_path)
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param(
                    $stmt,
                    "iissss",
                    $user_id,
                    $subject_id,
                    $title,
                    $description,
                    $original_name,
                    $file_path
                );
                if (mysqli_stmt_execute($stmt)) {
                    $message = "Material uploaded successfully.";
                    $message_type = "success";
                } else {
                    $message = "Failed to save material.";
                    $message_type = "danger";
                }
            } else {
                $message = "Failed to upload file.";
                $message_type = "danger";
            }
        }
    }
}
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container py-5">
<div class="mb-4">
    <p class="text-primary fw-semibold mb-1">SHARE KNOWLEDGE</p>
    <h2 class="fw-bold mb-2">Upload Material</h2>
    <p class="text-muted">Share your notes, reviewers, and learning materials.</p>
</div>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <?php if ($message): ?>
                    <div class="alert alert-<?= $message_type ?>">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Material Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter material title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subject</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">Select a subject</option>
                            <?php while ($subject = mysqli_fetch_assoc($subjects_result)): ?>
                                <option value="<?= $subject["id"] ?>">
                                    <?= htmlspecialchars($subject["subject_name"]) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Describe your material"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">File</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                        <div class="form-text">
                            Allowed files: PDF, DOC, DOCX, PPT, PPTX
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="dashboard.php" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-arrow-up me-1"></i>
                            Upload Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once "../includes/footer.php"; ?>
