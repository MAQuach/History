<?php
session_start();
session_destroy();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=800" /> 
        <title>Logout</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
    </head>





    <body id="student_view_body">
        <header class="student_header">

            <h2 class="term">Fall Orientation 2017 <br><span>Orientation Registration</span></h2>  

            <img class="logo_student_view" src="images/student_view_logo.svg">    

        </header>   


        <div class="student_container_logout">
                <div id="logout_block">
                <h2 class="counter">
                    Logout Successful!</h2>   
                
                 <p style="text-align: center;"><a id="returnlogin" href="../index.php"> Return to Login</a></p>
            </div>





        </div>   


    </body>    