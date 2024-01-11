/*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: Gigshare Backend using core php
* Created: 2024-01-11 14:27:37
 Last Modification Date: 2024-01-11 14:51:02
**/
<?php

define("PREFIX_BEARER", "webBearer::->");

function generateToken(string $str){
    // this method return user token with md5 encoded;
    if (empty($str))
        throw new Exception("Invalid arguments!!!.");

    $token = base64_encode(base64_encode(base64_encode($str)));
    $token = base64_encode(PREFIX_BEARER . $token);
    return $token;
}

function extractToken(string $str){
    // this method return user token with md5 encoded;
    if (empty($str))
        throw new Exception("Invalid arguments!!!.");
    $token_decoded = base64_decode($str);

    if (strpos($token_decoded, PREFIX_BEARER) < 0)
        throw new Exception("Invalid token key!!!.");
    $tokenKey = substr($token_decoded, strlen(PREFIX_BEARER), strlen($token_decoded) - 1);
    $token = base64_decode(base64_decode(base64_decode($tokenKey)));
    return $token;
}


?>