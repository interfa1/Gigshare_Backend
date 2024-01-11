/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:28:20
**/
<?php
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "");
if (isset($_POST['name']) && isset($_POST['mobile']) && isset($_POST['dob']) && isset($_POST['product_ids']) && isset($_POST['product_names']) && isset($_POST['product_quantities']) && isset($_POST['product_prices']) && isset($_POST['product_units'])) {
    $name = sanitizeData($_POST['name']);
    $mobile = sanitizeData($_POST['mobile']);
    $dob = sanitizeData($_POST['dob']);

    $product_ids = $_POST['product_ids'];
    $product_names = $_POST['product_names'];
    $product_quantities = $_POST['product_quantities'];
    $product_prices = $_POST['product_prices'];
    $product_units = $_POST['product_units'];
    $size = count($product_ids);

    if (empty($name))
        $resp['message'] = "Please enter Customer Name";
    else if (empty($mobile))
        $resp['message'] = "Please enter Customer Mobile Number";
    else if (empty($dob))
        $resp['message'] = "Please enter Customer Date Of Birth";
    else if (empty($product_ids) || empty($product_names) || empty($product_quantities) || empty($product_prices) || empty($product_units))
        $resp['message'] = "Invalid Product Credentials";
    else if (count($product_names) != $size || count($product_quantities) != $size || count($product_prices) != $size || count($product_units) != $size)
        $resp['message'] = "Invalid Product Credentials, Credential size are not same";
    else {
        $selQry = $DBConn->query("Select * from customer where name = '$name' && mobile = '$mobile' limit 1");
        $fthQry = $selQry->fetch_assoc();
        $numRows = $selQry->num_rows;
        $cst_id = null;
        if ($numRows>0)
            $cst_id = $fthQry["id"];
        else {
            $insQry = $DBConn->query("insert into customer(name, mobile, dob, createdBy) values('$name', '$mobile', '$dob', '$authId')");
            if ($insQry)
                $cst_id = $DBConn->insert_id;
        }


        if ($cst_id != null) {
            foreach ($product_ids as $i => $product_id) {
                $qry = $DBConn->query("insert into product_order(product_id, customer_id, product_name, unit, quantity, price) values('$product_id', '$cst_id', '$product_names[$i]', '$product_units[$i]', '$product_quantities[$i]', '$product_prices[$i]')");
                if ($qry) {
                    $resp['status'] = 1;
                    $resp['message'] = "User account created successfully!.";
                }
            }
        }else{
            $resp['message'] = "Unable to create customer account.";
        }
    }
}

echo json_encode($resp);
?>