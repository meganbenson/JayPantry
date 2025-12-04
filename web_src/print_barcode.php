<?php
require_once "includes/config.php";
require_once "classes/DatabaseAPIConnection.php";

// SAME INPUTS AS GET LABELS
$catID = isset($_GET["catID"]) ? $_GET["catID"] : "";
$id    = isset($_GET["id"]) ? $_GET["id"] : "";

// Number of copies per product
$copies = isset($_GET["copies"]) ? intval($_GET["copies"]) : 1;
if ($copies <= 0) $copies = 1;

// Fetch products (same as labels)
$fullUrl = $url . "/data_src/api/products/read.php";
$vars = ["APIKEY" => $api_key, "catID" => $catID, "id" => $id];

$response = DatabaseAPIConnection::get($fullUrl, $vars);
$products = json_decode($response, true);

if (!$products) { die("No products found."); }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Print Barcodes</title>

<style>
.sheet {
    width: 7.5in;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 2.5in);
    grid-auto-rows: 1in;
}
.label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.05in;
}
.label img {
    max-width: 100%;
    max-height: 100%;
}
</style>
</head>
<body onload="window.print();">

<div class="sheet">
<?php foreach ($products as $p): 
        $barcodeValue = $p["productID"];  // <= THIS IS THE BARCODE
        for ($i = 0; $i < $copies; $i++):
?>
    <div class="label">
        <img
            src="barcode.php?s=code128&code=<?= urlencode($barcodeValue) ?>&f=png"
            alt="Barcode for <?= htmlspecialchars($p['productName']) ?>"
        >
    </div>
<?php
        endfor;
    endforeach;
?>
</div>

</body>
</html>
