<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL & ~E_NOTICE);
session_start();

require_once "includes/config.php";
require_once "classes/DatabaseAPIConnection.php";
require_once "classes/SaveProcessRouter.php";
require_once "classes/LoginProcess.php";
require_once "classes/PageRouter.php";
require_once "classes/GeneralContent.php";
require_once "classes/EditItemForm.php";
require_once "classes/CheckLang.php";
require_once "lang/loadLang.php";

$title = "Blue Jay Pantry";
$content = '';

SaveProcessRouter::processData();

if(!isset($_SESSION["LoginStatus"]) || $_SESSION["LoginStatus"] != "YES"){
    if(!isset($_SESSION["LoginAttemptID"])){

        if(isset($_GET["page"]) && $_GET["page"]=="thanks"){
            $content .= GeneralContent::getKioskThanks();
        }else{
            $content .= GeneralContent::getKioskWelcome();
        }
       
        //echo "HERE WITH" . $_SESSION["LoginAttemptID"];
    }else{
        $content .= GeneralContent::getRegisterForm($_SESSION["LoginAttemptID"]);
    }
}else{
    $message = "Please use the scanner to scan items.<BR>When finished press the Check Out button.";
                
    $content .= GeneralContent::getKioskWelcome($message);
    $content .= PageRouter::getContent("scannercart",$url);
}

//page content now out to screen
require_once "includes/header.php";

echo $content;



require_once "includes/footer.php";
?>