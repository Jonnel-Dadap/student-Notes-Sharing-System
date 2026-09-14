<?php
$conn = require("../config/database.php");
require_once "../includes/admin_check.php";
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-primary fw-semibold mb-1">USER MANAGEMENT</p>
            <h2 class="fw-bold mb-2">Users</h2>
            <p class="text-muted mb-0">View registered StudyShare accounts.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="dashboard-icon mb-0" style="width:40px;height:40px;font-size:1.1rem;">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <span class="fw-semibold">
                                            <?= htmlspecialchars($user["name"]) ?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <?= htmlspecialchars($user["email"]) ?>
                                </td>
                                <td>
                                    <?php if ($user["role"] === "admin"): ?>
                                        <span class="badge text-bg-primary">
                                            <i class="bi bi-shield-check me-1"></i>
                                            Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge text-bg-light border">
                                            <i class="bi bi-person me-1"></i>
                                            Student
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted">
                                    <?= date("M d, Y", strtotime($user["created_at"])) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>