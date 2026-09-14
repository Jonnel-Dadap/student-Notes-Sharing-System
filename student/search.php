<?php

$conn = require("../config/database.php");
require_once "../includes/auth_check.php";
$search = trim($_GET["search"] ?? "");
$subject_id = $_GET["subject_id"] ?? "";
$subjects_sql = "SELECT * FROM subjects ORDER BY subject_name ASC";
$subjects_result = mysqli_query($conn, $subjects_sql);
$result = null;
if ($search !== "" || $subject_id !== "") {

    $sql = "SELECT materials.*, subjects.subject_name, users.name
            FROM materials
            INNER JOIN subjects ON materials.subject_id = subjects.id
            INNER JOIN users ON materials.user_id = users.id
            WHERE 1=1";
    $params = [];
    $types = "";
    if ($search !== "") {
        $sql .= " AND (materials.title LIKE ? OR materials.description LIKE ?)";
        $search_term = "%" . $search . "%";
        $params[] = $search_term;
        $params[] = $search_term;
        $types .= "ss";
    }
    if ($subject_id !== "") {
        $sql .= " AND materials.subject_id = ?";
        $params[] = $subject_id;
        $types .= "i";
    }
    $sql .= " ORDER BY materials.created_at DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        $types,
        ...$params
    );
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
}
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="container py-5">
<div class="mb-4">
    <p class="text-primary fw-semibold mb-1">
        STUDY LIBRARY
    </p>
    <h2 class="fw-bold mb-2">
        Search Materials
    </h2>
    <p class="text-muted">
        Find notes, reviewers, and other study materials.
    </p>
</div>
<div class="card shadow-sm mb-5">
    <div class="card-body p-4">
        <form method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-lg-6">
                    <label class="form-label fw-semibold">
                        Search
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by title or description..."
                            value="<?= htmlspecialchars($search) ?>"
                        >
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">
                        Subject
                    </label>
                    <select name="subject_id" class="form-select">
                        <option value="">
                            All Subjects
                        </option>
                        <?php while ($subject = mysqli_fetch_assoc($subjects_result)): ?>
                            <option
                                value="<?= $subject["id"] ?>"
                                <?= $subject_id == $subject["id"] ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars($subject["subject_name"]) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button
                        type="submit"
                        class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if ($result !== null): ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Search Results</h5>
                <p class="text-muted small mb-0">
                    <?= mysqli_num_rows($result) ?> material(s) found.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php while ($material = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="dashboard-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <span class="badge text-bg-light border align-self-start mb-3">
                                <?= htmlspecialchars($material["subject_name"]) ?>
                            </span>
                            <h5 class="card-title mb-2">
                                <a
                                    href="material.php?id=<?= $material["id"] ?>"
                                    class="text-decoration-none text-dark"
                                >
                                    <?= htmlspecialchars($material["title"]) ?>
                                </a>
                            </h5>
                            <p class="text-muted small mb-3">
                                <?= htmlspecialchars($material["description"]) ?>
                            </p>
                            <div class="mt-auto">
                                <div class="small text-muted mb-3">
                                    <div class="mb-1">
                                        <i class="bi bi-person me-1"></i>
                                        <?= htmlspecialchars($material["name"]) ?>
                                    </div>
                                    <div>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?= date("M d, Y", strtotime($material["created_at"])) ?>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a
                                        href="material.php?id=<?= $material["id"] ?>"
                                        class="btn btn-outline-primary flex-grow-1"
                                    > View</a>
                                    <a href="../<?= htmlspecialchars($material["file_path"]) ?>"
                                        class="btn btn-primary"
                                        download
                                        title="Download" >
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div class="dashboard-icon mx-auto">
                    <i class="bi bi-search"></i>
                </div>
                <h5 class="fw-bold">
                    No materials found
                </h5>
                <p class="text-muted mb-0">
                    Try a different keyword or select another subject.
                </p>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <div class="dashboard-icon mx-auto">
                <i class="bi bi-journal-bookmark"></i>
            </div>
            <h5 class="fw-bold">
                Find your study materials
            </h5>
            <p class="text-muted mb-0">
                Enter a keyword or choose a subject to start searching.
            </p>
        </div>
    </div>
<?php endif; ?>
</div>
<?php require_once "../includes/footer.php"; ?>
