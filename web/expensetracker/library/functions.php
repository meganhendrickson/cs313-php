

<?php

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/connections.php';

function getClientBudget(){
  $db = dbConnection();
  $sql = 'SELECT * FROM budget WHERE clientId = 1';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $allBudget = $stmt->fetchAll();
  $stmt->closeCursor();
  return $allBudget;
}

?>


