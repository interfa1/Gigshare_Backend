/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:29:07
**/
<?php
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['pid']) && isset($_POST['product_name']) && isset($_POST['product_image']) && isset($_POST['mrp']) && isset($_POST['quantity']) && isset($_POST['unit'])) {
    $pid = sanitizeData($_POST['pid']);
    $ProdName = sanitizeData($_POST['product_name']);
    $ProdImagePath = sanitizeData($_POST['product_image']);
    $ProdMrp = sanitizeData($_POST['mrp']);
    $ProdQuantity = sanitizeData($_POST['quantity']);
    $ProdUnit = sanitizeData($_POST["unit"]);
    
    if (empty($pid))
        $resp['message'] = "Invalid Product ID";
    else if (empty($ProdName))
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
        $qry = $DBConn->query("update product set product_name = '$ProdName', product_image = '$ProdImagePath', mrp = '$ProdMrp', quantity = '$ProdQuantity', unit = '$ProdUnit' where id = '$pid' and createdBy = '$authId' limit 1");
        if ($qry) {
            $resp['status'] = 1;
            $resp['message'] = "Product updated successfully!.";
        }
        else{
            $resp['message'] = "Invalid Product ID.";
        }
    }
}

echo json_encode($resp);
?>