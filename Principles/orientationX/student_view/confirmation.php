<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
//connection noted as $db
require_once("../includes/db.php");
$testid =  $_SESSION['id'];
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Confirmation</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/confirmation.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="js/studentView.js"></script>
        <script src="js/confirmation.js"></script>

    </head>





    <body id="student_view_body">
        <header class="student_header">

            <h2 class="term">

                <!--JB: SHOWS TERM AND YEAR IN TOP LEFT CORNER OF WHICH EVER STUDENT IS LOGGED IN-->

                <?php    
                $sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
                $studentquery = mysqli_query($db,$sql);
                $student=mysqli_fetch_assoc($studentquery);
                if($student){
                    if ($student){
                        echo "<span id='semester'>".$student['semesterTerm']." ".$student['termYear'];
                    }
                }else{
                    echo"Unable to Retrieve from Database";
                }
                ?>


                <br><span>Orientation Registration</span></h2>
            <img class="logo_student_view" src="images/student_view_logo.svg">
            
                                      <div class="button_panel">
            <a id="helpBtn" href="https://helpdesk.fau.edu/TDClient/Home/" target="_blank">Help Desk</a>
                
                        <!--JB: IF STUDENT CHOOSES TO LOGOUT THEIR INFOMATION WILL BE SAVED AND BE REDIRECTED TO LOGOUT PAGE TO GIVE CHECKLIST OF THINGS NEED TO DO AND DEADLINE -->
            <a href="logout_student.php" class="logout">Logout</a>

    

            </div>
        </header>  


        <div class="student_container">

            <br><br><br><br><br><br><br>

            <!--JB: FORM THAT SHOWS CHECKLIST FOR STUDENT-->

            <form id="msform">
                
                <div id="name">
                    <!--JB: SHOWS NAME OF WHICH EVER STUDENT IS LOGGED IN-->
                    <h2>Welcome <?php    
                        $sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
                        $studentquery = mysqli_query($db,$sql);
                        $student=mysqli_fetch_assoc($studentquery);
                        if($student){
                            if ($student){
                                echo "<span id='name'>".$student['firstname']." ".$student['lastname'];
                            }
                        }else{
                            echo"Unable to Retrieve from Database";
                        }
                        ?> !</h2>

                </div>

                <br>
                
                <!-- progressbar -->
                <div class="progressFormatting">
                    <ul id="progressbar">
                        <li class="active">Personal Info</li>
                        <li class="active">Questionnaire</li>
                        <li class="active">Orientation Date</li>
                        <li class="active">Finalize</li>
                        <li class="active">Pay</li>
                        <li class="active">Confirmation</li>
                    </ul>
                </div>
                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title">You are all set!</h2>
                    <h3 class="fs-subtitle">Check List:</h3>

                    <i class="fa fa-check"></i> Chosen Campus
                    <br>
                    <br>


                    <i class="fa fa-check"></i> Filled out questionnaire
                    <br>
                    <br>

                    <i class="fa fa-check"></i> Pick an Orientation Date
                    <br>
                    <br>

                    <i class="fa fa-check"></i> Paid on TouchNet
                    <br>
                    <br>

<!--                    <a href="pay_TouchNet.php" class="previous">Previous</a>-->
                    <input type='button' class='rab' value='Done'>


                </fieldset>

            </form>



        </div>   

        <div class='customAlert'>
            <p class='message'></p>
            <a href="logout_student.php" class="confirmButton">Yay!</a>
        </div>




    
    </body>    