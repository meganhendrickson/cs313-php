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
?>

<main>
  <h1>Dashboard</h1>
  <section id="dashdisplay">
  <?php
    foreach ($clientBudgets as $budget) {
      echo '<div class="budgetsumamry">
              <p>'.$budget['budgetName'].'</p>
              <p>'.$budget['budgetAmount'].'</p>
            </div>';
    } 
  ?>
  </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>