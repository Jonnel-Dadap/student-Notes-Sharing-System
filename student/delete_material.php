
<?php
$conn = require("../config/database.php");
require_once "../includes/auth_check.php";
$user_id = $_SESSION["user_id"];
$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: my_materials.php");
    exit;
}
$sql = "SELECT file_path
        FROM materials
        WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$material = mysqli_fetch_assoc($result);
if (!$material) {
    header("Location: my_materials.php");
    exit;
}
$file_path = "../" . $material["file_path"];
if (file_exists($file_path)) {
    unlink($file_path);
}
$sql = "DELETE FROM materials
        WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
header("Location: my_materials.php");
exit;