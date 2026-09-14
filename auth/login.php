<?php
$conn = require("../config/database.php");
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] === "admin") {
                header("Location: ../admin/dashboard.php");
                exit;
            }
            header("Location: ../student/dashboard.php");
            exit;
        } else {

            $message = "Invalid email or password.";
        }

    } else {

        $message = "Invalid email or password.";
    }
}
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>

<div class="auth-page">
    <div class="auth-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold">
                Welcome Back
            </h2>
            <p class="text-muted mb-0">
                Login to your StudyShare account
            </p>
        </div>
        <?php if ($message): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">
                    Email
                </label>
                <input type="email"  name="email"   class="form-control form-control-lg"  placeholder="Enter your email"   required >
            </div>
            <div class="mb-4">
                <label class="form-label"> Password </label>
                <input  type="password"  name="password"  class="form-control form-control-lg"   placeholder="Enter your password"  required >
            </div>
            <button  type="submit"  class="btn btn-primary btn-lg w-100"> Login </button>
        </form>
        <p class="text-center text-muted mt-4 mb-0">
            Don't have an account?
            <a href="register.php" class="text-decoration-none fw-semibold">
                Register </a>
        </p>
    </div>
</div>
<?php require_once "../includes/footer.php"; ?>