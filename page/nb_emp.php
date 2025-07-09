<?php
    include("../inc/function.php");
    $dept_no = $_GET['dept_no'];
    $nb_emp = mysqli_fetch_assoc(nb_employee($dept_no));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="liste_dept.php">Retour</a>
    <center>
        <table border="1px">
            <tr>
                <th>Nombre employee</th>
                <th>Homme</th>
                <th>Femme</th>
            </tr>
            <tr>
                <td><?php echo $nb_emp['nb_employee']?></td>
                <td><?php echo $nb_emp['nb_homme']?></td>
                <td><?php echo $nb_emp['nb_femme']?></td>
            </tr>
        </table>
    </center>
</body>
</html>