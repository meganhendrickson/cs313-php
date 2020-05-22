

<?php

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/connections.php';

function getAllClientBudgets($clientId){
  $db = dbConnection();
  $sql = 'SELECT * FROM budget WHERE clientId';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $clientBudget = $stmt->fetchAll();
  $stmt->closeCursor();
  return $clientBudget;
}

// Build dashboard summary display
function buildDashboardSummary(){
  $clientBudgets = getAllClientBudgets();
  $dash = "<div class='dashdisplay'>";
  foreach ($clientBudgets as $budget){
    $budgetName=$budget['budgetName'];
    $budgetAmount=$budget['budgetAmount'];
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<p>$budgetName</p>";
    $dash .= "<p>&#36;$budgetAmount</p>";
    $dash .= "</div>";
  }
  $dash .= "</div>";
  return $dash;
}

?>