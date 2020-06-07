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

if(!$_SESSION['loggedin']){
  header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=notlogin");
}
?>

<main>
  
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>

  <h1>Dashboard</h1>
  
  <div class="msg">
    <?php if (isset($_SESSION['msg'])) {
      $msg = $_SESSION['msg'];
      echo $msg;
      unset($_SESSION['msg']);
    }?>
  </div>
  
  <p id="newbudgetlink"><a href="https://mighty-wave-93548.herokuapp.com/expensetracker/?action=newbudget">
    <i class="fa fa-plus-square" aria-hidden="true"></i>Create a new budget</a></p>
  
  <?php
    echo $dashdisplay;
  ?>
  
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>