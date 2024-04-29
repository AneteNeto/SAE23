<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant</title>
</head>
<body>
    <h1>Ajouter un étudiant</h1>
    <form action="script_add_student.php" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="adresse_principale">Adresse Résidence Principale :</label>
        <input type="text" id="adresse_principale" name="adresse_principale" required><br>

        <label for="date_debut_principale">Date de Début Résidence Principale :</label>
        <input type="date" id="date_debut_principale" name="date_debut_principale" required><br>

        <label for="date_fin_principale">Date de Fin Résidence Principale :</label>
        <input type="date" id="date_fin_principale" name="date_fin_principale" required><br>

        <label for="adresse_secondaire">Adresse Résidence Secondaire :</label>
        <input type="text" id="adresse_secondaire" name="adresse_secondaire"><br>

        <label for="date_debut_secondaire">Date de Début Résidence Secondaire :</label>
        <input type="date" id="date_debut_secondaire" name="date_debut_secondaire"><br>

        <label for="date_fin_secondaire">Date de Fin Résidence Secondaire :</label>
        <input type="date" id="date_fin_secondaire" name="date_fin_secondaire"><br>

        <input type="submit" value="Ajouter Étudiant">
    </form>
</body>
</html>
