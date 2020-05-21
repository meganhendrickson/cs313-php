<?php

/* EXPENSE TRACKER CONTROLLER */

// Create or access a Session
session_start();

// Get database connection file
require_once("library/functions.php");

$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }


switch ($action){
    case 'something':
    exit;
    break;

    default:
        include ('view/dashboard.php');
}
