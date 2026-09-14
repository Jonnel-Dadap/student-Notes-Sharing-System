<?php
$conn = require("../config/database.php");
require_once "../includes/admin_check.php";

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject_name = trim($_POST["subject_name"]);
    if ($subject_name === "") {
        $message = "Subject name is required.";

    } else {
        $sql = "INSERT INTO subjects (subject_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $subject_name);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Subject added successfully.";
        } else {
            $message = "Failed to add subject.";
        }
    }
}
$sql = "SELECT * FROM subjects ORDER BY subject_name ASC";
$result = mysqli_query($conn, $sql);
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Subjects</h2>
    <?php if ($message): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-8">
                <input type="text"  name="subject_name"  class="form-control" placeholder="Enter subject name" required >
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    Add Subject
                </button>
            </div>
        </div>
    </form>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($subject = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td> <?= $subject["id"] ?> </td>
                            <td> <?= htmlspecialchars($subject["subject_name"]) ?> </td>
                            <td> <?= htmlspecialchars($subject["created_at"]) ?> </td>
                            <td>
                                <a
                                    href="delete_subject.php?id=<?= $subject["id"] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this subject?')"
                                >
                                    Delete
                            </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            No subjects found.
        </div>
    <?php endif; ?>
</div>
<?php require_once "../includes/footer.php"; ?>