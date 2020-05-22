

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
    $budgetAmount=$budget['budgetamount'];
    $budgetSpent=getBudgetAmountSpent($budgetId);
    foreach($budgetSpent as $spent){
      $spent=$spent['sum'];
     }
    $remaining=$budgetAmount-$spent;
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<p>$budget[budgetname] &#36;$budget[budgetamount]</p>";
    $dash .= "<p>Remaining Amount: &#36;$remaining</p>";
    $dash .= '<a href="/expensetracker/?action=details&budgetId='.urlencode($budgetId).'">View details</a>';
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

// Get budget details
function getBudgetDetails($budgetId){
  $db = dbConnection();
  $sql = 'SELECT * FROM budget WHERE budgetId = :budgetId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':budgetId', $budgetId, PDO::PARAM_INT);
  $stmt->execute();
  $budgetDetails = $stmt->fetch();
  $stmt->closeCursor();
  return $budgetDetails;
}

function buildBudgetDisplay($budgetDetails){
  $bd = "<div class='budgetdetails'>";
  $bd .= "<p>$budgetDetails[budgetname]</p>";
  $bd .= "<p>$budgetDetails[budgetamount]</p>";
  $bd .= "<p>$budgetDetails[created_at]<p>";
  return $bd;
}
?>