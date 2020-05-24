<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Details";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>

<main>
  
  <h1>Add an Expense</h1>

  <p>Coming Soon!<p>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>