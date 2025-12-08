<?php
require_once "includes/config.php";
require_once "classes/DatabaseAPIConnection.php";


// These must use "" (empty string) or the API will reject them.
$catID = isset($_GET["catID"]) ? $_GET["catID"] : "";
$id    = isset($_GET["id"])    ? $_GET["id"]    : "";

// Number of barcode copies per product
$copies = isset($_GET["copies"]) ? intval($_GET["copies"]) : 1;
if ($copies <= 0) { $copies = 1; }



$fullUrl = $url . "/data_src/api/products/read.php";

$vars = [
    "APIKEY" => $api_key,
    "catID"  => $catID,   // empty string = “no category filter”
    "id"     => $id       // empty string = “no id filter”
];

$response = DatabaseAPIConnection::get($fullUrl, $vars);
$products = json_decode($response, true);

// Validate JSON response format
if ($products === null || !is_array($products)) {
    die("Invalid product response from API.");
}

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
<?php 
foreach ($products as $p): 
    if (!isset($p["productID"])) continue;

    $barcodeValue = $p["productID"];  // barcode = productID

    for ($i = 0; $i < $copies; $i++):
?>
    <div class="label">
        <img
            src="barcode.php?s=code128&code=<?= urlencode($barcodeValue) ?>&f=png"
            alt="Barcode for <?= htmlspecialchars($p['productName'] ?? 'Item') ?>"
        >
    </div>
<?php
    endfor;
endforeach;
?>
</div>

</body>
</html>
