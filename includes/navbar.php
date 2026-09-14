<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container py-2">
        <a class="navbar-brand fw-bold" href="/StudyShare/">
            StudyShare
        </a>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <?php if (isset($_SESSION["user_id"])): ?>
                <?php if ($_SESSION["role"] === "admin"): ?>
                    <a
                        href="/StudyShare/admin/dashboard.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Dashboard
                    </a>
                    <a
                        href="/StudyShare/admin/materials.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Materials
                    </a>
                    <a
                        href="/StudyShare/admin/reports.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Reports
                    </a>
                    <a
                        href="/StudyShare/admin/users.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Users
                    </a>
                    <a
                        href="/StudyShare/admin/subjects.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Subjects
                    </a>
                <?php else: ?>
                    <a
                        href="/StudyShare/student/dashboard.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Dashboard
                    </a>
                    <a
                        href="/StudyShare/student/subjects.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Subjects
                    </a>
                    <a
                        href="/StudyShare/student/search.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        Search
                    </a>
                    <a
                        href="/StudyShare/student/my_materials.php"
                        class="btn btn-outline-light btn-sm"
                    >
                        My Materials
                    </a>
                    <a
                        href="/StudyShare/student/upload.php"
                        class="btn btn-primary btn-sm"
                    >
                        Upload
                    </a>
                <?php endif; ?>
                <span class="text-white-50 small px-1">
                    <?= htmlspecialchars($_SESSION["name"]) ?>
                </span>
                <a
                    href="/StudyShare/auth/logout.php"
                    class="btn btn-danger btn-sm"
                >
                    Logout
                </a>
            <?php else: ?>
                <a
                    href="/StudyShare/auth/login.php"
                    class="btn btn-outline-light btn-sm"
                >
                    Login
                </a>

                <a
                    href="/StudyShare/auth/register.php"
                    class="btn btn-primary btn-sm"
                >
                    Register
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>