<?php

$conn = require("../config/database.php");
require_once "../includes/admin_check.php";

$sql = "SELECT materials.*, subjects.subject_name, users.name
        FROM materials
        INNER JOIN subjects ON materials.subject_id = subjects.id
        INNER JOIN users ON materials.user_id = users.id
        ORDER BY materials.created_at DESC";

$result = mysqli_query($conn, $sql);

?>
<?php require_once "../includes/header.php"; ?>

<?php require_once "../includes/navbar.php"; ?>
<div class="container py-5">
<div class="mb-4">
    <p class="text-primary fw-semibold mb-1">CONTENT MANAGEMENT</p>
    <h2 class="fw-bold mb-2">Materials</h2>
    <p class="text-muted mb-0">Review and manage materials uploaded by students.</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Material</th>
                        <th class="py-3">Subject</th>
                        <th class="py-3">Uploaded By</th>
                        <th class="py-3">Date</th>
                        <th class="py-3 text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($material = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="dashboard-icon mb-0" style="width:40px;height:40px;font-size:1.1rem;">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <div>
                                            <a
                                                href="material.php?id=<?= $material["id"] ?>"
                                                class="fw-semibold text-decoration-none text-dark"
                                            >
                                                <?= htmlspecialchars($material["title"]) ?>
                                            </a>

                                            <div class="small text-muted">
                                                <?= htmlspecialchars($material["file_name"]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-light border">
                                        <?= htmlspecialchars($material["subject_name"]) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= htmlspecialchars($material["name"]) ?>
                                </td>
                                <td class="text-muted">
                                    <?= date("M d, Y", strtotime($material["created_at"])) ?>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a
                                            href="material.php?id=<?= $material["id"] ?>"
                                            class="btn btn-outline-primary btn-sm"
                                            title="View"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a
                                            href="../<?= htmlspecialchars($material["file_path"]) ?>"
                                            class="btn btn-primary btn-sm"
                                            download
                                            title="Download"
                                        >
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <a
                                            href="delete_material.php?id=<?= $material["id"] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this material?')"
                                            title="Delete"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="dashboard-icon mx-auto">
                                    <i class="bi bi-folder2-open"></i>
                                </div>
                                <h5 class="fw-bold">No materials found</h5>
                                <p class="text-muted mb-0">
                                    There are currently no uploaded materials.
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

<?php require_once "../includes/footer.php"; ?>
