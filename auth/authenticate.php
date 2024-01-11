/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:40:40
**/
<?php

include_once("./Helper/common.helper.php");

// Function to get the Authorization header
function getAuthorizationHeader(){
    $headers = apache_request_headers();
    $data = isset($headers['Authorization']) ? $headers['Authorization'] : null;

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    try {
        $data = extractToken($data);
    } catch (Exception $e) {
        $data = null;
    }
    return $data;
}

// Check if the Authorization header is set
$authId = getAuthorizationHeader();

if ($authId == null) {
    http_response_code(403);
    die("403 - Forbidden (Access Denied)");
}

?>