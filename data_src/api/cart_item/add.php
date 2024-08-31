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
//check for item in cart
$params = [":productID"=>$productID, ":basketID"=>$basketID];
$sql = "SELECT * FROM basketItem WHERE productID=:productID and basketID=:basketID;";
$basketItems = FoodDatabase::getDataFromSQL($sql, $params);

//if there then add one
if(count($basketItems)>0){
    $sql = "UPDATE basketItem set qty=qty+1 WHERE productID=:productID AND basketID= :basketID;";

}else{//otherwise just add basketItem
    $sql = "INSERT INTO basketItem (productID,basketID,qty) VALUES (:productID,:basketID,1);";
}

$status = FoodDatabase::executeSQL($sql, $params);

if ($status) {
    echo json_encode(["message" => "✅ Cart Item Updated!"]);
} else {
    echo json_encode(["message" => "❌ Cannot Update Cart Item!"]);
}


?>