
<?php

$conn = require("../config/database.php");
require_once "../includes/auth_check.php";

$message = "";
$message_type = "";

$sql = "SELECT * FROM subjects ORDER BY subject_name ASC";
$result = mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $subject_id = $_POST["subject_id"];
    $user_id = $_SESSION["user_id"];

    $file = $_FILES["material_file"];

    $original_name = $file["name"];
    $tmp_name = $file["tmp_name"];

    $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

    $allowed_extensions = [
        "pdf",
        "doc",
        "docx",
        "ppt",
        "pptx"
    ];

    if (!in_array($extension, $allowed_extensions)) {

        $message = "Invalid file type.";
        $message_type = "danger";

    } else {

        $new_file_name = uniqid() . "." . $extension;

        $upload_path = "../uploads/materials/" . $new_file_name;

        if (move_uploaded_file($tmp_name, $upload_path)) {

            $file_path = "uploads/materials/" . $new_file_name;

            $sql = "INSERT INTO materials
                    (user_id, subject_id, title, description, file_name, file_path)
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

                $message = "Material uploaded successfully!";
                $message_type = "success";

            } else {

                $message = "Failed to save material information.";
                $message_type = "danger";

            }

        } else {

            $message = "Failed to upload file.";
            $message_type = "danger";

        }
    }
}

?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h3 class="mb-4">Upload Study Material</h3>

                    <?php if ($message): ?>

                        <div class="alert alert-<?= $message_type ?>">
                            <?= htmlspecialchars($message) ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">

                            <label class="form-label">Title</label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Description</label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="4"
                            ></textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Subject</label>

                            <select
                                name="subject_id"
                                class="form-select"
                                required
                            >

                                <option value="">Select Subject</option>

                                <?php while ($subject = mysqli_fetch_assoc($result)): ?>

                                    <option value="<?= $subject["id"] ?>">
                                        <?= htmlspecialchars($subject["subject_name"]) ?>
                                    </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Study Material</label>

                            <input
                                type="file"
                                name="material_file"
                                class="form-control"
                                required
                            >

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Upload Material
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>
