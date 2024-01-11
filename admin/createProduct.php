/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:28:26
**/
<?php
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['product_name']) && isset($_POST['product_image']) && isset($_POST['mrp']) && isset($_POST['quantity']) && isset($_POST['unit'])) {
    $ProdName = sanitizeData($_POST['product_name']);
    $ProdImagePath = sanitizeData($_POST['product_image']);
    $ProdMrp = sanitizeData($_POST['mrp']);
    $ProdQuantity = sanitizeData($_POST['quantity']);
    $ProdUnit = sanitizeData($_POST["unit"]);

    if (empty($ProdName))
        $resp['message'] = "Please enter the product name";
    else if (empty($ProdImagePath))
        $resp['message'] = "Please select a Product image File to upload.";
    else if (empty($ProdMrp))
        $resp['message'] = "Please enter Product MRP";
    else if (empty($ProdQuantity))
        $resp['message'] = "Please enter Product Quantity";
    else if (empty($ProdUnit))
        $resp['message'] = "Please enter Product Unit";
    else {
        $qry = $DBConn->query("insert into product(product_name, product_image, mrp, quantity, unit, createdBy) values(' $ProdName ', ' $ProdImagePath ', ' $ProdMrp ', ' $ProdQuantity ', '$ProdUnit', '$authId')");
        if ($qry) {
            $resp['status'] = 1;
            $resp['message'] = "Product added successfully!.";
        }
    }
}

echo json_encode($resp);
?>