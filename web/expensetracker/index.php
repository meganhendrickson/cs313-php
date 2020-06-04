<?php

/* EXPENSE TRACKER CONTROLLER */

// Create or access a Session
session_start();

// Get the common functions file
require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/model.php';

//Action cases
$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

switch ($action){
    case 'register':
        include 'view/register.php'; 
        exit;   
    break;

    case 'login':
        include 'view/login.php';
        exit;
    break;

    case 'newexpense':
        $budgetList = '<select name="budget">';
        foreach ($clientBudgets as $budget){
            $budgetList .= "<option value='$budget[budgetId]'";
            if(isset($budgetId)){
                if($budget['budgetId'] === $budgetId){
                    $budgetList .= ' selected ';
                }
            }
            $budgetList .= ">$budget[budgetName].</option>";
        }
        $budgetList .= '</select>';
        include 'view/newexpense.php';
        exit;
    break;

    case 'editexpense':
        include 'view/editexpense.php';
        exit;
    break;

    case 'newbudget':
        
        include 'view/newbudget.php';
        exit;
    break;

    case 'editbudget':
        include 'view/editbudget.php';
        exit;
    break;

    case 'details':
        $budgetId = filter_input(INPUT_GET, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
        //print_r (getBudgetExpenses($budgetId));
        $budgetDetails = getBudgetDetails($budgetId);
        $budgetExpenses = getBudgetExpenses($budgetId);
        $budgetSpent = getBudgetAmountSpent($budgetId);
        $budgetDisplay = buildBudgetDisplay($budgetDetails, $budgetExpenses, $budgetSpent);
        include 'view/budgetdetail.php';
        exit;
    break;

    default:
    $clientBudgets = getClientBudgets(1);
    $dashdisplay = buildDashDisplay($clientBudgets);
        include 'view/dashboard.php';
}