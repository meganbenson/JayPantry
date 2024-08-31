<?php
echo("bahhhhh");

session_start();

include '../includes/config.php'; // Update this to your configuration file
require_once "../classes/DatabaseAPIConnection.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $api_key;
global $url;

print_r($_GET['id']);
if (isset($_GET['id'])) { 
    print_r("made it into if");
    print_r($_GET['id']);
    $url = $url."/data_src/api/cart/checkout.php";
    
    $data = [
        "APIKEY" => $api_key,
        "id" => $_SESSION["CartID"]
    ];
    //issues with the following line
    $result = DatabaseAPIConnection::post($url, $data);
   
    if ($result === FALSE) {
        $error = error_get_last();
        echo "HTTP request failed. Error was: " . $error['message'];
    }
   
    $response = json_decode($result, true);
    $_SESSION["CartID"] = null;
    $_SESSION["LoginStatus"] = null;
    $_SESSION["userId"] = null;
    $_SESSION["LoginAttemptID"] = null;
    $_SESSION["isAdmin"] = null;

    $_SESSION["error"]=null;
    // Redirect to a confirmation page or any other appropriate page.
    //header('Location: ../index.php?page=products');

    //Log user out and return to kiosk screen
    header('Location: ../kiosk.php?page=thanks');
    
}

    ?>