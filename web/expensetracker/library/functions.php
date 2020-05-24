

<?php
//get the database model file
require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/model.php';

// Build dashboard summary display
function buildDashDisplay($clientBudgets){
  $dash = "<section id='dashdisplay'>";
  foreach ($clientBudgets as $budget){
    $budgetId=$budget['budgetid'];
    $budgetAmount=$budget['budgetamount'];
    $budgetSpent=getBudgetAmountSpent($budgetId);
    foreach($budgetSpent as $spent){
      $spent=$spent['sum'];
     }
    $remaining=$budgetAmount-$spent;
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<p>$budget[budgetname] &#36;$budget[budgetamount]</p>";
    $dash .= "<p>Remaining Amount: &#36;$remaining</p>";
    $dash .= '<a href="/expensetracker/?action=details&budgetId='.urlencode($budgetId).'">View details</a>';
    $dash .= "</div>";
  }
  $dash .="</section>";
  return $dash;
}

function buildBudgetDisplay($budgetDetails, $budgetExpenses){
  $bd = "<div class='budgetdetails'>";
  $bd .= "<p>$budgetDetails[budgetname]</p>";
  $bd .= "<p>$budgetDetails[budgetamount]</p>";
  $bd .= "<p>$budgetDetails[created_at]<p>";
  $bd .= "</div>";
  $bd .= "<table class='budgetexpenses'>";
  $bd .= "<tr><th>Date</th><th>Description</th><th>Amount</th><th>Options</th></tr>";
  foreach ($budgetExpenses as $expense){
    $bd .= "<tr>";
    $bd .= "<td>$expense[created_at]</td>";
    $bd .= "<td>$expense[description]</td>";
    $bd .= "<td>$expense[expenseamount]</td>";
    $bd .= "<td>Edit | Delete</td>";
    $bd .= "</tr>";
  }
  $bd .= "</table>";
  return $bd;
}

?>