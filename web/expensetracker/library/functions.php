

<?php

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/connections.php';

function getClientBudgets($clientId){
  $db = dbConnection();
  $sql = 'SELECT * FROM budget WHERE clientId = :clientId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
  $stmt->execute();
  $clientBudgets = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $clientBudgets;
}

// Build dashboard summary display
function buildDashDisplay($clientBudgets){
  foreach ($clientBudgets as $budget){
    $name=$budget['budgetName'];
    $amount=$budget['budgetAmount'];
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<p>$name</p>";
    $dash .= "<p>&#36;$amount</p>";
    $dash .= "</div>";
  }
  return $dash;
}

?>