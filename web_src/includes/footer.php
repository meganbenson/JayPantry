
 
<script>
function editInventoryItem(id){
  location.href = "index.php?page=edit&editID=" + id;

}
function addInventoryItem(){
  location.href = "index.php?page=edit&editID=add";

}
function getLabels(){
  location.href = "index.php?page=labels";
}
function addItem(id,qty){
  location.href = "utils/addToCart.php?id="+id+"&qty="+qty;
  //alert("add cart item id " + id + " with quantity " + qty);
}
function addItemFromScanner(id,qty){
  location.href = "utils/scanToCart.php?id="+id+"&qty="+qty;
  //alert("add cart item id " + id + " with quantity " + qty);
}
function addIDNumFromScanner(id){
  location.href = "utils/scanID.php?id="+id;
  //alert("add cart item id " + id + " with quantity " + qty);
}

function removeItem(id, basket_item_id){
  location.href = "utils/removeFromCart.php?id=" + id + "&basket_item_id=" + basket_item_id;

  //alert("remove from cart item id " + id);
}

function checkoutCart(id){
 location.href = "utils/checkoutCart.php?id=" + id;
}
function goToScannerPage(id){
 location.href = "index.php?page=scannercart&id=" + id;
}
function goToKiosk(){
 location.href = "kiosk.php";
}


function UpdateCartQty(id,qty) {
  location.href = "utils/updateCartQty.php?id="+id+"&qty="+qty;
  //alert("+1");
}

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}


</script>
<?PHP

include "includes/scannerjs.php";  

?>
</body>
</html>