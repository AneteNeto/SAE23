<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant</title>
</head>
<body>
    <h2>Ajouter un étudiant</h2>
    <form action="ajouter_etudiant.php" method="POST">
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="residence_principale">Adresse résidence principale :</label><br>
        <input type="text" id="residence_principale" name="residence_principale" required><br><br>

        <label for="date_debut_principale">Date de début résidence principale :</label><br>
        <input type="date" id="date_debut_principale" name="date_debut_principale" required><br><br>

        <label for="date_fin_principale">Date de fin résidence principale :</label><br>
        <input type="date" id="date_fin_principale" name="date_fin_principale" required><br><br>

        <label for="residence_secondaire">Adresse résidence secondaire :</label><br>
        <input type="text" id="residence_secondaire" name="residence_secondaire"><br><br>

        <label for="date_debut_secondaire">Date de début résidence secondaire :</label><br>
        <input type="date" id="date_debut_secondaire" name="date_debut_secondaire"><br><br>

        <label for="date_fin_secondaire">Date de fin résidence secondaire :</label><br>
        <input type="date" id="date_fin_secondaire" name="date_fin_secondaire"><br><br>

        <input type="submit" value="Ajouter">
    </form>
</body>
</html>