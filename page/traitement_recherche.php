<?php
    require_once('../inc/function.php');

    $conn = dbconnect();
    if (!$conn) {
        die("Erreur de connexion à la base de donnees");
    }

    $nom = isset($_GET['nom']) ? trim(mysqli_real_escape_string($conn, $_GET['nom'])) : '';
    $prenom = isset($_GET['prenom']) ? trim(mysqli_real_escape_string($conn, $_GET['prenom'])) : '';
    $dept = isset($_GET['dept']) ? trim(mysqli_real_escape_string($conn, $_GET['dept'])) : '';
    $age_min = isset($_GET['age_min']) ? intval($_GET['age_min']) : null;
    $age_max = isset($_GET['age_max']) ? intval($_GET['age_max']) : null;
    $genres = isset($_GET['genre']) ? $_GET['genre'] : [];
    $titre = isset($_GET['titre']) ? trim(mysqli_real_escape_string($conn, $_GET['titre'])) : '';
    $salaire_min = isset($_GET['salaire_min']) ? intval($_GET['salaire_min']) : null;

    $sql = "SELECT e.emp_no, e.first_name, e.last_name, e.gender, e.birth_date, TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) AS age,d.dept_name,t.title,s.salary
            FROM employees e
            LEFT JOIN dept_emp de ON e.emp_no = de.emp_no AND de.to_date > CURDATE()
            LEFT JOIN departments d ON de.dept_no = d.dept_no
            LEFT JOIN titles t ON e.emp_no = t.emp_no AND t.to_date > CURDATE()
            LEFT JOIN salaries s ON e.emp_no = s.emp_no AND s.to_date > CURDATE()";

    $conditions = [];

    if (!empty($nom)) {
        $conditions[] = "e.last_name LIKE '%" . mysqli_real_escape_string($conn, $nom) . "%'";
    }

    if (!empty($prenom)) {
        $conditions[] = "e.first_name LIKE '%" . mysqli_real_escape_string($conn, $prenom) . "%'";
    }

    if (!empty($dept)) {
        if (is_numeric($dept)) {
            $conditions[] = "d.dept_no = '" . mysqli_real_escape_string($conn, $dept) . "'";
        } else {
            $conditions[] = "d.dept_name LIKE '%" . mysqli_real_escape_string($conn, $dept) . "%'";
        }
    }

    if ($age_min !== null) {
        $conditions[] = "TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) >= " . intval($age_min);
    }

    if ($age_max !== null) {
        $conditions[] = "TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) <= " . intval($age_max);
    }

    if (!empty($genres)) {
        $safe_genres = array_map(function($g) use ($conn) {
            return mysqli_real_escape_string($conn, $g);
        }, $genres);

        $conditions[] = "e.gender IN ('" . implode("','", $safe_genres) . "')";
    }

    if (!empty($titre)) {
        $conditions[] = "t.title LIKE '%" . mysqli_real_escape_string($conn, $titre) . "%'";
    }

    if ($salaire_min !== null) {
        $conditions[] = "s.salary >= " . intval($salaire_min);
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY e.last_name, e.first_name";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Erreur dans la requête SQL: " . mysqli_error($conn));
    }

    $results = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultats de Recherche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .results-container {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .no-results {
            color: #666;
            font-style: italic;
        }
        .search-criteria {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .criteria-item {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Resultats de Recherche</h1>
    
    <div class="search-criteria">
        <h2>Criteres de recherche :</h2>
        <?php
        if (!empty($nom)) echo "<div class='criteria-item'><strong>Nom :</strong> $nom</div>";
        if (!empty($prenom)) echo "<div class='criteria-item'><strong>Prenom :</strong> $prenom</div>";
        if (!empty($dept)) echo "<div class='criteria-item'><strong>Departement :</strong> $dept</div>";
        if ($age_min !== null) echo "<div class='criteria-item'><strong>Âge minimum :</strong> $age_min ans</div>";
        if ($age_max !== null) echo "<div class='criteria-item'><strong>Âge maximum :</strong> $age_max ans</div>";
        if (!empty($genres)) {
            $genres_display = implode(', ', array_map(function($g) { return $g == 'F' ? 'Feminin' : 'Masculin'; }, $genres));
            echo "<div class='criteria-item'><strong>Genre(s) :</strong> $genres_display</div>";
        }
        if (!empty($titre)) echo "<div class='criteria-item'><strong>Titre :</strong> $titre</div>";
        if ($salaire_min !== null) echo "<div class='criteria-item'><strong>Salaire minimum :</strong> $salaire_min €</div>";
        ?>
    </div>
    
    <div class="results-container">
        <h2><?php echo count($results); ?> resultat(s) trouve(s)</h2>
        
        <?php if (count($results) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Genre</th>
                        <th>Âge</th>
                        <th>Departement</th>
                        <th>Titre</th>
                        <th>Salaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['emp_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo $row['gender'] == 'F' ? 'Feminin' : 'Masculin'; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo htmlspecialchars($row['dept_name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['title'] ?? 'N/A'); ?></td>
                            <td><?php echo isset($row['salary']) ? number_format($row['salary'], 0, ',', ' ') . ' €' : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-results">Aucun employe ne correspond à vos critères de recherche.</p>
        <?php endif; ?>
    </div>
    
    <p><a href="../index.php">Nouvelle recherche</a></p>
</body>
</html>