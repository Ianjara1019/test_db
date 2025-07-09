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
    <title>Nombre d'employés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        center {
            margin-top: 50px;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: #fff;
        }
        td {
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <a href="liste_dept.php">Retour</a>
    <center>
        <table>
            <tr>
                <th>Nombre d'employés</th>
                <th>Hommes</th>
                <th>Femmes</th>
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