<?PHP


require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";

$productName = isset($_POST["productName"])?$_POST["productName"]:"";
$catID = isset($_POST["catID"])?$_POST["catID"]:"";
$qty = isset($_POST["quantity"])?$_POST["quantity"]:"";
$img = isset($_POST["img"])?$_POST["img"]:"";
$key = isset($_POST["APIKEY"])?$_POST["APIKEY"]:"";
$expirationDate = isset($_POST["expirationDate"])?$_POST["expirationDate"]:"";
if($key!=$GLOBAL_API_KEY){
  echo json_encode(["message"=>"Invalid API KEY"]);
  exit;
}

if ($catID== ""){
  echo json_encode(["message"=> "Error: No Category Was Specified!"]);
}
$params = [":name"=>$productName,":cid"=>$catID,":q"=>$qty,":i"=>$img, ":expirationDate"=>$expirationDate];
$sql = "insert into product (productName,catID,quantity,img,expirationDate) VALUES (:name,:cid,:q,:i,:expirationDate);";
FoodDatabase::executeSQL($sql, $params);
$message = ["message"=>"Product Created Successfully"];
echo json_encode($message);
