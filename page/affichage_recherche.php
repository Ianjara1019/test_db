<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
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
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 5px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Résultats de Recherche</h1>
    <div id="results-container">
        <?php
        session_start();
        if (isset($_SESSION['search_results'])) {
            $data = $_SESSION['search_results'];
            if (count($data['results']) > 0) {
                echo '<table><thead><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Genre</th><th>Âge</th><th>Département</th><th>Titre</th><th>Salaire</th></tr></thead><tbody>';
                foreach ($data['results'] as $row) {
                    echo '<tr>
                        <td>' . htmlspecialchars($row['emp_no']) . '</td>
                        <td>' . htmlspecialchars($row['last_name']) . '</td>
                        <td>' . htmlspecialchars($row['first_name']) . '</td>
                        <td>' . ($row['gender'] === 'F' ? 'Féminin' : 'Masculin') . '</td>
                        <td>' . htmlspecialchars($row['age']) . '</td>
                        <td>' . (isset($row['dept_name']) ? htmlspecialchars($row['dept_name']) : 'N/A') . '</td>
                        <td>' . (isset($row['title']) ? htmlspecialchars($row['title']) : 'N/A') . '</td>
                        <td>' . (isset($row['salary']) ? number_format($row['salary'], 0, ',', ' ') . ' €' : 'N/A') . '</td>
                    </tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Aucun résultat trouvé.</p>';
            }
        } else {
            echo '<p>Aucune recherche effectuée.</p>';
        }
        ?>
    </div>
    <div class="pagination" id="pagination">
        <?php
        if (isset($_SESSION['search_results'])) {
            $data = $_SESSION['search_results'];
            $totalPages = ceil($data['total_results'] / $data['results_per_page']);
            $currentPage = $data['page'];
            $searchParams = $data['search_params'];
            
            $baseUrl = "affichage_recherche.php?" . http_build_query($searchParams);

            if ($currentPage > 1) {
                echo '<a href="' . $baseUrl . '&page=' . ($currentPage - 1) . '">Précédent</a>';
            }
            if ($currentPage < $totalPages) {
                echo '<a href="' . $baseUrl . '&page=' . ($currentPage + 1) . '">Suivant</a>';
            }
        }
        ?>
    </div>
</body
</body>
</html>