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
        $clientBudgets = getClientBudgets(1);
        $budgetList = buildBudgetList($clientBudgets);
        include 'view/newexpense.php';
        exit;
    break;

    case 'addexpense':
        // Filter and store data
        $budgetId = filter_input(INPUT_POST, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
        $expenseAmount = filter_input(INPUT_POST, 'expenseAmount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $expenseDescr = filter_input(INPUT_POST, 'expenseDescr', FILTER_SANITIZE_STRING);
        $created_at = filter_input(INPUT_POST, 'created_at');

        //Check for missing data
        if(empty($budgetId) || empty($expenseAmount) || empty($expenseDescr) || empty($created_at)) {
            $msg = '<p class="notice"> Please provide information for all empty form fields.</p>';
            $_SESSION['message'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'view/newexpense.php';
            exit;
        }

        // Send the data to the database
        $newExpense = addExpense($budgetId, $expenseAmount, $expenseDescr, $created_at);
        
        // Check results
        if($newExpense === 1){
            //$msg = '<p class="notice">Expense was successfully added.</p>';
            //$_SESSION['message'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        } else {
            //$msg = '<p class="notice">Faild to add expense. Please try again.</p>';
            //$_SESSION['message'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'view/newexpense.php';
            exit;
        }
    break;

    case 'editexpense':
        include 'view/editexpense.php';
        exit;
    break;

    case 'newbudget':
        
        include 'view/newbudget.php';
        exit;
    break;

    case 'addbudget':
        // Filter and store data
        $clientId = 1;
        $budgetName = filter_input(INPUT_POST, 'budgetName', FILTER_SANITIZE_STRING);
        $budgetAmount = filter_input(INPUT_POST, 'expenseDescr', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $created_at = filter_input(INPUT_POST, 'created_at');

        //Check for missing data
        if(empty($clientId) || empty($budgetName) || empty($budgetAmount) || empty($created_at)) {
            $msg = '<p class="notice"> Please provide information for all empty form fields.</p>';
            $_SESSION['message'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'view/newexpense.php';
            exit;
        }

        // Send the data to the database
        $newBudget = addBudget($clientId, $budgetName, $budgetAmount, $created_at);

        // Check results
        if($newBudget === 1){
            //$msg = '<p class="notice">Expense was successfully added.</p>';
            //$_SESSION['message'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/");
            exit;
        } else {
            //$msg = '<p class="notice">Faild to add expense. Please try again.</p>';
            //$_SESSION['message'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'view/newbudget.php';
            exit;
        }
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