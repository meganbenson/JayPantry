<?php
require_once "includes/config.php";
require_once "classes/DatabaseAPIConnection.php";

// Get the product ID from URL (0 means print all)
$productID = isset($_GET['productID']) ? intval($_GET['productID']) : 0;

// Number of labels per product
$labelsPerPage = isset($_GET['labels']) ? intval($_GET['labels']) : 30;
if ($labelsPerPage <= 0 || $labelsPerPage > 30) {
    $labelsPerPage = 30;
}

// -------------------------
// Print ALL product barcodes
// -------------------------
if ($productID === 0) {

    // API path for reading all products
    $fullUrl = $url . "/data_src/api/products/read.php";

    // API parameters
    $vars = [
        "APIKEY" => $api_key,
        "catID"  => "",
        "id"     => ""
    ];

    // Call API
    $web_string = DatabaseAPIConnection::get($fullUrl, $vars);
    $allProducts = json_decode($web_string);

    // No products returned
    if (!is_array($allProducts) || count($allProducts) === 0) {
        die("No products found.");
    }
    ?>
    
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Print All Barcodes</title>
        <style>
            @page { size: 8.5in 11in; margin: 0.5in; }
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
            <?php foreach ($allProducts as $p): ?>
                <?php for ($i = 0; $i < $labelsPerPage; $i++): ?>
                    <div class="label">
                        <img src="barcode.php?s=code128&d=<?= $p->productID ?>&f=png">
                    </div>
                <?php endfor; ?>
            <?php endforeach; ?>
        </div>
    </body>
    </html>

    <?php
    exit;
}

// -------------------------
// Print ONE product barcode
// -------------------------
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Barcode</title>
    <style>
        @page { size: 8.5in 11in; margin: 0.5in; }
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
        <?php for ($i = 0; $i < $labelsPerPage; $i++): ?>
            <div class="label">
                <img src="barcode.php?s=code128&d=<?= $productID ?>&f=png">
            </div>
        <?php endfor; ?>
    </div>
</body>
</html>
