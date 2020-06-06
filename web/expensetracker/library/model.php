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
    $budgetExpenses = $stmt->fetch();
    $stmt->closeCursor();
    return $budgetExpenses;
}

function getExpenseDetails($expenseId){
  $db = dbConnection();
  $sql = 'SELECT * FROM expense WHERE expenseId = :expenseId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':expenseId', $expenseId, PDO::PARAM_INT);
  $stmt->execute();
  $expenseDetails = $stmt->fetch();
  $stmt->closeCursor();
  return $expenseDetails;
}

function addExpense($budgetId, $expenseAmount, $expenseDescr, $created_at){
  $db = dbConnection();
  $sql = 'INSERT INTO expense(budgetid, expenseamount, expensedescr, created_at) VALUES (:budgetid, :expenseamount, :expensedescr, :created_at)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':budgetid', $budgetId);
  $stmt->bindValue(':expenseamount', $expenseAmount);
  $stmt->bindValue(':expensedescr', $expenseDescr);
  $stmt->bindValue(':created_at', $created_at);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function addBudget($clientId, $budgetName, $budgetAmount, $created_at){
  $db = dbConnection();
  $sql = 'INSERT INTO budget(clientid, budgetname, budgetamount, created_at) VALUES(:clientid, :budgetname, :budgetamount, :created_at)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientid', $clientId);
  $stmt->bindValue(':budgetname', $budgetName);
  $stmt->bindValue(':budgetamount', $budgetAmount);
  $stmt->bindValue(':created_at', $created_at);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function updateBudget($budgetId, $budgetName, $budgetAmount, $created_at){
  $db = dbConnection();
  echo dbconnected;
  $sql = "UPDATE budget SET (budgetname = :budgetname, budgetamount = :budgetamount, created_at = :created_at) WHERE budgetid = :budgetid";
  $stmt = $db->prepare($sql);
  echo prepared;
  $stmt->bindValue(':budgetid', $budgetId);
  $stmt->bindValue(':budgetname', $budgetName);
  $stmt->bindValue(':budgetamount', $budgetAmount);
  $stmt->bindValue(':created_at', $created_at);
  echo bindvalue;
  $stmt->execute();
  echo done;
  $stmt->closeCursor();
}

?>