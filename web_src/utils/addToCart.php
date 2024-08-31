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
   
    $apiUrl = $url."/data_src/api/cart_item/create.php"; 
    $data = [
        "APIKEY" => $api_key,
        "basketID" => $_SESSION["CartID"],
        "productID" => $_GET["id"],
        "quantity"=>$_GET["qty"]
    ];

    //die("the id is " .$_GET["id"]);
    //die("the quantity is " .$_GET["qty"]);

    $result = DatabaseAPIConnection::post($apiUrl, $data);

    if ($result === FALSE) {
        $error = error_get_last();
        echo "HTTP request failed. Error was: " . $error['message'];
    }
    
    $response = json_decode($result, true);
   
    header('Location: ../index.php?page=products');
    
}

?>