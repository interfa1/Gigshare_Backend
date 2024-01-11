/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 15:01:36
**/
<?php
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['cid']) && isset($_POST['certificate']) && isset($_POST['b_id']) && isset($_POST['certificate_name']) && isset($_POST['expire_date']) && isset($_POST['no_expire_date'])) {
    $cid = sanitizeData($_POST['cid']);
    $b_id = sanitizeData($_POST['b_id']);
    $cert_name = sanitizeData($_POST['certificate_name']);
    $expire_date = sanitizeData($_POST['expire_date']);
    $no_expire_date = sanitizeData($_POST['no_expire_date']);
    $certificateFilePath = sanitizeData($_POST["certificate"]);

    if (empty($cid))
        $resp['message'] = "Invalid certificate ID credential!.";
    else if (empty($b_id))
        $resp['message'] = "Invalid business id credential!.";
    else if (empty($certificateFilePath))
        $resp['message'] = "Please select a Certificate File to upload.";
    else if (empty($cert_name))
        $resp['message'] = "Please enter Document Name";
    else if (empty($expire_date))
        $resp['message'] = "Please select Expiry Date";
    else {
        $no_expir = "";
        if (!empty($no_expire_date))
            $no_expir = ", no_expir = '$no_expire_date'";

        $qry = $DBConn->query("update certificate set certificate_name = '$cert_name', certificate_path = '$certificateFilePath', expire_date = '$expire_date' $no_expir where business_id = ' $b_id ' and id = '$cid' and createdBy = '$authId' limit 1");
        if ($qry) {
            $resp['status'] = 1;
            $resp['message'] = "Certificate updated successfully!.";
        } else {
            $resp['message'] = "Invali certificate credentials.";
        }
    }
}

echo json_encode($resp);
?>