<?php
// Do not change the following two lines.
$teamURL = dirname($_SERVER['PHP_SELF']) . DIRECTORY_SEPARATOR;
$server_root = dirname($_SERVER['PHP_SELF']);

// You will need to require this file on EVERY php file that uses the database.
// Be sure to use $db->close(); at the end of each php file that includes this!

$dbhost = 'localhost';  // Most likely will not need to be changed
$dbname = 'jdhoman2014';   // Needs to be changed to your designated table database name
$dbuser = 'jdhoman2014';   // Needs to be changed to reflect your LAMP server credentials
$dbpass = 'J94tJ3anrp'; // Needs to be changed to reflect your LAMP server credentials

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if($db->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}

function checkUserByUsername ($username){
    $sql = 'SELECT * FROM OrientationStudents WHERE username=?';

    $stmt = $db->prepare ($sql);

    $stmt->execute ([$username]);

    $user = $stmt->fetchAll();

    if(count ($user) == 1){
        return $user;
    }
    return null;
}

function authUser ($username, $password){
    $user = checkUserByUsername ($username);

    if(! empty($user)){
        if (password_verify ($password, $user[0]['password'])){
            return true;
        }
        else{
            return false;
        }
    }

    return false;
}

