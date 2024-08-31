<?PHP

require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";

$table = isset($_GET["table"])?$_GET["table"]:"";
$id = isset($_GET["id"])?$_GET["id"]:"";
$catID = isset($_GET["catID"])?$_GET["catID"]:"";
$key = isset($_GET["APIKEY"])?$_GET["APIKEY"]:"";
$qty = isset($_GET["qty"])?$_GET["qty"]:1;
if($key!=$GLOBAL_API_KEY){
  echo json_encode(["message"=>"Invalid API KEY"]);
  exit;
}
if ($id == "" || $id == 0) {
  $sql = "select * from basketItem B inner join product p on p.productID=B.productID ";
  $params = null;
  $data = FoodDatabase::getDataFromSQL($sql, $params);
  echo json_encode($data);
} else {
$where = " WHERE B.basketID = :basketID ";
$params = [":basketID"=>$id];
$sql = "select * from basketItem B inner join product p on p.productID=B.productID ".$where;
$data = FoodDatabase::getDataFromSQL($sql, $params);
echo json_encode($data);
}
?>