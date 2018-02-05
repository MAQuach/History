<?php 

$username = $_POST['username'];
$password = $_POST['password'];

require_once("../includes/db.php");

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if (authUser ($username, $password)){
    
    echo "Login successful! Redirecting...";
    header("location: http://lamp.cse.fau.edu/~jdhoman2014/orientation/student_view/student_landing.php");
    die();
    
}
else{
    die("Invalid credentials.");
}

