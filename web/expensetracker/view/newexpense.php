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
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post">
  <label>Select a budget:</label>
    <?php //drop down list using $budgets array
      echo $budgetList;
    ?>
  <label>Amount:</label>
  <input required type="text" name="expenseAmount" id="expenseAmount"/>
  <label>Description:</label>
  <input requred type="text" name="description" id="description"/>
  <input type="submit" class="button" name="submit" value="Add Expense"/>
  <!-- Action Key - Value Pair -->
  <input type="hidden" name="action" value="addexpense"/>
  </form >

<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>