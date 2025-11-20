<?php
require_once "includes/config.php";
require_once "classes/DatabaseAPIConnection.php";
require_once "classes/SaveProcessRouter.php";
require_once "classes/LoginProcess.php";
require_once "classes/PageRouter.php";
require_once "classes/GeneralContent.php";
require_once "classes/EditItemForm.php";
require_once "classes/CheckLang.php";
require_once "lang/loadLang.php";

// Get productID from query string
$productID = isset($_GET['productID']) ? intval($_GET['productID']) : 0;

// How many labels to print (default: = 30)
$labelsPerPage = isset($_GET['labels']) ? intval($_GET['labels']) : 30;
if ($labelsPerPage <= 0 || $labelsPerPage > 30) {
    $labelsPerPage = 30;
}

if ($productID <= 0) {
    die("Invalid product.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Barcode Labels</title>

    <style>
        /* Page setup – tuned for Avery labels */
        @page {
            size: 8.5in 11in;
            margin: 0.5in;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 8.5in;
            height: 11in;
            font-family: Arial, sans-serif;
        }

        .sheet {
            width: 7.5in; 
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 2.5in); 
            grid-auto-rows: 1in;                      
            column-gap: 0.125in;
            row-gap: 0;
        }

        .label {
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.05in;
            overflow: hidden;
        }

        .label img {
            max-width: 100%;
            max-height: 100%;
        }

        @media print {
            body {
                overflow: hidden;
            }
        }
    </style>
</head>
<body onload="window.print();">

<div class="sheet">
    <?php for ($i = 0; $i < $labelsPerPage; $i++): ?>
        <div class="label">
            <!-- productID is the data encoded in the barcode -->
            <img
                src="barcode.php?s=code128&d=<?php echo $productID; ?>&f=png"
                alt="Barcode for product <?php echo $productID; ?>">
        </div>
    <?php endfor; ?>
</div>

</body>
</html>
