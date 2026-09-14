<?php
$conn = require("../config/database.php");
require_once "../includes/auth_check.php";
$user_id = $_SESSION["user_id"];
$sql = "SELECT COUNT(*) AS total_materials
        FROM materials
        WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
$total_materials = $data["total_materials"];
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container py-5">
    <div class="mb-5">
        <p class="text-primary fw-semibold mb-2">
            STUDENT DASHBOARD
        </p>
        <h2 class="fw-bold mb-2">
            Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!
        </h2>
        <p class="text-muted mb-0">
            Manage your materials and discover useful study resources.
        </p>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="dashboard-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <p class="text-muted mb-2">
                        My Materials
                    </p>
                    <h2 class="fw-bold mb-2">
                        <?= $total_materials ?>
                    </h2>
                    <p class="text-muted mb-4">
                        Materials you have uploaded.
                    </p>
                    <a  href="my_materials.php"
                        class="btn btn-primary"
                    >   View My Materials </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="dashboard-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <p class="text-muted mb-2">
                        Subjects
                    </p>
                    <h4 class="fw-bold mb-2">
                        Explore Resources
                    </h4>
                    <p class="text-muted mb-4">
                        Browse study materials organized by subject.
                    </p>
                    <a
                        href="subjects.php"
                        class="btn btn-outline-primary"
                    >
                        Browse Subjects
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="dashboard-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <p class="text-muted mb-2">
                        Share Knowledge
                    </p>
                    <h4 class="fw-bold mb-2">
                        Upload Material
                    </h4>
                    <p class="text-muted mb-4">
                        Share your notes and learning materials with other students.
                    </p>
                    <a
                        href="upload.php"
                        class="btn btn-primary"
                    >
                        Upload Material
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-start gap-3">
                        <div class="dashboard-icon dark mb-0 flex-shrink-0">
                            <i class="bi bi-search"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-2">
                                Looking for something?
                            </h4>
                            <p class="text-muted mb-0">
                                Search for notes, reviewers, and other study
                                materials shared by students.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <a
                        href="search.php"
                        class="btn btn-dark"
                    >
                        Search Materials
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>