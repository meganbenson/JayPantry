<?PHP
require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";
$id = isset($_POST["id"]) ? intval($_POST["id"]) : "";
$key = isset($_POST["APIKEY"])?$_POST["APIKEY"]:"";
if($key!=$GLOBAL_API_KEY){
  echo json_encode(["message"=>"Invalid API KEY"]);
  exit;
}
//Hard coding
/*print_r($_POST);
exit;
if($id==""||$id==0){
    /*echo json_encode(["message"=>"No Product ID"]);
    exit;
*/

$params = [":id"=>$id];
$sql = "delete from product WHERE productID=:id;";
FoodDatabase::executeSQL($sql, $params);
$message = ["message"=>"Product Deleted Successfully"];
echo json_encode($message);
