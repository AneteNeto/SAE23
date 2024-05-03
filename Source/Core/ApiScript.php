<?php
//Obtém a conexão PDO usando o Singleton Connect
require "ApiWeather.php";
require "Connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$pdo = Connect::getInstance();
$stmt = $pdo->prepare("SELECT IdR,Ville FROM Residence");
$stmt->execute(); // Executa a query

// Buscar todos os resultados
$results = $stmt->fetchAll();

// Exemplo de como exibir os resultados
foreach ($results as $row) {
    // Retrieve or Insert weather data
    $meteo = new ApiWeather();
    $meteoData = $meteo->callApi($row['Ville']);
    $dateFormatted = date('Y-m-d', $meteoData['date']);
    $dateFormatted2 = date('Y-m-d H:i:s', $meteoData['date']);

    $stmt = $pdo->prepare("SELECT IdM FROM Mesure WHERE IdR = ? AND DATE(Date) = ?");
    $stmt->execute([$row['IdR'], $dateFormatted]);
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result2) {
        $stmt = $pdo->prepare("INSERT INTO Mesure (IdR, Temperature, Description, VentVitesse, Date, Icone) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$row['IdR'], $meteoData['temp'], $meteoData['description'], $meteoData['vent'], $dateFormatted2, $meteoData['icon']]);
    }
}
