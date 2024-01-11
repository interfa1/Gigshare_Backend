/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 15:01:41
**/
<?php
// Code By Akash Fulari on 01-06-2024 
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['bid']) && isset($_POST['logo']) && isset($_POST['adharcard']) && isset($_POST['pancard']) && isset($_POST['customercard']) && isset($_POST['productcard']) && isset($_POST['category']) && isset($_POST['name']) && isset($_POST['gstn']) && isset($_POST['panno']) && isset($_POST['appname']) && isset($_POST['email']) && isset($_POST['adharno']) && isset($_POST['administrator']) && isset($_POST['phoneno'])) {
    $bid = sanitizeData($_POST['bid']);
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

    if (empty($bid))
        $resp['message'] = "Invalid Business ID.";
    else if (empty($brandLogoFilePath))
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
        $selQry = $DBConn->query("select * from business where id= '$bid' limit 1");
        $selData = $selQry->fetch_assoc();
        if ($selData!=null) {
            $BID = $selData["id"];
            $oldDBName = $selData["business_name"];

            if(DBSwitcher($oldDBName, $b_name)){
                $qry = $DBConn->query("update business set category_id = '$b_category', business_name = '$b_name', logo = '$brandLogoFilePath', gstn_no = '$b_gstn', pan_no = '$b_panno', app_name = '$b_appname', email_id = '$b_email', adhar_no = '$b_adharno', administrator = '$b_administrator', phone_no = '$b_phoneno' , alter_no = '$b_alternativeno' where id = '$bid' and createdBy = '$authId' limit 1");
                if ($qry) {
                    $doc_qry = $DBConn->query("update documents set adhar_card = '$adharCardFilePath', pan_card = '$panCardFilePath', customer_card = '$customerCardFilePath', product_card = '$productCardFilePath' where business_id = '$BID' and createdBy = '$authId' limit 1");
                    if ($doc_qry) {
                        $resp['status'] = 1;
                        $resp['message'] = "Business udpated successfully!";
                    } else {
                        $resp['message'] = "Sorry, there was an error updating product document files.";
                    }
                } else {
                    $resp['message'] = "Sorry, there was an error uploading your file.";
                }
            }else{
                $resp['message'] = "Unable to change DB Name.";
            }
        } else {
            $resp['message'] = "Invalid Business ID.";
        }
    }
}

echo json_encode($resp);
?>