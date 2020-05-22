

<?php

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/connections.php';

function getAllClientBudgets($clientId){
  $db = dbConnection();
  $sql = 'SELECT * FROM budget WHERE clientId = :clientId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientId', $reviewId, PDO::PARAM_INT);
  $stmt->execute();
  $clientBudget = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $clientBudgets;
}

// Build dashboard summary display
function buildDashboardSummary(){
  $clientBudgets = getAllClientBudgets(1);
  $dash = "<div class='dashdisplay'>";
  foreach ($clientBudgets as $budget){
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<p>$budget[budgetName]</p>";
    $dash .= "<p>&#36;$budget[budgetAmount]</p>";
    $dash .= "</div>";
  }
  $dash .= "</div>";
  return $dash;
}

?>