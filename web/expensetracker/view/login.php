<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Login";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>

<main>
  
  <h1>Simple Expense Tracker</h1>
  
  <p>Please login to continue.</p>
  
  <div class="msg">
    <?php if (isset($msg)) {echo $msg;}?>
  </div>

  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post"> 
    <label>Email:</label>
    <input required type="text" name="email" id="email"/>
    <label>Password:</label>
    <input required type="password" name="passcode" id="passcode"/>
    <input type="submit" class="button" name="login" value="login"/>
    <input type="hidden" name="action" value="login"/>
  </form>

  <p>Not a member?</p>
  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post"> 
    <input type="submit" class="button" name="newregistration" value="Create an Account"/>
    <input type="hidden" name="action" value="newregistration"/>
  </form>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>