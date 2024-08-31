<?PHP

require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";

$timestamp = isset($_GET["timestamp"])?$_GET["timestamp"]:"";
$key = isset($_GET["APIKEY"])?$_GET["APIKEY"]:"";
if($key!=$GLOBAL_API_KEY){
  echo json_encode(["message"=>"Invalid API KEY"]);
  exit;
}

if($timestamp!=""){
    $where = " where timestamp = :timestamp ";
    $params = [":timestamp"=>$timestamp];
  }else{
    $where = " ";
    $params = null;
  }
  $sql = "select * from product ".$where;
  $data = FoodDatabase::getDataFromSQL($sql, $params);
      
  echo json_encode($data);
  