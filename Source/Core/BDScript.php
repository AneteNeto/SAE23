<?php

require "ApiWeather.php";
require "Csv.php";
require "Connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);


$connection=Connect::getInstance();
// Clear the Etudiant table
$deleteEtudiant = "TRUNCATE TABLE Etudiant";
$connection->exec($deleteEtudiant);

// Reading CSV file
$csvFile = new Csv("../../config/BUT1.csv");
$csvFile->read();
$csvData = $csvFile->getData();

foreach ($csvData as $student) {
    $nom = $student['Nom'];
    $prenom = $student['Prenom'];
    $groupe = $student['groupe'];
    $villeP = $student['VilleP'];
    $cpp = $student['CPP'];
    $villeS = $student['VilleS'];
    $cps = $student['CPS'];

    $residences = [];

    // Process each primary and secondary city
    $cities = [$villeP => $cpp, $villeS => $cps];
    foreach ($cities as $ville => $codePostal) {
        if (!empty($ville)) {
            $stmt = $connection->prepare("SELECT IdR FROM Residence WHERE Ville = ? AND CodePostal = ?");
            $stmt->execute([$ville, $codePostal]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $idResidence = $row['IdR'];
                $residences[] = $idResidence;
            } else {
                $stmt = $connection->prepare("INSERT INTO Residence (Ville, CodePostal) VALUES (?, ?)");
                $stmt->execute([$ville, $codePostal]);
                $residences[] = $connection->lastInsertId();
            }

            // Retrieve or Insert weather data
            $meteo = new ApiWeather();
            $meteoData = $meteo->callApi($ville);
            $dateFormatted = date('Y-m-d', $meteoData['date']);
            $dateFormatted2 = date('Y-m-d H:i:s', $meteoData['date']);

            $stmt = $connection->prepare("SELECT IdM FROM Mesure WHERE IdR = ? AND DATE(Date) = ?");
            $stmt->execute([$idResidence, $dateFormatted]);
            $result2 = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result2) {
                $stmt = $connection->prepare("INSERT INTO Mesure (IdR, Temperature, Description, VentVitesse, Date, Icone) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$idResidence, $meteoData['temp'], $meteoData['description'], $meteoData['vent'], $dateFormatted2, $meteoData['icon']]);
            }
        }
    }

    // Insert student data based on the number of residences
    if (count($residences) >= 2) {
        $stmt = $connection->prepare("INSERT INTO Etudiant (Nom, Prenom, VilleDomicileP, VilleDomicileS, groupe) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $residences[0], $residences[1], $groupe]);
    } elseif (count($residences) == 1) {
        $stmt = $connection->prepare("INSERT INTO Etudiant (Nom, Prenom, VilleDomicileP, groupe) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $residences[0], $groupe]);
    }
}
?>

