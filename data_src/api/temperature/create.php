<?PHP

require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";

$timestamp = isset($_POST["timestamp"])?$_POST["timestamp"]:"";
$temp = isset($_POST["temp"])?$_POST["temp"]:"";
$key = isset($_POST["APIKEY"])?$_POST["APIKEY"]:"";
if($key!=$GLOBAL_API_KEY){
    echo json_encode(["message"=>"Invalid API KEY"]);
    exit;
  }
$params = [":timestamp"=>$timestamp,":temp"=>$temp];
$sql = "insert into product (timestamp,temp) VALUES (:timestamp,:temp);";
FoodDatabase::executeSQL($sql, $params);
$message = ["message"=>"Product Created Successfully"];
echo json_encode($message);
    