

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
    $dash .= "<div class='summaryname'>";
    $dash .= "<h3>$budget[budgetname] = &#36;$budget[budgetamount]";
    $dash .= '<a href="/expensetracker/?action=editbudget&budgetId='.urlencode($budgetId).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></h3>';
    $dash .= "</div>";
    $dash .= "<p>Spent: &#36;$spent | Remaining: &#36;$remaining</p>";
    $dash .= '<a href="/expensetracker/?action=details&budgetId='.urlencode($budgetId).'"><i class="fa fa-align-left" aria-hidden="true"></i>View details</a>';
    $dash .= "</div>";
  }
  $dash .="</section>";
  return $dash;
}

function buildBudgetDisplay($budgetDetails, $budgetExpenses){
  foreach($budgetSpent as $spent){
    $spent = $spent['sum'];
  }
  $remaining=$budgetAmount-$spent;
  $bd = "<div class='budgetdetails'>";
  $bd .= "<h2 class='detail-name'>$budgetDetails[budgetname]</h2>";
  $bd .= "<p class='detail-date'>Date Created: $budgetDetails[created_at]</p>";
  $bd .= "<p class='detail-amount'>Budget Amount: &#36;$budgetDetails[budgetamount]</p>";
  $bd .= "<p class='detail-amount'>Amount Spent: &#36;$spent</p>";
  $bd .= "<p class='detail-amount'>Remaining: &#36;$remaining</p>";
  $bd .= "</div>";
  $bd .= "<h2>Expenses</h2>";
  $bd .= "<div class='overflow'><table class='budgetexpenses'>";
  $bd .= "<thead><tr><th>Date</th><th>Description</th><th>Amount</th><th>Edit</th></tr></thead><tbody>";
  foreach ($budgetExpenses as $expense){
    $expenseId = $expense['expenseid'];
    $bd .= "<tr>";
    $bd .= "<td>$expense[created_at]</td>";
    $bd .= "<td>$expense[description]</td>";
    $bd .= "<td>&#36;$expense[expenseamount]</td>";
    $bd .= '<td><a href="/expensetracker/?action=editexpense&expenseId='.urlencode($expenseId).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
    $bd .= "</tr>";
  }
  $bd .= "</tbody></table></div>";
  return $bd;
}

?>