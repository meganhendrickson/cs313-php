<?php
//database connection
function dbConnection() {
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
      return $db;
    }
    catch (PDOException $ex)
    {
      echo 'Error!: ' . $ex->getMessage();
      die();
    }
    

  function getAllUsers(){
    $db = dbConnection();
    $sql = 'SELECT * FROM client';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $allUsers = $stmt->fetchAll();
    $stmt->closeCursor();
    return $allUsers;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://mighty-wave-93548.herokuapp.com/css/mystyles.css">
    <title>Backup Title</title>
</head>

<body>
<main>
  <h1>Dashboard</h1>
  <?php
    echo print_r (getAllUsers());
  ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>