<?php

function guid()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double) microtime() * 10000); 
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); 
        $uuid   = chr(123) 
            . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12) . chr(125); // "}"
        return $uuid;
    }
    
}


function generateUid($length = 2)
{
    $characters       = '0123456789';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>