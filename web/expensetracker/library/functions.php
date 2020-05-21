<?php
function getAllUsers(){
  $db = dbconnect();
  $sql = 'SELECT * FROM client';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $allUsers = $stmt->fetchAll();
  $stmt->closeCursor();
  return $allUsers;
}

?>


