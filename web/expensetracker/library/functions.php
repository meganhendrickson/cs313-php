<?php
//database connection
function dbConnect() {
  try
  {
    $dbUrl = getenv('DATABASE_URL');
  
    $dbOpts = parse_url($dbUrl);
  
    $dbHost = $dbOpts["host"];
    $dbPort = $dbOpts["port"];
    $dbUser = $dbOpts["user"];
    $dbPassword = $dbOpts["pass"];
    $dbName = ltrim($dbOpts["path"],'/');
  
    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
  
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnect;
  }
  catch (PDOException $ex)
  {
    echo 'Error!: ' . $ex->getMessage();
    die();
  }
}

function getAllUsers() {
  $db = dbConnect();
  $sql = 'SELECT * FROM "User"';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $allUsers = $stmt->fetchAll();
  $stmt->closeCursor();
  return $allUsers;
}
