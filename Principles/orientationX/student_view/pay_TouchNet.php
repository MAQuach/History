<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
//connection noted as $db
require_once("../includes/db.php");
$testid = $_SESSION['id'];
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=800" /> 
        <title>Personal Information</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
        <script src="js/studentView.js"></script>
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
                    echo "<span id='semester'>".$student['semesterTerm']." ".$student['termYear'];

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
                        ?>!</h2>

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
                        <li>Confirmation</li>
                    </ul>
                </div>
                <!-- fieldsets -->
                <fieldset>

                    <!--JB: USER IS DIRECTED TO TOUCHNET AND THEN PAYS AND STATUS IS SHOWN HERE IF THEY HAVE PAID OR NOT-->

                    <h2 class="fs-title"><a href="pay1.php">Click here to be redirected to TouchNet.</a></h2>

                    
                     <!--JB: THIS MAKES SURE THE USER IS NOT ALLOWED TO MOVE ON TO THE NEXT PAGE (confirmation.PHP) UNTIL THEY "PAY"-->
                    <?php
                    if($student['paid'] == "no"){
                        echo "<p>Not Paid</p>";
                        echo '<input type="button" class="submit-button" value="Next" disabled="true">';
                    }
                    else if ($student['paid'] == "yes"){
                        echo "<p>Payment received!</p>";
                        echo '<a href="confirmation.php" class="submit-button">Next</a>';
                    }

                    ?>

                    <a href="finalize.php" class="previous">Previous</a>
<!--                    <a href="confirmation.php" class="next">Next</a>-->
                


                </fieldset>

            </form>



        </div>   





    </body>    
</html>