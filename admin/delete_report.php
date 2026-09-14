<?php

$conn = require("../config/database.php");
require_once "../includes/admin_check.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: reports.php");
    exit;
}
$sql = "DELETE FROM reports WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

header("Location: reports.php");
exit;