<?php
require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";   
        
       
   
$key = isset($_POST["APIKEY"])?$_POST["APIKEY"]:""; 
$basketID = isset($_POST["basketID"])?intval($_POST["basketID"]):"";
$productID = isset($_POST["productID"])?intval($_POST["productID"]):"";
$qty = isset($_POST["qty"])?intval($_POST["qty"]):1;

if($key!=$GLOBAL_API_KEY){
  echo json_encode(["message"=>"Invalid API KEY"]);
  exit;
}
if($basketID==""||$basketID==0){
  echo json_encode(["message"=>"No Basket ID"]);
  exit;
}

$params = [":qty"=>$qty, ":productID"=>$productID, ":basketID"=>$basketID];
$sql = "UPDATE basketItem set qty=:qty WHERE productID=:productID AND basketID= :basketID;";

$status = FoodDatabase::executeSQL($sql, $params);

if ($status) {
    echo json_encode(["message" => "✅ Cart Item Updated!"]);
} else {
    echo json_encode(["message" => "❌ Cannot Update Cart Item!"]);
}


?>