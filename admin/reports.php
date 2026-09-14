<?php

$conn = require("../config/database.php");
require_once "../includes/admin_check.php";

$sql = "SELECT reports.*, materials.title, users.name
        FROM reports
        INNER JOIN materials ON reports.material_id = materials.id
        INNER JOIN users ON reports.user_id = users.id
        ORDER BY reports.created_at DESC";

$result = mysqli_query($conn, $sql);

?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>

<div class="container py-5">
    <div class="mb-4">
        <p class="text-primary fw-semibold mb-1">CONTENT MODERATION</p>
        <h2 class="fw-bold mb-2">Reports</h2>
        <p class="text-muted mb-0">Review reports submitted by students.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Material</th>
                            <th class="py-3">Reported By</th>
                            <th class="py-3">Reason</th>
                            <th class="py-3">Date</th>
                            <th class="py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($report = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="dashboard-icon dark mb-0" style="width:40px;height:40px;font-size:1.1rem;">
                                                <i class="bi bi-flag"></i>
                                            </div>
                                            <div>
                                                <a
                                                    href="material.php?id=<?= $report["material_id"] ?>"
                                                    class="fw-semibold text-decoration-none text-dark"
                                                >
                                                    <?= htmlspecialchars($report["title"]) ?>
                                                </a>
                                                <div class="small text-muted">
                                                    Material ID: <?= $report["material_id"] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($report["name"]) ?>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-warning">
                                            <?= htmlspecialchars($report["reason"]) ?>
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        <?= date("M d, Y", strtotime($report["created_at"])) ?>
                                    </td>
                                    <td class="text-end px-4">
                                        <a
                                            href="delete_report.php?id=<?= $report["id"] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this report?')"
                                            title="Delete Report"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="dashboard-icon mx-auto">
                                        <i class="bi bi-flag"></i>
                                    </div>
                                    <h5 class="fw-bold">No reports found</h5>
                                    <p class="text-muted mb-0">
                                        There are currently no reported materials.
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