<?php
// Connexion à la base de données
// Récupérer les valeurs des critères de recherche depuis la requête POST
require_once "../Source/Core/Query.php";
error_reporting(E_ALL);

ini_set('display_errors', 1);
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$groupe = $_POST['groupe'] ?? '';

$students = queryetudiant($pdo);

$historique=queryHistorique($pdo,$nom,$prenom);

?>
