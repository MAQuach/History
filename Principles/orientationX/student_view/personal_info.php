<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}

//connection noted as $db
require_once("../includes/db.php");

//testing id
$testid = $_SESSION['id'];
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=800" />
        <title>Personal Information</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type='text/javascript' src='http://code.jquery.com/jquery.min.js'></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
        <script src="js/studentView.js"></script>

    </head>


    <body id="student_view_body">

        <!--JB: HEADER OF WEBSITE-->

        <header class="student_header">

            <h2 class="term">

                <!--JB: SHOWS TERM AND YEAR IN TOP LEFT CORNER OF WHICH EVER STUDENT IS LOGGED IN-->
                <?php    
                $sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";
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

        </header>

        <!--JB: END HEADER OF WEBSITE-->

        <div class="student_container">

            <br><br><br><br><br><br><br>

            <!--JB: INSIDE STUDENT VIEW -->


            <!--JB: FORM FOR STUDENT TO CHOOSE CAMPUS AND SEE THEIR INFO -->

            <!--            <form id="msform" action="questionnare.php" method="post">-->
            <form id="msform" method="post">

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
                    
                                <div class="button_panel">
            <a id="helpBtn" href="https://helpdesk.fau.edu/TDClient/Home/" target="_blank">Help Desk</a>
                
                        <!--JB: IF STUDENT CHOOSES TO LOGOUT THEIR INFOMATION WILL BE SAVED AND BE REDIRECTED TO LOGOUT PAGE TO GIVE CHECKLIST OF THINGS NEED TO DO AND DEADLINE -->
            <a href="logout_student.php" class="logout">Logout</a>
                
                
            </div>

                </div>

                <br>

                <!-- progressbar -->
                <div id="positionProgress">
                    <div class="progressFormatting">
                        <ul id="progressbar">
                            <li class="active">Personal Info</li>
                            <li>Questionnaire</li>
                            <li>Orientation Date</li>
                            <li>Finalize</li>
                            <li>Pay</li>
                            <li>Confirmation</li>
                        </ul>
                    </div>
                </div>

                <!-- fieldsets -->
                <fieldset>   
                <h2 class="fs-title">Personal Info Section</h2>
                <h3 id="errormessage" class="fs-subtitle ">*Please review the information and choose which campus you would like to attend orientation at. Campus choice will affect which orientation dates you can register for!</h3>
                <div class="personal_info_static">
                    <span id="studentType">Credit Standing:</span>
                     <!--JOE: DETERMINING THE STUDENT'S CREDIT STANDING BASED ON CREDITS IN DATATABLE -->
                    <?php    
                    $sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
                    $studentquery = mysqli_query($db,$sql);
                    $student=mysqli_fetch_assoc($studentquery);
                    if($student){
                    if ($student['credits']<30){
                        echo "<span id='creditStanding'>Freshman</span>";}
                    if ($student['credits']>=30 && $student['credits']<60){
                        echo "<span id='creditStanding'>Sophomore</span>";}
                    if ($student['credits']>=60 && $student['credits']<90){
                        echo "<span id='creditStanding'>Junior</span>";}
                    if ($student['credits']>=90){
                        echo "<span id='creditStanding'>Senior</span>";}
                        }else{
                            echo"Unable to Retrieve from Database";}
                    ?>
                 </div> 
                
                    
                <div class="personal_info_static">            
                <span id="studentType">Residency Type:</span>
                <!--JOE: DETERMINING THE STUDENT'S RESIDENCY BASED ON CODE IN THE DATATABLE -->
                <?php
                if($student){
                    switch($student['residency']){
                        case"F":
                            echo "<span id='residency'>Florida Resident</span>";
                            break;
                        case"N":
                            echo "<span id='residency'>Non-Florida Resident</span>";
                            break;
                        case"R":
                            echo "<span id='residency'>Florida Resident Alien</span>";
                            break;
                        case"T":
                            echo "<span id='residency'>Florida Resident Special Category</span>";
                            break;
                        case"A":
                            echo "<span id='residency'>Non-Resident Alien</span>";
                            break;
                        case"E":
                            echo "<span id='residency'>Non-Florida Resident Alien</span>";
                            break;
                    }
                }
                ?>    
                </div>   
                    
                    
                <div class="personal_info_static">
                <span id="studentType">Semester:</span>
                <!--JOE: PULL SEMESTER AND YEAR FOR THE STUDENT FROM DATA TABLE -->
                <?php
                if ($student){
                    echo "<span id='semester_info'>".$student['semesterTerm']." ".$student['termYear'];
                }
                ?>    
                </div>    
                
                <div class="personal_info_static">    
                <span id="studentType">College:</span>
                 <!--JOE: PULL COLLEGE FOR THE STUDENT FROM THE DATA TABLE -->
                <?php
                if ($student){
                    echo "<span id='college'>".$student['college'];
                }
                ?>    
                </div>   
                    
                <div class="personal_info_static">    
                <span id="studentType">Major:</span>
                 <!--JOE: PULL MAJOR FOR THE STUDENT FROM THE DATA TABLE -->
                <?php
                if ($student){
                    echo "<span id='major'>".$student['major'];
                }
                ?>    
                </div>       
                    
                <div class="personal_info_static">   
                <span id="studentType">Campus:</span>
                            <!--JB: STUDENT SELECTS THE DESIRED CAMPUS -->
                            <div id="campusChooser">
                                <select class="form-control" name="fauCampus">
                                    <option value="Boca Raton">Boca Raton</option>
                                    <option value="Jupiter">Jupiter</option>
                                    <option value="Davie">Davie</option>
                                    <option value="Fort Lauderdale">Fort Lauderdale</option>
                                </select>
                            </div>
                </div> 
                     
        

                    <!--JB: SUBMIT DESIRED CAMPUS -->

                    
                    <div id="row">
                        <div class="col-sm-6">
                        <input type="submit" id="campusSave" class="submit-button" value="Save">
                            <!-- <input type="button" id="nextButton" class="submit-button" value="Next" onclick="window.location='questionnare.php'">-->
                    <!--JB: SUBMIT BUTTON UPDATES DATATABLE WITH STUDENT'S CHOICE OF CAMPUS-->
                            
                            
                        <?php
                        if(isset($_POST["fauCampus"])){
                        $updatesql = 'UPDATE OrientationStudents SET Campus="'.$_POST['fauCampus'].'"WHERE id='.$testid.';';
                        if(mysqli_query($db,$updatesql)){
                            echo" ";
                        }else{
                            echo"error".mysqli_error($db);
                        }
                        }
                        ?>        
                        </div>
                        <div class="col-sm-6">
                         <!--JB: THIS MAKES SURE THE USER IS NOT ALLOWED TO MOVE ON TO THE NEXT PAGE (QUESTIONNARE.PHP) UNTIL THEY PICK A CAMPUS-->
                    <?php    
                    if(isset($_POST["fauCampus"])){
                        $sql = "SELECT Campus FROM OrientationStudents WHERE id='".$testid."';";
                        $studentquery = mysqli_query($db,$sql);
                        $student = mysqli_fetch_assoc($studentquery);
                        if($student == false || $student == 0){
                            echo '<input type="button" id="nextButton1" class="next" value="Next" disabled="true">';
                        }
                        if($student == true || $student == 1){
                            echo '<input type="button" id="nextButton1" class="next" value="Next">';

                        }
                    }
                    ?>    
                        </div>    
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
</html>