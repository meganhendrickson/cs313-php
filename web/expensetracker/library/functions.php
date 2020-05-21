<?php
//database connection
function dbConnection(){
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
    return $dbConnection;
  }
  catch (PDOException $ex)
  {
    echo 'Error!: ' . $ex->getMessage();
    die();
  }
}

function getAllUsers(){
  $db = dbConnection();
  $sql = 'SELECT * FROM "User"';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $allUsers;
}

?>