<?php
// Connexion à la base de données
$SERVEUR = "mysql_serv";
$LOGIN = "adbneto";
$PASSW = "adbneto-rt2023";
$BD = "adbneto_05";
$co = mysqli_connect($SERVEUR, $LOGIN, $PASSW, $BD) or die("Impossible de se connecter à la base de données.");

// Récupérer les valeurs des critères de recherche depuis la requête POST
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$groupe = $_POST['groupe'] ?? '';

// Requête pour récupérer les températures médianes des groupes en fonction des critères de recherche
$query = "SELECT groupe, ROUND(MEDIAN(Temperature), 2) AS median_temperature 
          FROM Etudiant 
          JOIN Temperature ON Etudiant.idE = Temperature.idE 
          WHERE 1=1"; // Commencez avec une condition 1=1 pour permettre l'ajout dynamique de clauses WHERE

// Ajoutez des conditions WHERE en fonction des critères de recherche s'ils sont renseignés
if (!empty($nom)) {
    $query .= " AND Etudiant.Nom LIKE '%$nom%'";
}
if (!empty($prenom)) {
    $query .= " AND Etudiant.Prenom LIKE '%$prenom%'";
}
if (!empty($groupe)) {
    $query .= " AND Etudiant.groupe LIKE '%$groupe%'";
}

$query .= " GROUP BY Etudiant.groupe"; // Regroupez les résultats par groupe

$result = mysqli_query($co, $query) or die("Erreur dans la requête $query");

$groupTemperatures = [];
while ($row = mysqli_fetch_assoc($result)) {
    $groupTemperatures[$row['groupe']] = $row['median_temperature'];
}

// Fermer la connexion à la base de données
mysqli_close($co);

// Renvoyer les températures médianes sous forme de réponse JSON
echo json_encode($groupTemperatures);
?>
