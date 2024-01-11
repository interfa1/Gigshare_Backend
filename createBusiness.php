/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 15:05:46
**/
<?php
// Code By Akash Fulari on 01-06-2024 
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['logo']) && isset($_POST['adharcard']) && isset($_POST['pancard']) && isset($_POST['customercard']) && isset($_POST['productcard']) && isset($_POST['category']) && isset($_POST['name']) && isset($_POST['gstn']) && isset($_POST['panno']) && isset($_POST['appname']) && isset($_POST['email']) && isset($_POST['adharno']) && isset($_POST['administrator']) && isset($_POST['phoneno'])) {
    $b_name = sanitizeData($_POST['name']);
    $b_category = sanitizeData($_POST['category']);
    $b_gstn = sanitizeData($_POST['gstn']);
    $b_panno = sanitizeData($_POST['panno']);
    $b_appname = sanitizeData($_POST['appname']);
    $b_email = sanitizeData($_POST['email']);
    $b_adharno = sanitizeData($_POST['adharno']);
    $b_administrator = sanitizeData($_POST['administrator']);
    $b_phoneno = sanitizeData($_POST['phoneno']);
    $b_alternativeno = sanitizeData($_POST['alternativeno']);

    $brandLogoFilePath = sanitizeData($_POST["logo"]);
    $adharCardFilePath = sanitizeData($_POST["adharcard"]);
    $panCardFilePath = sanitizeData($_POST["pancard"]);
    $customerCardFilePath = sanitizeData($_POST["customercard"]);
    $productCardFilePath = sanitizeData($_POST["productcard"]);


    if (empty($brandLogoFilePath))
        $resp['message'] = "Please select a Bussiness Logo to upload.";
    else if (empty($b_name))
        $resp['message'] = "Please enter Bussiness Name";
    else if (empty($b_category))
        $resp['message'] = "Please select Bussiness Category";
    else if (empty($b_gstn))
        $resp['message'] = "Please enter GSTN Number";
    else if (empty($b_panno))
        $resp['message'] = "Please enter Pan Number";
    else if (empty($b_appname))
        $resp['message'] = "Please enter App Name";
    else if (empty($b_email))
        $resp['message'] = "Please enter Bussiness Email-ID";
    else if (empty($b_adharno))
        $resp['message'] = "Please enter Adhar Number";
    else if (empty($b_administrator))
        $resp['message'] = "Please enter Administrator";
    else if (empty($b_phoneno))
        $resp['message'] = "Please enter Phone Number";
    else if (empty($adharCardFilePath))
        $resp['message'] = "Please select a Adharcard File to upload.";
    else if (empty($panCardFilePath))
        $resp['message'] = "Please select a Pancard File to upload.";
    else if (empty($customerCardFilePath))
        $resp['message'] = "Please select a Customer Card File to upload.";
    else if (empty($productCardFilePath))
        $resp['message'] = "Please select a Product Card File to upload.";
    else {
        $respDBMaker = DBMaker($b_name, "products", ["product_name", "product_mrp", "product_quantity", "product_units"]);
        if ($respDBMaker) {
            $alt_no_column = "";
            $alt_no = "";
            if (!empty($b_alternativeno)) {
                $alt_no = ", '$b_alternativeno'";
                $alt_no_column = ", alter_no";
            }

            $qry = $DBConn->query("insert into business( category_id, business_name, logo, gstn_no, pan_no, app_name, email_id, adhar_no, administrator, phone_no $alt_no_column, createdBy) values(' $b_category ', ' $b_name ', ' $brandLogoFilePath ', ' $b_gstn ', ' $b_panno ', ' $b_appname ', ' $b_email ', ' $b_adharno ', ' $b_administrator ', ' $b_phoneno ' $alt_no, '$authId')");
            if ($qry) {
                $BID = $DBConn->insert_id;

                $doc_qry = $DBConn->query("insert into documents(adhar_card, pan_card, customer_card, product_card, business_id, createdBy) values('$adharCardFilePath', '$panCardFilePath', '$customerCardFilePath', '$productCardFilePath', '$BID', '$authId')");
                if ($doc_qry) {
                    $resp['status'] = 1;
                    $resp['message'] = "Business to created successfully!";
                } else {
                    $resp['message'] = "Sorry, there was an error uploading product document files.";
                }
            } else {
                $resp['message'] = "Sorry, there was an error uploading your file.";
            }
        } else {
            $resp['message'] = "Sorry, there was an error create DB with Bussiness Name.";
        }
    }
} 

echo json_encode($resp);
?>