<?PHP

require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";

$table = isset($_POST["table"])?$_POST["table"]:"";
$id = isset($_POST["id"])?$_POST["id"]:"";
$catID = isset($_POST["catID"])?$_POST["catID"]:"";
$key = isset($_POST["APIKEY"])?$_POST["APIKEY"]:"";
if($key!=$GLOBAL_API_KEY){
  echo json_encode(["message"=>"Invalid API KEY"]);
  exit;
}

$user = isset($_POST["user"])?$_POST["user"]:"";
if($user!=""){
  $where = " where username = :user ";
  $params = [":user"=>$user];
}else{
  $where = " where 1=2 ";
  $params = null;
}
$sql = "select * from user ".$where;
$data = FoodDatabase::getDataFromSQL($sql, $params);

echo json_encode($data);

?>