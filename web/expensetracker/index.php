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
    case 'login':
        include 'view/login.php';
        exit;
    break;

    case 'logout':
    
    break;

    case 'newregistration':
        include 'view/register.php';
        exit;
    break;
    
    case 'register':
        //Filter and store data
        $clientName = filter_input(INPUT_POST, 'clientName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $passcode = filter_input(INPUT_POST, 'passcode', FILTER_SANITIZE_STRING);

        echo $clientName;
        echo $email;
        echo $passcode;
        
        //check for valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = '<p class="notice">Not a valid email. Please try again.</p>';
            include 'view/register.php';
            exit;
        }
        
        echo validemail;

        //check for existing email
        $existingEmail = checkExistingEmail($email);
        if ($existingEmail){
            $msg = '<p class="notice">Email already exists. Please login.</p>';
            include 'view/login.php';
            exit;
        }

        echo existingemail;

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            $msg = 'Password should be at least 8 characters in length and should include at least one upper case letter and one number.';
            include 'view/register.php';
        }

        echo validpass;

        //check for missing data
        if (empty($clientName) || empty($email) || empty($passcode)) {
            $msg = '<p class="notice">Please provide information for all empty form fields.</p>';
            include 'view/register.php';
            exit;
        }

        echo allfeilds;

        // Hash the checked password
        $hashed = password_hash($passcode, PASSWORD_DEFAULT);

        echo hashed;

        //Send data to the model
        $newRegistration = addClient($clientName, $email, $hashed);

        if ($regOutcome === 1) {
            setcookie('clientname', $clientName, strtotime('+1 year'), '/');
            $message = "<p class='notice'>Thanks for registering $clientName!</p>";
            include include 'view/login.php';
            exit;
        } else {
            $message = "<p class='notice'>Sorry, but the registration failed. Please try again.</p>";
            include 'view/register.php';
            exit;
        }
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
            $_SESSION['msg'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'view/newexpense.php';
            exit;
        }

        // Send the data to the database
        $newExpense = addExpense($budgetId, $expenseAmount, $expenseDescr, $created_at);
        
        // Check results
        if($newExpense === 1){
            $msg = '<p class="notice">Expense was successfully added.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        } else {
            $msg = '<p class="notice">Faild to add expense. Please try again.</p>';
            $_SESSION['msg'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'view/newexpense.php';
            exit;
        }
    break;

    case 'editexpense':
        $clientBudgets = getClientBudgets(1);
        $budgetList = buildBudgetList($clientBudgets);
        $expenseId = filter_input(INPUT_GET, 'expenseId', FILTER_SANITIZE_NUMBER_INT);
        $expenseDetails = getExpenseDetails($expenseId);
        if(count($expenseDetails)<1){
            $msg = 'Sorry, no budget information could be found.';
            include $_SERVER['DOCUMENT_ROOT'].'view/expensetracker/index.php';
            exit;
        } else {
        include 'view/editexpense.php';
        exit;}
    break;

    case 'updateexpense':
        $expenseId = filter_input(INPUT_POST, 'expenseId', FILTER_SANITIZE_NUMBER_INT);
        $budgetId = filter_input(INPUT_POST, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
        $expenseAmount = filter_input(INPUT_POST, 'expenseAmount', FILTER_SANITIZE_NUMBER_INT);
        $expenseDescr = filter_input(INPUT_POST, 'expenseDescr', FILTER_SANITIZE_STRING);
        $created_at = filter_input(INPUT_POST, 'created_at');

    //check for missing data
    if(empty($expenseId) || empty($budgetId) || empty($expenseAmount) || empty($expenseDescr) || empty($created_at)) {
        $msg = '<p class="notice">Please provide information for all emtpy form fields.</p>';
        header ("location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=editexpense&budgetId=$budgetId");
        exit;
    }

    //Send data to database
    $updateExpense = updateExpense($expenseId, $budgetId, $expenseAmount, $expenseDescr, $created_at);

        // Check results
        if($updateExpense === 1){
            $msg = '<p class="notice">Expense was successfully updated.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        } else {
            $msg = '<p class="notice">Failed to update expense. Please try again.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        }
    break;

    case 'deleteexpense':
        $expenseId = filter_input(INPUT_POST, 'expenseId', FILTER_SANITIZE_NUMBER_INT);
        $budgetId= filter_input(INPUT_POST, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
        
        //Check for missing data
        if(empty($expenseId) || empty($budgetId)) {
            $msg = '<p class="notice"> Please try again.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/");
            exit;
        }

        $deleteExpense = deleteExpense($expenseId);

        // Check results
        if($deleteExpense === 1){
            $msg = '<p class="notice">Expense was successfully deleted.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        } else {
            $msg = '<p class="notice">Failed to delete expense. Please try again.</p>';
            $_SESSION['message'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        }
    break;

    case 'newbudget':
        include 'view/newbudget.php';
        exit;
    break;

    case 'addbudget':
        // Filter and store data
        $clientId = 1;
        $budgetName = filter_input(INPUT_POST, 'budgetName', FILTER_SANITIZE_STRING);
        $budgetAmount = filter_input(INPUT_POST, 'budgetAmount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $created_at = filter_input(INPUT_POST, 'created_at');

        //Check for missing data
        if(empty($clientId) || empty($budgetName) || empty($budgetAmount) || empty($created_at)) {
            $msg = '<p class="notice"> Please provide information for all empty form fields.</p>';
            $_SESSION['msg'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'view/newbudget.php';
            exit;
        }

        // Send the data to the database
        $newBudget = addBudget($clientId, $budgetName, $budgetAmount, $created_at);
        
        // Check results
        if($newBudget === 1){
            $msg = '<p class="notice">Expense was successfully added.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/");
            exit;
        } else {
            $msg = '<p class="notice">Faild to add expense. Please try again.</p>';
            $_SESSION['message'] = $msg;
            include $_SERVER['DOCUMENT_ROOT'].'/expensetracker/index.php';
            exit;
        }
    break;

    case 'editbudget':
        $budgetId = filter_input(INPUT_GET, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
        $budgetDetails = getBudgetDetails($budgetId);
        if(count($budgetDetails)<1){
            $msg = 'Sorry, no budget information could be found.';
            include $_SERVER['DOCUMENT_ROOT'].'view/expensetracker/index.php';
            exit;
        } else {
        include 'view/editbudget.php';
        exit;}
    break;

    case 'updatebudget':
        //Filter and store data
        $budgetId = filter_input(INPUT_POST, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
        $budgetName = filter_input(INPUT_POST, 'budgetName', FILTER_SANITIZE_STRING);
        $budgetAmount = filter_input(INPUT_POST, 'budgetAmount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $created_at = filter_input(INPUT_POST, 'created_at');

        //check for missing data
        if(empty($budgetId) || empty($budgetName) || empty($budgetAmount) || empty($created_at)) {
            $msg = '<p class="notice">Please provide information for all emtpy form fields.</p>';
            header ("location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=editbudget&budgetId=$budgetId");
            exit;
        }

        //Send data to database
        $updateBudget = updateBudget($budgetId, $budgetName, $budgetAmount, $created_at);

        // Check results
        if($updateBudget === 1){
            $msg = '<p class="notice">Budget was successfully updated.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        } else {
            $msg = '<p class="notice">Failed to update budget. Please try again.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/?action=details&budgetId=$budgetId");
            exit;
        }       
    break;

    case 'deletebudget':
        $budgetId = filter_input(INPUT_POST, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
        if(empty($budgetId)){
            $msg = '<p class="notice"> Please try again.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/");
            exit;
        }
        $deleteBudget = deleteBudget($budgetId);
        // Check results
        if($deleteBudget === 1){
            $msg = '<p class="notice">Budget was successfully deleted.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/");
            exit;
        } else {
            $msg = '<p class="notice">Failed to delete budget. Please try again.</p>';
            $_SESSION['msg'] = $msg;
            header ("Location: https://mighty-wave-93548.herokuapp.com/expensetracker/");
            exit;
        }      
    break;

    case 'details':
        $budgetId = filter_input(INPUT_GET, 'budgetId', FILTER_SANITIZE_NUMBER_INT);
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