<?php
session_start();
function authUser2($user, $pass){
    require_once("includes/db.php");
    $retrievesql = "SELECT * FROM OrientationStudents WHERE username='".$user."';";
    $retquery = mysqli_query($db,$retrievesql);
    $userrow = mysqli_fetch_assoc($retquery);
    if(!count($userrow)){
        echo 'invalid Credentials';
    }elseif(count($userrow) >= 1){
        if ($userrow['password'] == $pass){
            $_SESSION['id'] = $userrow['ID'];
            echo "Login successful! Redirecting...";
            header("location: student_view/student_landing.php"); //"location: http://lamp.cse.fau.edu/~jdhoman2014/orientation/student_view/student_landing.php");
            die();   
        }else{
            echo 'Invalid credentials.';
        }
    }
}   

function authAdmin($user, $pass){
    require_once("includes/db.php");
    $retrievesql = "SELECT * FROM AdminUsers WHERE username='".$user."';";
    $retquery = mysqli_query($db,$retrievesql);
    $userrow = mysqli_fetch_assoc($retquery);
    if(!count($userrow)){
        echo 'invalid Credentials';
    }elseif(count($userrow) >= 1){
        if ($userrow['password'] == $pass){
            $_SESSION['id'] = $userrow['ID'];
            $_SESSION['admin'] = True;
            echo "Login successful! Redirecting...";
            header("location: admin_view/admin_homepage.php"); //"location: http://lamp.cse.fau.edu/~jdhoman2014/orientation/student_view/student_landing.php");
            die();   
        }else{
            echo 'Invalid credentials.';
        }
    }
}


if (isset($_POST['studentSubmit'])){
    authUser2 ($_POST['studentuser'], $_POST['studentpwd']);
}

if (isset($_POST['adminSubmit'])){
    authAdmin ($_POST['adminuser'], $_POST['adminpwd']);
}

?>




<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial scale=1.0">   
        <title>Login Orientation FAU</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>   
        <div class="background-image"></div>
        <div class="tint"></div>  

        <div class="login_container">
            <div> 
                <div class="login_header">
                    <img id="logo" src="images/fau_login_logo.png"><p class="text-primary" id="text_header">
                    Owl Atlas Orientation Login</p>     
                </div>    
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#studentlogin">Student</a></li>
                    <li><a data-toggle="tab" href="#adminlogin">Admin</a></li>
                </ul>
                <div class="tab-content">
                    <div id="studentlogin" class="tab-pane fade in active">
                        <form name="studentForm" method="post">
                            <h3>Username</h3><input type="text" name="studentuser" placeholder="Username/E-mail">
                            <br>
                            <h3>Password</h3><input type="password" name="studentpwd" placeholder="Password">
                            <br>
                            <button class="btn btn-primary"type="submit" name="studentSubmit">Login</button>
                        </form>
                        <span class="login_footer"> 
                            <h4>Need a login?</h4>    
                            <a href="https://accounts.fau.edu/">Retrieve Account</a>
                        </span>  
                    </div>
                    <div id="adminlogin" class="tab-pane fade">  
                        <form name="adminForm" method="post">
                            <h3>Username</h3><input type="text" name="adminuser" placeholder="Username/E-mail">
                            <br>
                            <h3>Password</h3><input type="password" name="adminpwd" placeholder="Password">
                            <br>
                            <button class="btn btn-primary" type="submit" name="adminSubmit">Login</button>
                        </form>
                        <span class="login_footer"> 
                            <h4>Need a login?</h4>    
                            <a href="signup.php">Retrieve Account</a>
                        </span>  
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>