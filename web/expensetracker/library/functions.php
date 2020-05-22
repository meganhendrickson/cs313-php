

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
  $dash = "<section id='dashdisplay'>";
  foreach ($clientBudgets as $budget){
    $budgetId=$budget['budgetid'];
    $budgetSpent=getBudgetAmountSpent($budgetId);
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<p>$budget[budgetname]</p>";
    $dash .= "<p>Amount: $budget[budgetamount]</p>";
    $dash .= "<p>Spent: $budgetSpent</p>";
    $dash .= "</div>";
  }
  $dash .="</section>";
  return $dash;
}

// Get client expenses
function getBudgetAmountSpent($budgetId){
  $db = dbConnection();
  $sql = 'SELECT SUM(expenseamount) FROM expense WHERE budgetId = :budgetId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':budgetId', $budgetId, PDO::PARAM_INT);
  $stmt->execute();
  $budgetSpent = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $budgetSpent;
}
?>