

<?php
//get the database model file
require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/model.php';

// Build dashboard summary display
function buildDashDisplay($clientBudgets){
  $dash = "<section id='dashdisplay'>";
  foreach ($clientBudgets as $budget){
    $budgetId = $budget['budgetid'];
    $budgetAmount = $budget['budgetamount'];
    $budgetSpent = getBudgetAmountSpent($budgetId);
    foreach($budgetSpent as $spent){
      $spent = $spent['sum'];
     }
    $remaining=$budgetAmount-$spent;
    $dash .= "<div class='budgetsummary'>";
    $dash .= "<h3>$budget[budgetname] = &#36;$budget[budgetamount]";
    $dash .= '<a href="/expensetracker/?action=editexpense&expenseId='.urlencode($expenseId).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> | <i class="fa fa-minus-square" aria-hidden="true"></i></a></h3>';
    $dash .= "<p>Spent: &#36;$spent | Remaining: &#36;$remaining</p>";
    $dash .= '<a href="/expensetracker/?action=details&budgetId='.urlencode($budgetId).'"><i class="fa fa-align-left" aria-hidden="true"></i>View details</a>';
    $dash .= "</div>";
  }
  $dash .="</section>";
  return $dash;
}

function buildBudgetDisplay($budgetDetails, $budgetExpenses){
  $bd = "<div class='budgetdetails'>";
  $bd .= "<h2 class='detail-name'>$budgetDetails[budgetname]</h2>";
  $bd .= "<p class='detail-info'>Budget Amount: &#36;$budgetDetails[budgetamount]</p>";
  $bd .= "<p class='detail-info'>Date Created: $budgetDetails[created_at]</p>";
  $bd .= "</div>";
  $bd .= "<h3>Expenses</h3>";
  $bd .= "<table class='budgetexpenses'>";
  $bd .= "<tr><th>Date</th><th>Description</th><th>Amount</th><th>Options</th></tr>";
  foreach ($budgetExpenses as $expense){
    $expenseId = $expense['expenseid'];
    $bd .= "<tr>";
    $bd .= "<td>$expense[created_at]</td>";
    $bd .= "<td>$expense[description]</td>";
    $bd .= "<td>&#36;$expense[expenseamount]</td>";
    $bd .= '<td><a href="/expensetracker/?action=editexpense&expenseId='.urlencode($expenseId).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> | <i class="fa fa-minus-square" aria-hidden="true"></i></a></td>';
    $bd .= "</tr>";
  }
  $bd .= "</table>";
  return $bd;
}

?>