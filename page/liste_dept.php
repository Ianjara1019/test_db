<?php
include '../inc/function.php';
$departement = select_dept_manager();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap-icons/font/bootstrap-icons.css">
    <title>TEST DB</title>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Liste des départements</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($dept = mysqli_fetch_assoc($departement)) { ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-building me-2"></i>
                                <?php echo $dept['dept_name'] ?>
                            </h5>
                            <p><strong>Manager: <?php echo $dept['manager_first_name'] ?> <?php echo $dept['manager_last_name'] ?></strong></p>
                            <p>Nombre employes: <?php echo $dept['nb_employee'] ?> </p>
                            <a href="liste_emp.php?dept_no=<?php echo $dept['dept_no'] ?>" class="btn btn-outline-primary mt-2">
                                Voir employees
                            </a>
                            <a href="nb_emp.php?dept_no=<?php echo $dept['dept_no'] ?>" class="btn btn-outline-primary mt-2">
                                Voir nombre employees
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>