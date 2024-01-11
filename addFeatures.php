/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:51:21
**/
<?php
include_once("./auth/authenticate.php");
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['bid']) && isset($_POST['feature']) && isset($_POST['font_family']) && isset($_POST['font_size']) && isset($_POST['font_style']) && isset($_POST['typograph'])) {
    $bid = sanitizeData($_POST['bid']);
    $features = $_POST['feature'];
    $font_family = sanitizeData($_POST['font_family']);
    $font_size = sanitizeData($_POST['font_size']);
    $font_style = sanitizeData($_POST['font_style']);
    $typograph = sanitizeData($_POST["typograph"]);

    if (empty($bid))
        $resp['message'] = "Invalid credentials!.";
    else if (count($features))
        $resp['message'] = "Please select features!.";
    else if (empty($font_family))
        $resp['message'] = "Please select Font Family.";
    else if (empty($font_size))
        $resp['message'] = "Please enter Font Size";
    else if (empty($font_style))
        $resp['message'] = "Please select Font Style";
    else if (empty($typograph))
        $resp['message'] = "Please select Typograph";
    else {
        $features_serialize = serialize($features);

        $qry = $DBConn->query("udpate business set feature = '$features_serialize', font_family = '$font_family', font_size = '$font_size', font_style = '$font_style', typograph = '$typograph' where id = '$bid' limit 1");
        if ($qry) {
            $resp['status'] = 1;
            $resp['message'] = "Features added successfully!.";
        }
    }
}

echo json_encode($resp);
?>