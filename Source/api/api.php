<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../Core/Query.php';

header('Content-Type: application/json');

$aResult = array();

if (!isset($_POST['function_name'])) {
  $aResult['error'] = 'No function name!';
}

if (!isset($aResult['error'])) {
  switch ($_POST['function_name']) {
    case 'get-student':
      $aResult['result'] = queryEtudiant($_POST['arguments']['nom'], $_POST['arguments']['prenom'], $_POST['arguments']['groupe']);
      break;
      case 'get-historique':
        $aResult['result'] = queryHistorique($_POST['arguments']['studentId']);
        break;
      case 'get-average':
        $aResult['result'] = queryAverageGroupe($_POST['arguments']['groupe']);
        break;
    default:
      $aResult['error'] = 'Not found function!';
      break;
  }
}

echo json_encode($aResult);
