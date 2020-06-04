<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Add Expense";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>

<main>
  
  <h1>Add an Expense</h1>
  <div class="msg">
    <?php if (isset($msg)) {echo $msg;}?>
  </div>
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post">
    <fieldset>
      <?php //drop down list using $budgets array
        echo $budgetList;
      ?>
      <label>Amount:</label>
      <input required type="text" name="expenseAmount" id="expenseAmount"/>
      <label>Description:</label>
      <input required type="text" name="description" id="description"/>
      <label>Expense Date:</label>
      <input required type="date" name="date" id="date" min="2020-01-01" max="2020-12-31"/>
      <input type="submit" class="button" name="submit" value="Add Expense"/>
      <!-- Action Key - Value Pair -->
      <input type="hidden" name="action" value="addexpense"/>
    </fieldset>
  </form >
<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>