<?php

$conn = require("../config/database.php");
require_once "../includes/admin_check.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: materials.php");
    exit;
}

$sql = "SELECT file_path FROM materials WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$material = mysqli_fetch_assoc($result);

if (!$material) {
    header("Location: materials.php");
    exit;
}
$file_path = "../" . $material["file_path"];

if (file_exists($file_path)) {
    unlink($file_path);
}

$sql = "DELETE FROM materials WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
header("Location: materials.php");
exit;
