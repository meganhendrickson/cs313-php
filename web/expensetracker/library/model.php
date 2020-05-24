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

function getBudgetExpenses($budgetId){
    $db = dbConnection();
    $sql = 'SELECT * FROM expense WHERE budgetId = :budgetId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':budgetId', $budgetId, PDO::PARAM_INT);
    $stmt->execute();
    $budgetExpenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $budgetExpenses;
}
?>