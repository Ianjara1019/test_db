<?php
session_start(); // Démarrer la session
require_once('../inc/function.php');

$conn = dbconnect();
if (!$conn) {
    die("Erreur de connexion à la base de donnees");
}

// Récupération des paramètres de recherche (identique à votre code actuel)
$nom = isset($_GET['nom']) ? trim(mysqli_real_escape_string($conn, $_GET['nom'])) : '';
$prenom = isset($_GET['prenom']) ? trim(mysqli_real_escape_string($conn, $_GET['prenom'])) : '';
$dept = isset($_GET['dept']) ? trim(mysqli_real_escape_string($conn, $_GET['dept'])) : '';
$age_min = isset($_GET['age_min']) ? intval($_GET['age_min']) : null;
$age_max = isset($_GET['age_max']) ? intval($_GET['age_max']) : null;
$genres = isset($_GET['genre']) ? $_GET['genre'] : [];
$titre = isset($_GET['titre']) ? trim(mysqli_real_escape_string($conn, $_GET['titre'])) : '';
$salaire_min = isset($_GET['salaire_min']) ? intval($_GET['salaire_min']) : null;

// Pagination (identique à votre code actuel)
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$results_per_page = 20;
$offset = ($page - 1) * $results_per_page;

// Construction de la requête SQL (identique à votre code actuel)
$sql = "SELECT e.emp_no, e.first_name, e.last_name, e.gender, e.birth_date, TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) AS age, d.dept_name, t.title, s.salary
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

$sql .= " ORDER BY e.last_name, e.first_name LIMIT $results_per_page OFFSET $offset";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erreur dans la requête SQL: " . mysqli_error($conn));
}

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// Compter le nombre total de résultats (identique à votre code actuel)
$count_sql = "SELECT COUNT(*) AS total FROM employees e
              LEFT JOIN dept_emp de ON e.emp_no = de.emp_no AND de.to_date > CURDATE()
              LEFT JOIN departments d ON de.dept_no = d.dept_no
              LEFT JOIN titles t ON e.emp_no = t.emp_no AND t.to_date > CURDATE()
              LEFT JOIN salaries s ON e.emp_no = s.emp_no AND s.to_date > CURDATE()";

if (!empty($conditions)) {
    $count_sql .= " WHERE " . implode(" AND ", $conditions);
}

$count_result = mysqli_query($conn, $count_sql);
$total_results = mysqli_fetch_assoc($count_result)['total'];

// Stocker les résultats dans la session
$_SESSION['search_results'] = [
    'results' => $results,
    'total_results' => $total_results,
    'page' => $page,
    'results_per_page' => $results_per_page,
    'search_params' => $_GET // Stocker les paramètres de recherche pour la pagination
];

// Rediriger vers affichage_recherche.php
header("Location: affichage_recherche.php");
exit();
?>