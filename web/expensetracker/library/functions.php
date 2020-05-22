

<?php

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/connections.php';

function getAllClientBudgets(){
  $db = dbConnection();
  $sql = 'SELECT * FROM budget WHERE clientId = 1';
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
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<p>$budget[budgetName]</p>";
    $dash .= "<p>$budget[budgetAmount]</p>";
    $dash .= "</div>";
  }
  $dash .= "</div>";
  return $dash;
}

?>