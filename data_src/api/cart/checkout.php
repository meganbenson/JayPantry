<?php
require_once "../../includes/database_config.php";
require_once "../../classes/FoodDatabase.php";
require_once "../../classes/Validator.php";

$schema = [
    'id' => ['required' => true],
];
$validator = new Validator($schema, $_POST);
$validator->validate();

$key = isset($_POST["APIKEY"]) ? $_POST["APIKEY"] : "";
if ($key != $GLOBAL_API_KEY) {
    echo json_encode(["message" => "Invalid API KEY"]);
    http_response_code(401);
    exit;
}

$basketID = $_POST["id"];

/**
 * Checkout process steps:
 * 1. Retrieve basket and basket items
 * 2. Create a transaction for the user
 * 3. Create transactionDetails for each basket item
 * 4. Update product quantities
 * 5. Delete basket items and basket
 */

$get_basket_sql = "
    SELECT userID 
    FROM Basket 
    WHERE basketID = :basketID
";

$get_basketItems_sql = "
    SELECT productID, SUM(qty) AS quantity
    FROM basketItem 
    WHERE basketID = :basketID
    GROUP BY productID
";

$create_transaction_sql = "
    INSERT INTO transactions (date, userID)
    VALUES (NOW(), :userID)
";

$create_transactionsDetails_sql = "
    INSERT INTO transactionsDetails (transactionID, productID, quantity)
    VALUES (:transactionID, :productID, :quantity)
";

$update_product_qty_sql = "
    UPDATE product p
    JOIN basketItem bi ON p.productID = bi.productID
    SET p.quantity = p.quantity - bi.qty
    WHERE bi.basketID = :basketID
";

$delete_basketItem = "DELETE FROM basketItem WHERE basketID = :basketID";
$delete_basket = "DELETE FROM Basket WHERE basketID = :basketID";

$basketParams = [":basketID" => $basketID];

// ---- Get basket ----
$basket = FoodDatabase::getDataFromSQL($get_basket_sql, $basketParams);
if (count($basket) == 0) {
    echo json_encode(["message" => "Basket not found"]);
    http_response_code(404);
    exit;
}

$basket = $basket[0];

// ---- Get basket items ----
$basketItems = FoodDatabase::getDataFromSQL($get_basketItems_sql, $basketParams);
if (count($basketItems) == 0) {
    echo json_encode(["message" => "Basket is empty"]);
    http_response_code(400);
    exit;
}

FoodDatabase::startTransaction();
try {
    // Create new transaction
    $transactionParams = [":userID" => $basket["userID"]];
    $transactionID = FoodDatabase::executeSQL($create_transaction_sql, $transactionParams, true);

    // Create transaction details for each basket item
    foreach ($basketItems as $basketItem) {
        $transactionDetailsParams = [
            ":transactionID" => $transactionID,
            ":productID" => $basketItem["productID"],
            ":quantity" => $basketItem["quantity"],
        ];
        FoodDatabase::executeSQL($create_transactionsDetails_sql, $transactionDetailsParams);
    }

    // Update product quantities
    FoodDatabase::executeSQL($update_product_qty_sql, $basketParams);

    // Delete basket and its items
    FoodDatabase::executeSQL($delete_basketItem, $basketParams);
    FoodDatabase::executeSQL($delete_basket, $basketParams);

    FoodDatabase::commitTransaction();

    echo json_encode(["message" => "Checkout successful", "transactionID" => $transactionID]);
    http_response_code(200);
} catch (Exception $e) {
    FoodDatabase::rollbackTransaction();
    echo json_encode(["message" => "Checkout failed", "error" => $e->getMessage()]);
    http_response_code(500);
}
?>
