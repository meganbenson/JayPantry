<?php
session_start(); 

//include '../includes/database_config.php';
include '../includes/config.php';
require_once "../classes/LoginProcess.php";
require_once "../classes/DatabaseAPIConnection.php";


error_reporting(E_ALL);
ini_set('display_errors', 1);

global $api_key;
global $url;

if (isset($_GET['id'])) {
    $id = $_GET["id"];
    $success = LoginProcess::processLogin($id,"",$url);
    if(!$success){
     
        $_SESSION["LoginAttemptID"]=$id;
     
    }
   
    header('Location: ../kiosk.php');
    
}

?>