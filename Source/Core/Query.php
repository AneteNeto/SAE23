<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "Connect.php";

// PDO Connection
$pdo=Connect::getInstance();
function queryetudiant($pdo){

    $sql = "SELECT * from Etudiant";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// QUERY HISTORIQUE
function queryHistorique($pdo, int $id) {
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
function queryInformationJour($pdo,int $id) {
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


  

