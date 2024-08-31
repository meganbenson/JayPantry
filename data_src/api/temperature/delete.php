<?PHP
require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";
$timestamp = isset($_POST["timestamp"]) ? intval($_POST["timestamp"]) : "";
$key = isset($_POST["APIKEY"])?$_POST["APIKEY"]:"";
if($key!=$GLOBAL_API_KEY){
  echo json_encode(["message"=>"Invalid API KEY"]);
  exit;
}

$params = [":timestamp"=>$timestamp];
$sql = "delete from product WHERE timestamp=:timestamp;";
FoodDatabase::executeSQL($sql, $params);
$message = ["message"=>"Product Deleted Successfully"];
echo json_encode($message);
