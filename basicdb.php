<?php
/*
 from https://stackoverflow.com/questions/1330693/validate-username-as-alphanumeric-with-underscores
 Allowed keys are alphnumeric and underscore. 
 */
function validate_alphanumeric_underscore($str)
{
    if (preg_match('/^[a-zA-Z0-9_]+$/', $str) === 1) {
        return true;
    }
    return false;
}

/* 
Allowed modes are get (retrieve a value) and put (add a value) 
*/
$mode = $_GET["mode"] ?? false;
if ($mode === false) {
    echo "ERROR: Mode not set.";
    exit();
}
$allowed_modes = array("put", "get");
if (in_array($mode, $allowed_modes) === false) {
    echo "ERROR: Mode not allowed.";
}

$key = $_GET["key"] ?? false;
if (validate_alphanumeric_underscore($key) === false) {
    echo "ERROR: Wrong key has been used.";
    exit();
}

$foldername = "data";
$savefile = $foldername . "/" . $key; 
if ($mode == "put") {
    $data = $_GET["data"] ?? false;

    if (!file_exists($foldername)) {
        mkdir($foldername);
    }
    if (@file_put_contents($savefile, $data) === false) { 
        echo "ERROR: Data could not be saved"; 
        exit(); 
    }
    echo "ok"; 
} else if($mode == "get") { 
    $ret = @file_get_contents($savefile); 
    if($ret === false ) { 
        echo "ERROR: data not found"; 
    } else { 
        echo $ret; 
    }

}
