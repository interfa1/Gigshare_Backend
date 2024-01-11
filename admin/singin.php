/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:29:09
**/
<?php
include_once("../config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['business_name']) && isset($_POST['mobile_number'])) {
    $bName = sanitizeData($_POST['business_name']);
    $bMobileNumber = sanitizeData($_POST['mobile_number']);

    if (empty($bName))
        $resp['message'] = "Please enter Business Name";
    else if (empty($bMobileNumber))
        $resp['message'] = "Please enter Business Mobile Number";
    else {
        $selQry = $DBConn->query("select * from business where business_name = '$bName' and phone_no = '$bMobileNumber' limit 1");
        $ftch_slqry = $selQry->fetch_assoc();
        $rows = $ftch_slqry->num_rows;
        if($rows>0){
            if ($ftch_slqry['isActive'] == 1) {
                try {
                    $token = generateToken($ftch_slqry['id']);

                    $resp['status'] = 1;
                    $resp['message'] = "Login successfully!.";
                    $resp['data'] = array('token' => $token);
                } catch (Exception $e) {
                    $resp['message'] = "SOrry Unable to generate Token Key.";
                }
            } else {
                $resp['message'] = "Please activate your bussiness account!.";
            }
        } else {
            $resp['message'] = "Invalid Business Name & Mobile Number";
        }

    }
}

echo json_encode($resp);
?>