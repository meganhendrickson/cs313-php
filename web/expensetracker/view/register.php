<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Register";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>

<main>
  
  <h1>New Client Registration</h1>

  <p>Welcome to Simple Expense Tracker! Please register to begin. All fields are required.</p>
  
  <div class="msg">
    <?php if (isset($msg)) {echo $msg;}?>
  </div>

  <form action="https://mighty-wave-93548.herokuapp.com/expensetracker/index.php" method="post"> 
  <label>Your Name:</label>
  <input required type="text" name="clientName" id="clientName"/>
  <label>Email:</label>
  <input required type="text" name="email" id="email"/>
  <label>Password:</label>
  <input required type="password" name="passcode" id="passcode"/>
  <p>Password must be at least 8 characters and contain at least 1 CAPS and 1 number.</p>
  <input type="submit" class="button" name="register" value="Register"/>
  <input type="hidden" name="action" value="register"/>
  </form>

  <p>Already a client? <a href="https://mighty-wave-93548.herokuapp.com/expensetracker/">Login here</a></p>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/expensetracker/common/actionmenu.php' ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>