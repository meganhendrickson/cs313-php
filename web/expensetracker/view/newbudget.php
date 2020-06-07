<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Add Budget";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

if(!$_SESSION['loggedin']){
  header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=notlogin");
}
?>

<main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>
  <h1>Add a Budget</h1>
  <div class="msg">
    <?php if (isset($_SESSION['msg'])) {
      $msg = $_SESSION['msg'];
      echo $msg;
      $_SESSION['msg'] = "";
    }?>
  </div>
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post">
    <fieldset>

      <label>Budget Name:</label>
      <input required type="text" name="budgetName" id="budgetName"/></br>
      <label>Budget Amount:</label>
      <input required type="text" name="budgetAmount" id="budgetAmount"/></br>
      <label>Date:</label>
      <input required type="date" name="created_at" id="created_at" min="2020-01-01" max="2020-12-31"/>
      <input type="submit" class="button" name="submit" value="Add Budget"/>
      <!-- Action Key - Value Pair -->
      <input type="hidden" name="action" value="addbudget"/>
    </fieldset>
  </form >
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>