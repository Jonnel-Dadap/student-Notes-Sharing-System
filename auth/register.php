<?php
$conn = require("../config/database.php");
$message = "";
$message_type = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    if ($name === "" || $email === "" || $password === "") {
        $message = "All fields are required.";
        $message_type = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $message_type = "danger";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
        $message_type = "danger";
    } else {
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {

            $message = "Email is already registered.";
            $message_type = "danger";
        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO users (name, email, password)
                    VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $name,
                $email,
                $hashed_password
            );
            if (mysqli_stmt_execute($stmt)) {

                $message = "Registration successful. You can now login.";
                $message_type = "success";

            } else {

                $message = "Registration failed.";
                $message_type = "danger";
            }
        }
    }
}
?>
<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<div class="auth-page">
    <div class="auth-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold">
                Create Account
            </h2>
            <p class="text-muted mb-0">
                Join StudyShare and share your study materials
            </p>
        </div>
        <?php if ($message): ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">  Name </label>
                <input
                    type="text"
                    name="name"
                    class="form-control form-control-lg"
                    placeholder="Enter your name"
                    required
                >
            </div>
            <div class="mb-3">
                <label class="form-label"> Email </label>
                <input
                    type="email"
                    name="email"
                    class="form-control form-control-lg"
                    placeholder="Enter your email"
                    required
                >
            </div>
            <div class="mb-4">
                <label class="form-label">  Password </label>
                <input
                    type="password"
                    name="password"
                    class="form-control form-control-lg"
                    placeholder="At least 6 characters"
                    minlength="6"
                    required
                >
            </div>
            <button
                type="submit"
                class="btn btn-primary btn-lg w-100"
            >
                Create Account
            </button>
        </form>
        <p class="text-center text-muted mt-4 mb-0">
            Already have an account?
            <a href="login.php" class="text-decoration-none fw-semibold">  Login </a>
        </p>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>