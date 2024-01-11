/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:51:52
**/
<?php
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Records not found!.", "data" => array());

$qry = $DBConn->query("select * from certificate");
$d = $qry->fetch_array();
if ($d != null) {
    if (count($d) > 0) {
        $resp['status'] = 1;
        $resp['message'] = "Certificate rocords found!";
        $resp['data'] = $d;
    }
}
echo json_encode($resp);
?>