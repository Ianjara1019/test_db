<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Recherche d'Employes</title>
</head>
<body>
    <div class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a href="page/liste_dept.php" class="navbar-brand d-flex align-items-cemter">
                <span class="fw-bold">Liste des departements</span>
            </a>
        </div>
    </div>
    <h1>Recherche d'Employes</h1>
    <div class="search-form">
        <form action="page/traitement_recherche.php" method="get">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" placeholder="Nom de famille">
            </div>
            <div class="form-group">
                <label for="prenom">Prenom :</label>
                <input type="text" name="prenom" id="prenom" placeholder="Prenom">
            </div>
            <div class="form-group">
                <label for="dept">Departement :</label>
                <input type="text" name="dept" id="dept" placeholder="Numero ou nom">
            </div>
            <div class="form-group">
                <label for="age_min">Âge min :</label>
                <input type="number" name="age_min" id="age_min" min="18" max="100" placeholder="18">
            </div>
            <div class="form-group">
                <label for="age_max">Âge max :</label>
                <input type="number" name="age_max" id="age_max" min="18" max="100" placeholder="65">
            </div>
            <div class="form-group">
                <label>Genre :</label>
                <input type="checkbox" name="genre[]" id="genre_f" value="F"> <label for="genre_f" style="width: auto;">Feminin</label>
                <input type="checkbox" name="genre[]" id="genre_m" value="M"> <label for="genre_m" style="width: auto;">Masculin</label>
            </div>
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre" placeholder="Poste ou fonction">
            </div>
            <div class="form-group">
                <label for="salaire_min">Salaire min :</label>
                <input type="number" name="salaire_min" id="salaire_min" min="0" placeholder="€">
            </div>
            <input type="submit" value="Rechercher">
        </form>
    </div>
</body>
</html>