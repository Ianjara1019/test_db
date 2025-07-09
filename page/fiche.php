<?php
    include "../inc/function.php";
    $emp_no = $_GET['emp_no'];
    $emp_info = mysqli_fetch_assoc(fiche_emp($emp_no));
    $salaire_query = salaries($emp_no);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <title>Fiche</title>
</head>
<body>
    <div class="card h-100 shadow-sm text-center">
        <div class="card-body">
            <h5 class="card-title">
                <strong>Nom : </strong> <?php echo $emp_info['first_name'];?> <?php echo $emp_info['last_name'] ?>
            </h5>
            <hr><br>
            <h5>
                <strong>Sexe : </strong> <?php echo $emp_info['gender']?>
            </h5>
            <h5>
                <strong>Hire date : </strong> <?php echo $emp_info['hire_date'] ?>
            </h5>
            <hr>
            <h5>Salaire : </h5>
            <?php while ($salaire = mysqli_fetch_assoc($salaire_query)) {?>
                <h6><?php echo $salaire['salary']?> $</h6>    
            <?php }?>
        </div>
    </div>
</body>
</html>