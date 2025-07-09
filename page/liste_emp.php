<?php
    include "../inc/function.php";
    $dept_no = $_GET['dept_no'];
    $dept_emp = select_dept_emp($dept_no);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <title>Document</title>
</head>
<body>
    <main class="container mt-4">
        <h2 class="mb-4">Liste des employees</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($dept_employees = mysqli_fetch_assoc($dept_emp)) { ?>
                <div class="col">
                    <a href="fiche.php?emp_no=<?php echo $dept_employees['emp_no']?>" class="card h-100 shadow-sm btn btn-outline-primary mt-2">
                        <div class="card-body">
                            <h5><strong><?php echo $dept_employees['first_name'];?> <?php echo $dept_employees['last_name'] ?></strong></h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>