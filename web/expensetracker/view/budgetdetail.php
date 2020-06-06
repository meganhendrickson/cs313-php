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
  
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>

  <h1>Budget Details</h1>
  
  <div class="msg">
  <?php 
        if (isset($_SESSION['msg'])) {
            $message = $_SESSION['msg'];
        }
        if (isset($message)) { echo $message;}
    ?>
  </div>

  <?php echo $budgetDisplay ?>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>