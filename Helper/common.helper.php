/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:40:54
**/
<?php

include_once("encrypto.akf.php");

function sanitizeData($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validateFileType($targetLogoFilePath){
    $fileType = pathinfo($targetLogoFilePath, PATHINFO_EXTENSION);
    // Allow certain file formats 
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', "pdf", "xlsx", "docs");
    return in_array($fileType, $allowTypes);
}

function createFolderIsNotExists($filePath = null){
    if ($filePath != null) {
        mkdir($filePath, 0777, true);
    }
}

function DBMaker($dbName, $tableName, $tableFields){
    $servername = "localhost"; // Change this to your MySQL server address
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error)
        return false;

    // Create database
    if ($conn->query("CREATE DATABASE IF NOT EXISTS $dbName") === TRUE) {
        // Connect to the newly created database
        $conn->select_db($dbName);

        // Create table
        $sqlCreateTable = ""; // Assuming an auto-incremented primary key
        foreach ($tableFields as $field)
            $sqlCreateTable .= " , $field VARCHAR(100)";

        $conn->query("CREATE TABLE IF NOT EXISTS $tableName (id INT AUTO_INCREMENT PRIMARY KEY $sqlCreateTable)");
    }

    return true;
}

function DBSwitcher($oldDBName, $dbName){
    $servername = "localhost"; // Change this to your MySQL server address
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $oldDBName);

    // Check connection
    if ($conn->connect_error)
        return false;

    $conn->query("RENAME DATABASE $oldDBName TO $dbName");

    return true;
}

?>