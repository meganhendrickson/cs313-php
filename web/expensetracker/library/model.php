<?php
// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/connections.php';

/* ------------------------------------
          BUDGET MODEL
-------------------------------------*/

function addBudget($clientId, $budgetName, $budgetAmount, $created_at){
  $db = dbConnection();
  $sql = 'INSERT INTO budget(clientid, budgetname, budgetamount, created_at) VALUES(:clientid, :budgetname, :budgetamount, :created_at)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientid', $clientId, PDO:: PARAM_INT);
  $stmt->bindValue(':budgetname', $budgetName, PDO:: PARAM_STR);
  $stmt->bindValue(':budgetamount', $budgetAmount, PDO:: PARAM_STR);
  $stmt->bindValue(':created_at', $created_at, PDO:: PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

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

function updateBudget($budgetId, $budgetName, $budgetAmount, $created_at){
  $db = dbConnection();
  $sql = "UPDATE budget SET budgetname = :budgetname, budgetamount = :budgetamount, created_at = :created_at WHERE budgetid = :budgetid";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':budgetid', $budgetId, PDO:: PARAM_INT);
  $stmt->bindValue(':budgetname', $budgetName, PDO:: PARAM_STR);
  $stmt->bindValue(':budgetamount', $budgetAmount, PDO:: PARAM_STR);
  $stmt->bindValue(':created_at', $created_at, PDO:: PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function deleteBudget($budgetId){
  $db = dbConnection();
  $sql = 'DELETE FROM budget WHERE budgetid = :budgetid';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':budgetid', $budgetId, PDO:: PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

/* ------------------------------------
          EXPENSE MODEL
-------------------------------------*/

function addExpense($budgetId, $expenseAmount, $expenseDescr, $created_at){
  $db = dbConnection();
  $sql = 'INSERT INTO expense(budgetid, expenseamount, expensedescr, created_at) VALUES (:budgetid, :expenseamount, :expensedescr, :created_at)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':budgetid', $budgetId, PDO:: PARAM_INT);
  $stmt->bindValue(':expenseamount', $expenseAmount, PDO:: PARAM_STR);
  $stmt->bindValue(':expensedescr', $expenseDescr, PDO:: PARAM_STR);
  $stmt->bindValue(':created_at', $created_at, PDO:: PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}


function getBudgetExpenses($budgetId){
    $db = dbConnection();
    $sql = 'SELECT * FROM expense WHERE budgetId = :budgetId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':budgetId', $budgetId, PDO::PARAM_INT);
    $stmt->execute();
    $budgetExpenses = $stmt->fetchAll();
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


function updateExpense($expenseId, $budgetId, $expenseAmount, $expenseDescr, $created_at){
  $db = dbConnection();
  $sql = "UPDATE expense SET budgetid = :budgetid, expenseamount = :expenseamount, expensedescr = :expensedescr, created_at = :created_at WHERE expenseid = :expenseid";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':expenseid', $expenseId, PDO:: PARAM_INT);
  $stmt->bindValue(':budgetid', $budgetId, PDO:: PARAM_INT);
  $stmt->bindValue(':expenseamount', $expenseAmount, PDO:: PARAM_STR);
  $stmt->bindValue(':expensedescr', $expenseDescr, PDO:: PARAM_STR);
  $stmt->bindValue(':created_at', $created_at, PDO:: PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

function deleteExpense($expenseId){
  $db = dbConnection();
  $sql = 'DELETE FROM expense WHERE expenseid = :expenseid';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':expenseid', $expenseId, PDO:: PARAM_INT);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

/* ------------------------------------
          CLIENT MODEL
-------------------------------------*/

function addClient($clientName, $email, $hashed){
  $db = dbConnection();
  $sql = 'INSERT INTO client(clientname, email, passcode) VALUES (:clientname, :email, :passcode)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':clientname', $clientName, PDO:: PARAM_STR);
  $stmt->bindValue(':email', $email, PDO:: PARAM_STR);
  $stmt->bindValue(':passcode', $hashed, PDO:: PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

// Check for an existing email address
function checkExistingEmail($email) {
  $db = acmeConnect();
  echo -dbconnect;
  $sql = 'SELECT email FROM client WHERE email = :email';
  $stmt = $db->prepare($sql);
  $stmt->bindVAlue(':email', $email, PDO::PARAM_STR);
  echo -bindvalue;
  $stmt->execute();
  $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
  echo -$matchEmail;
  $stmt->closeCursor();
  return $matchEmail;
  // if (empty($matchEmail)) {
  //    return 0;
  //    echo 'Nothing found';
  //    exit;
  // } else {
  //    return 1;
  //    echo 'Match found';
  //    exit;
  // }
}

?>