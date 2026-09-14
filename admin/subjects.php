<?php

$conn = require("../config/database.php");
require_once "../includes/admin_check.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject_name = trim($_POST["subject_name"]);

    if ($subject_name !== "") {
        $stmt = mysqli_prepare($conn, "INSERT INTO subjects (subject_name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $subject_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: subjects.php");
    exit;
}
$result = mysqli_query($conn, "SELECT * FROM subjects ORDER BY subject_name ASC");

?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>

<div class="container py-5">
    <div class="mb-4">
        <p class="text-primary fw-semibold mb-1">PLATFORM MANAGEMENT</p>
        <h2 class="fw-bold mb-2">Subjects</h2>
        <p class="text-muted mb-0">Manage the subjects available for uploaded materials.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="dashboard-icon">
                        <i class="bi bi-book"></i>
                    </div>

                    <h5 class="fw-bold mb-2">Add Subject</h5>
                    <p class="text-muted small mb-4">
                        Create a new subject that students can select when uploading materials.
                    </p>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="subject_name" class="form-label">Subject Name</label>
                            <input
                                type="text"
                                name="subject_name"
                                id="subject_name"
                                class="form-control"
                                placeholder="e.g. Programming"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-1"></i>
                            Add Subject
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="fw-bold mb-1">Subject List</h5>
                                <p class="text-muted small mb-0">Available subjects in StudyShare.</p>
                            </div>
                            <span class="badge text-bg-light border">
                                <?= mysqli_num_rows($result) ?> Subjects
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Subject</th>
                                    <th class="py-3">Created</th>
                                    <th class="py-3 text-end px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($subject = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="dashboard-icon mb-0" style="width:40px;height:40px;font-size:1.1rem;">
                                                        <i class="bi bi-book"></i>
                                                    </div>
                                                    <span class="fw-semibold">
                                                        <?= htmlspecialchars($subject["subject_name"]) ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-muted">
                                                <?= date("M d, Y", strtotime($subject["created_at"])) ?>
                                            </td>
                                            <td class="text-end px-4">
                                                <a
                                                    href="delete_subject.php?id=<?= $subject["id"] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this subject?')"
                                                    title="Delete Subject"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="dashboard-icon mx-auto">
                                                <i class="bi bi-book"></i>
                                            </div>
                                            <h5 class="fw-bold">No subjects found</h5>
                                            <p class="text-muted mb-0">
                                                Add your first subject using the form.
                                            </p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>