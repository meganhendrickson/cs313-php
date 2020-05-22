<?php

/* EXPENSE TRACKER CONTROLLER */

// Create or access a Session
session_start();

$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }


switch ($action){
    case 'something':
    break;

    default:
        include 'view/dashboard.php';
}