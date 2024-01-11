/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:28:43
**/
<?php
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Records not found!.", "data" => array());
if (isset($_POST["customer_name"])) {
    $customer_name = sanitizeData($_POST["customer_name"]);
    if (empty($customer_name))
        $resp['message'] = "Please enter Customer Name";
    else {
        $qry = $DBConn->query("select * from customer where name like %$customer_name%");
        $d = $qry->fetch_array();
        if ($d != null) {
            $resp['status'] = 1;
            $resp['message'] = "Customer records found";
            $resp['data'] = json_encode($d);
        }else{
            $resp['message'] = "Customer not found!";
        }
    }
}
echo json_encode($resp);
?>