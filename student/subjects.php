<?php

$conn = require("../config/database.php");
require_once "../includes/auth_check.php";

$sql = "SELECT * FROM subjects ORDER BY subject_name ASC";
$result = mysqli_query($conn, $sql);

?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container mt-5">
    

    <h2 class="mb-4">Subjects</h2>

    <div class="row">

        <?php while ($subject = mysqli_fetch_assoc($result)): ?>

            <div class="col-md-4 mb-3">

                <div class="card">
                    <div class="card-body">
         <i class="bi bi-folder fs-1 text-dark"></i>
                        <h5 class="card-title">
                            <?= htmlspecialchars($subject["subject_name"]) ?> 
                        </h5>
                         
                          

                        <a href="materials.php?subject_id=<?= $subject["id"] ?>" class="btn btn-primary">
                            View Materials
                        </a>

                    </div>
                </div>

            </div>

        <?php endwhile; ?>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>