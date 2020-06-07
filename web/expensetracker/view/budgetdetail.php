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

if(!$_SESSION['loggedin']){
  header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=notlogin");
}
?>

<main>
  
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>

  <h1>Budget Details</h1>
  
  <div class="msg">
    <?php if (isset($_SESSION['msg'])) {
      $msg = $_SESSION['msg'];
      echo $msg;
      $_SESSION['msg'] = "";
    }?>
  </div>

  <?php echo $budgetDisplay ?>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>