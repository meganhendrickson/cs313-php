<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Edit Expense";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

if(!$_SESSION['loggedin']){
  header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=notlogin");
}
?>

<main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>
  <h1>Edit an Expense</h1>
  <div class="msg">
  <?php 
        if (isset($_SESSION['msg'])) {
            $message = $_SESSION['msg'];
        }
        if (isset($message)) { echo $message;}
    ?>
  </div>
  <p>Update expense below. All fields are required.</p>
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post">
    <fieldset>
      <?php //drop down list using $budgets array
        echo $budgetList;
      ?>
    <label>Expense Amount:</label>
    <input required type="text" name="expenseAmount" id="expenseAmount"
      <?php if(isset($expenseAmount)){ echo "value='$expenseAmount'";}
              elseif(isset($expenseDetails['expenseamount'])) {echo "value='$expenseDetails[expenseamount]'";} 
      ?>
    />
    <label> Description:</label>
    <input required type="text" name="expenseDescr" id="expenseDescr"
      <?php if(isset($expenseDescr)){echo "value='$expenseDescr'";}
              elseif(isset($expenseDetails['expensedescr'])) {echo "value='$expenseDetails[expensedescr]'";}
      ?>
    />
              <label>Date:</label>
    <input required type="date" name="created_at" id="created_at"
      <?php if(isset($created_at)){ echo "value='$created_at'";}
              elseif(isset($expenseDetails['created_at'])) {echo "value='$expenseDetails[created_at]'";} 
      ?>
    />
    <input type="submit" class="button" name="submit" value="Update Expense"/>
    <input type="hidden" name="action" value="updateexpense"/>
    <input type="hidden" name="expenseId" value="
      <?php if(isset($expenseDetails['expenseid'])){echo $expenseDetails['expenseid'];
              }elseif(isset($expenseId)){echo $expenseId;} ?>"
    />
  </fieldset>
  </form>

  <h4>Danger Zone</h4>
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post" id="deleteexpense">
    <input class="danger" type="submit" class="button" name="submit" id="deleteexpense" value="Delete Expense" />
    <input type="hidden" name="action" value="deleteexpense">
    <input type="hidden" name="budgetId" value="
      <?php if(isset($expenseDetails['budgetid'])){echo $expenseDetails['budgetid'];
            }elseif(isset($budgetId)){echo $budgetId;} ?>"
    />
    <input type="hidden" name="expenseId" value="
      <?php if(isset($expenseDetails['expenseid'])){echo $expenseDetails['expenseid'];
              }elseif(isset($expenseId)){echo $expenseId;} ?>"
    />
  </form>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>