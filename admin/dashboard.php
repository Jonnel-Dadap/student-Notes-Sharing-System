<?php

$conn = require("../config/database.php");
require_once "../includes/admin_check.php";

$users_sql = "SELECT COUNT(*) AS total_users FROM users";
$users_result = mysqli_query($conn, $users_sql);
$users_data = mysqli_fetch_assoc($users_result);

$materials_sql = "SELECT COUNT(*) AS total_materials FROM materials";
$materials_result = mysqli_query($conn, $materials_sql);
$materials_data = mysqli_fetch_assoc($materials_result);

$subjects_sql = "SELECT COUNT(*) AS total_subjects FROM subjects";
$subjects_result = mysqli_query($conn, $subjects_sql);
$subjects_data = mysqli_fetch_assoc($subjects_result);

$reports_sql = "SELECT COUNT(*) AS total_reports FROM reports";
$reports_result = mysqli_query($conn, $reports_sql);
$reports_data = mysqli_fetch_assoc($reports_result);

?>

<?php require_once "../includes/header.php"; ?>

<?php require_once "../includes/navbar.php"; ?>

<div class="container py-5">

<div class="mb-5">
    <p class="text-primary fw-semibold mb-1">ADMINISTRATION</p>
    <h2 class="fw-bold mb-2">
        Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!
    </h2>
    <p class="text-muted mb-0">
        Monitor and manage the StudyShare platform.
    </p>
</div>

<div class="row g-4 mb-5">

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-4">
                <div class="dashboard-icon">
                    <i class="bi bi-people"></i>
                </div>
                <p class="text-muted mb-1">Total Users</p>
                <h2 class="fw-bold mb-3">
                    <?= $users_data["total_users"] ?>
                </h2>
                <a href="users.php" class="btn btn-outline-primary w-100">
                    Manage Users
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-4">
                <div class="dashboard-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <p class="text-muted mb-1">Total Materials</p>
                <h2 class="fw-bold mb-3">
                    <?= $materials_data["total_materials"] ?>
                </h2>
                <a href="materials.php" class="btn btn-outline-primary w-100">
                    Manage Materials
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-4">
                <div class="dashboard-icon">
                    <i class="bi bi-book"></i>
                </div>
                <p class="text-muted mb-1">Total Subjects</p>
                <h2 class="fw-bold mb-3">
                    <?= $subjects_data["total_subjects"] ?>
                </h2>
                <a href="subjects.php" class="btn btn-outline-primary w-100">
                    Manage Subjects
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-4">
                <div class="dashboard-icon">
                    <i class="bi bi-flag"></i>
                </div>
                <p class="text-muted mb-1">Reports</p>
                <h2 class="fw-bold mb-3">
                    <?= $reports_data["total_reports"] ?>
                </h2>
                <a href="reports.php" class="btn btn-outline-warning w-100">
                    View Reports
                </a>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body p-4">

        <div class="d-flex align-items-center gap-3">

            <div class="dashboard-icon dark mb-0 flex-shrink-0">
                <i class="bi bi-shield-check"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">
                    Platform Management
                </h5>
                <p class="text-muted mb-0">
                    Keep track of users, materials, subjects, and reported content.
                </p>
            </div>

        </div>

    </div>

</div>


</div>

<?php require_once "../includes/footer.php"; ?>
