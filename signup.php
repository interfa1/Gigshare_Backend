/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 15:01:19
**/
<?php
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = sanitizeData($_POST['username']);
    $email = sanitizeData($_POST['email']);
    $password = sanitizeData($_POST['password']);

    if (empty($email))
        $resp['message'] = "Please enter Email-ID";
    else if (empty($username))
        $resp['message'] = "Please enter Username";
    else if (!filter_var($username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/"))))
        $resp['message'] = "Please enter valid Username";
    else if (empty($password))
        $resp['message'] = "Please enter Password";
    else {
        $pass = md5($password);
        $qry = $DBConn->query("insert into user(user_name, email, password) values('$username', '$email', '$pass')");
        if ($qry) {
            $resp['status'] = 1;
            $resp['message'] = "User account created successfully!.";
        }
    }
}

echo json_encode($resp);
?>