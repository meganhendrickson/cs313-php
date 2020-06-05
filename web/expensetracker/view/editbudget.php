<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Edit Budget";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>

<main>
  
  <h1>Edit Budget</h1>
  <div class="msg">
    <?php if (isset($msg)) {echo $msg;}?>
  </div>
  <p>Update budget below. All fields are required.</p>
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post">
    <fieldset>
    <label>Budget Name:</label>
    <input required type="text" name="budgetName" id="budgetName"
      <?php if(isset($budgetName)){ echo "value='$budgetName'";}
              elseif(isset($budgetDetails['budgetname'])) {echo "value='$budgetDetails[budgetname]'";} 
      ?>
    />
    <label>Budget Amount:</label>
    <input required type="text" name="budgetAmount" id="budgetAmount"
      <?php if(isset($budgetAmount)){ echo "value='$budgetAmount'";}
              elseif(isset($budgetDetails['budgetname'])) {echo "value='$budgetDetails[budgetname]'";} 
      ?>
    />
    <label>Budget Amount:</label>
    <input required type="text" name="budgetAmount" id="budgetAmount"
      <?php if(isset($budgetAmount)){ echo "value='$budgetAmount'";}
              elseif(isset($budgetDetails['budgetname'])) {echo "value='$budgetDetails[budgetname]'";} 
      ?>
    />
    <input type="submit" class="button" name="submit" value="Update Budget"/>
    <input type="hidden" name="action" value="updateBudget"/>
    <input type="hidden" name="budgetId" value="
      <?php if(isset($budgetDetails['budgetId'])){echo $budgetDetails['budgetId'];
              }elseif(isset($budgetId)){echo $bugetId;} ?>"
    />
  </fieldset>
  </form>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>