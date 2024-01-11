/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 15:01:12
**/
<?php
include_once("./config/dbConn.php");

$resp = array("status" => 0, "message" => "Invalid Credentials!!!.");

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = sanitizeData($_POST['email']);
    $password = sanitizeData($_POST['password']);

    if (empty($email))
        $resp['message'] = "Please enter Email-ID";
    else if (empty($password))
        $resp['message'] = "Please enter Password";
    else {
        $pass = md5($password);

        $qry = $DBConn->query("select * from user where email = '$email' and password = '$pass'");
        $row = $qry->fetch_assoc();
        if ($qry->num_rows > 0) {
            if ($row['active'] == 1) {
                try {
                    $token = generateToken($row['id']);

                    $resp['status'] = 1;
                    $resp['message'] = "Login successfully!.";
                    $resp['data'] = array('token' => $token);
                } catch (Exception $e) {
                    $resp['message'] = "SOrry Unable to generate Token Key.";
                }
            } else {
                $resp['message'] = "Please activate your account!.";
            }
        } else {
            $resp['message'] = "Invalid username & password";
        }
    }
}

echo json_encode($resp);
?>