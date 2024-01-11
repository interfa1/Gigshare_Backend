/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:51:13
**/
<?php

include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['certificate']) && isset($_POST['b_id']) && isset($_POST['certificate_name']) && isset($_POST['expire_date']) && isset($_POST['no_expire_date'])) {
    $b_id = sanitizeData($_POST['b_id']);
    $cert_name = sanitizeData($_POST['certificate_name']);
    $expire_date = sanitizeData($_POST['expire_date']);
    $no_expire_date = sanitizeData($_POST['no_expire_date']);
    $certificateFilePath = sanitizeData($_POST["certificate"]);

    if (empty($b_id))
        $resp['message'] = "Invalid business id credential!.";
    else if (empty($certificateFilePath))
        $resp['message'] = "Please select a Certificate File to upload.";
    else if (empty($cert_name))
        $resp['message'] = "Please enter Document Name";
    else if (empty($expire_date))
        $resp['message'] = "Please select Expiry Date";
    else {
        $no_expir_column = "";
        $no_expir = "";
        if (!empty($no_expire_date)) {
            $no_expir = ", '$no_expire_date'";
            $no_expir_column = ", no_expir";
        }

        $qry = $DBConn->query("insert into certificate(business_id, certificate_name, certificate_path, expire_date $no_expir_column, createBy) values(' $b_id ', ' $cert_name ', ' $certificateFilePath ', ' $expire_date ' $no_expir, '$authId')");
        if ($qry) {
            $resp['status'] = 1;
            $resp['message'] = "Certificate added successfully!.";
        }
    }
}

echo json_encode($resp);
?>