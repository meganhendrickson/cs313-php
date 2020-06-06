<?php
session_start();

/* EXPENSE TRACKER CONTROLLER */

// Get the common functions file
require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/model.php';

//Action cases
$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

switch ($action){
    case 'notlogin':
        include 'view/login.php';
    break;

    case 'login':
        // Filter and store and check for validity
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $passcode = filter_input(INPUT_POST, 'passcode', FILTER_SANITIZE_STRING);

        // Check for missing data
        if (empty($email) || empty($passcode)) {
            $message = '<p class="notice">All fields required. Please provide a valid email address and password.</p>';
            include 'view/login.php';
            exit;
        }

        //check for valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = '<p class="notice">Not a valid email. Please try again.</p>';
            include 'view/login.php';
            exit;
        }

        //check for existing email
        $existingEmail = checkExistingEmail($email);
 
        if (!$existingEmail){
            $msg = '<p class="notice">Email not registered. Please register first.</p>';
            include 'view/register.php';
            exit;
        }

        // Query the client data based on the email address
        $clientData = getClient($email);

        // Compare the password just submitted against the hashed password for the matching client
        $hashCheck = password_verify($passcode, $clientData['passcode']);

        // If the hashes don't match create an error and return to the login view
        if(!$hashCheck) {
            $msg = '<p class="notice">Check your password and try again.</p>';
            include 'view/login.php';
            exit;
        } 

        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        //delete registration cookie - set expiration to one hour ago
        if($_SESSION['loggedin'] = TRUE){
            unset($_COOKIE['clientName']);
            setcookie('clientName','', strtotime('-1 year'), '/');
        }
        
        $clientId = $_SESSION['clientData']['clientid'];
        echo $clientId;
        include 'view/dashboard.php';

    break;

    case 'logout':
        $_SESSION = array();
        session_destroy();
        include 'view/dashboard.php';
        exit;
    break;

    case 'newregistration':
        include 'view/register.php';
        exit;
    break;
    
    case 'register':
        //Filter and store data
        $clientName = filter_input(INPUT_POST, 'clientName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $passcode = filter_input(INPUT_POST, 'passcode', FILTER_SANITIZE_STRING);
        
        //check for missing data
        if (empty($clientName) || empty($email) || empty($passcode)) {
            $msg = '<p class="notice">Please provide information for all empty form fields.</p>';
            include 'view/register.php';
            exit;
        }
        
        //check for valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = '<p class="notice">Not a valid email. Please try again.</p>';
            include 'view/register.php';
            exit;
        }

        // Check that password meets requirements
        if( strlen($passcode) < 8 ) {
            $msg = '<p class="notice">Password is too short!</p>';
            include 'view/register.php';
            exit;
        }

        if( !preg_match("#[0-9]+#", $passcode) ) {
            $msg = '<p class="notice">Password must include at least one number!</p>';
            include 'view/register.php';
            exit;
        }

        if( !preg_match("#[A-Z]+#", $passcode) ) {
            $msg = '<p class="notice">Password must include at least one CAPS!</p>';
            include 'view/register.php';
            exit;
        }
        
        //check for existing email
        $existingEmail = checkExistingEmail($email);
 
        if ($existingEmail){
            $msg = '<p class="notice">Email already exists, do you want to login?</p>';
            include 'view/login.php';
            exit;
        }

        // Hash the checked password
        $hashed = password_hash($passcode, PASSWORD_DEFAULT);

        //Send data to the model
        $newRegistration = addClient($clientName, $email, $hashed);

        if ($newRegistration === 1) {
            setcookie('clientName', $clientName, strtotime('+1 year'), '/');
            $msg = "<p class='notice'>Thanks for registering $clientName!</p>";
            include 'view/login.php';
            exit;
        } else {
            $msg = "<p class='notice'>Sorry, but the registration failed. Please try again.</p>";
            include 'view/register.php';
            exit;
        }
        exit;   
    break;

    case 'newexpense':
        $clientId = $_SESSION['clientData']['clientid'];
        $clientBudgets = getClientBudgets($clientId);
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
        $clientId = $_SESSION['clientData']['clientid'];
        $clientBudgets = getClientBudgets($clientId);
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
        $clientId = $_SESSION['clientData']['clientid'];
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
    $clientId= $_SESSION['clientData']['clientId'];
    $clientBudgets = getClientBudgets($clientId);
    $dashdisplay = buildDashDisplay($clientBudgets);
    include 'view/dashboard.php';
}