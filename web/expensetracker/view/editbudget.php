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

if(!$_SESSION['loggedin']){
  header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=notlogin");
}
?>

<main>
  
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>

  <h1>Edit Budget</h1>
  <div class="msg">
   <?php if (isset($_SESSION['msg'])) {
      $msg = $_SESSION['msg'];
      echo $msg;
      $_SESSION['msg'] = "";
    }?>
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
              elseif(isset($budgetDetails['budgetamount'])) {echo "value='$budgetDetails[budgetamount]'";} 
      ?>
    />
    <label>Date:</label>
    <input required type="date" name="created_at" id="created_at"
      <?php if(isset($created_at)){ echo "value='$created_at'";}
              elseif(isset($budgetDetails['created_at'])) {echo "value='$budgetDetails[created_at]'";} 
      ?>
    />
    <input type="submit" class="button" name="submit" value="Update Budget"/>
    <input type="hidden" name="action" value="updatebudget"/>
    <input type="hidden" name="budgetId" value="
      <?php if(isset($budgetDetails['budgetid'])){echo $budgetDetails['budgetid'];
              }elseif(isset($budgetId)){echo $budgetId;} ?>"
    />
  </fieldset>
  </form>
  </br>
  </br>
  <h4>Danger Zone</h4>
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post" id="deletebudget">
    <input type="submit" class="button danger" name="submit" id="deletebudget" value="Delete Budget" />
    <input type="hidden" name="action" value="deletebudget">
    <input type="hidden" name="budgetId" value="
        <?php if(isset($budgetDetails['budgetid'])){echo $budgetDetails['budgetid'];
                }elseif(isset($budgetId)){echo $budgetId;} ?>"
    />
  </form>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>