<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "Connect.php";

// PDO Connection

//query etudiant + meteo
function queryetudiant() {
    $pdo=Connect::getInstance();
    $sql = "SELECT E.idE, E.Nom, E.Prenom, E.groupe, GROUP_CONCAT(R.Ville) AS Villes, GROUP_CONCAT(M.Description) AS Descriptions, GROUP_CONCAT(M.Temperature) AS Temperatures,
            GROUP_CONCAT(M.VentVitesse) AS VitesseVents, GROUP_CONCAT(M.Icone) AS Icones, GROUP_CONCAT(M.Date) AS Dates
            FROM Etudiant AS E 
            JOIN Residence AS R ON E.VilleDomicileP = R.IdR OR E.VilleDomicileS = R.IdR
            LEFT JOIN Mesure AS M ON R.IdR = M.IdR AND DATE(M.Date) = CURRENT_DATE
            GROUP BY E.idE";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// QUERY HISTORIQUE
function queryHistorique(int $id) {
    $pdo=Connect::getInstance();
    $sql = "SELECT R.Ville, M.Description, M.Temperature,
    M.VentVitesse, M.Icone, M.Date 
    FROM Mesure AS M 
    JOIN Residence AS R ON M.IdR = R.IdR 
    JOIN Etudiant AS E ON R.IdR IN (E.VilleDomicileP, E.VilleDomicileS)
    WHERE E.idE = :id
    ORDER BY Date DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' =>$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// QUERY INFORMATION JOUR
function queryInformationJour(int $id) {
    $pdo=Connect::getInstance();
    $sql = "SELECT R.Ville, M.Description, M.Temperature,
            M.VentVitesse, M.Icone, M.Date 
            FROM Mesure AS M 
            JOIN Residence AS R ON M.IdR = R.IdR 
            JOIN Etudiant AS E ON R.IdR IN (E.VilleDomicileP, E.VilleDomicileS)
            WHERE E.idE = :id 
            AND DATE(M.Date) = CURRENT_DATE";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' =>$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// QUERY AVERAGE GROUPE
function queryAverageGroupe($pdo,string $groupe) {
    $sql = "SELECT AVG(M.Temperature) AS M_Temp, AVG(M.VentVitesse) AS M_Vent
            FROM Mesure AS M 
            JOIN Residence AS R ON M.IdR = R.IdR 
            JOIN Etudiant AS E ON R.IdR IN (E.VilleDomicileP, E.VilleDomicileS)
            WHERE E.groupe = :groupe";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['groupe' => $groupe]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>