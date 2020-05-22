<?php

/* EXPENSE TRACKER CONTROLLER */

// Create or access a Session
session_start();

// Get the common functions file
require_once $_SERVER['DOCUMENT_ROOT'].'/expensetracker/library/functions.php';

$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }


switch ($action){
    case 'something':
    break;

    default:
    $clientBudgets = getClientBudgets(1);
    
    $dashdisplay = buildDashDisplay($clientBudgets);
     print_r (getClientBudgets(1));

     print_r (getClientExpenses(1));
        include 'view/dashboard.php';
}