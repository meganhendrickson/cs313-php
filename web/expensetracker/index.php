<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Dashboard";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/functions.php';
?>

<main>
  <h1>Dashboard</h1>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>