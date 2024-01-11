/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:40:47
**/
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");

include_once("./Helper/common.helper.php");

$target_dir = "uploads/";

$servername = "localhost";
$username = "root";
$password = "";
$DBName = "gigshare_data";

// Create connection
$DBConn = mysqli_connect($servername, $username, $password, $DBName);

if (!$DBConn)
    die("Unable to connect DB: " . mysqli_connect_error());

?>