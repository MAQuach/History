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
        <title>Finalize Selections</title>    
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

            <div class="button_panel">
                <a id="helpBtn" href="https://helpdesk.fau.edu/TDClient/Home/" target="_blank">Help Desk</a>

                <!--JB: IF STUDENT CHOOSES TO LOGOUT THEIR INFOMATION WILL BE SAVED AND BE REDIRECTED TO LOGOUT PAGE TO GIVE CHECKLIST OF THINGS NEED TO DO AND DEADLINE -->
                <a href="logout_student.php" class="logout">Logout</a>

            </div>    

        </header>  

        <div class="student_container">


            <?php
            if(isset($_POST['finalizeButton'])){

                //echo "<h2>ASDFASDFDFASDFA</h2>";
                $finalizesql = "UPDATE OrientationStudents SET finalized='Completed' WHERE ID='".$student['ID']."';"; 
                $finalizequery = mysqli_query($db, $finalizesql);                
                if($finalizequery){
                    echo "Submitted successfully.";
                    header("Location: pay_TouchNet.php"); /* Redirect browser */
                    exit();
                }else{
                    echo"ERROR: ".mysqli_error($db);
                }
            }
            ?>



            <!--JB: FORM FOR STUDENT TO SEE WHAT THEY HAVE TO GET DONE -->

            <br><br><br><br><br><br><br>

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

                </div>

                <br>


                <!-- progressbar -->
                <div class="progressFormatting">
                    <ul id="progressbar">
                        <li class="active">Personal Info</li>
                        <li class="active">Questionnaire</li>
                        <li class="active">Orientation Date</li>
                        <li class="active">Finalize</li>
                        <li>Pay</li>
                        <li>Confirmation</li>
                    </ul>
                </div>
                <!-- fieldsets -->


                <!--JB: HERE THE STUDENT CAN SEE SOME OF THE CHOICES THEY MADE AND IF THEY WANT TO EDIT THOSE CHOICES -->
                <fieldset>


                    <h2 class="fs-title">Finalize Your Choices</h2>
                    <h3 class="fs-subtitle">If you would like to change a response, please click the "Edit" button.</h3>
                    <br><br>

                    <!--JB: DISPLAY FROM THE DATATABLE THE CAMPUS THEY CHOSE -->
                    <span id="studentType">Desired Campus:</span>
                    <?php
                    if ($student['Campus'] == "BocaRaton"){ //print the campus, if it's weird looking print it properly
                        echo "<span id='campus'>Boca Raton</span>";
                    }else if ($student['Campus'] == "FortLauderdale"){
                        echo "<span id='campus'>Fort Lauderdale</span>";
                    }else{
                        echo "<span id='campus'>".$student['Campus']."</span>";
                    }
                    ?>

                    <a href="personal_info_EDIT.php" class="edit">Edit</a>


                    <br>
                    <br>
                    <br>

                    <!--JB: IF STUDENT ONCE TO CHANGE ANSWERS FOR QUESTIONNAIRE THEY GO TO THE QUESTIONAIRE PAGE -->

                    <span id="studentType">Questionnaire Answers</span>
                    <?php
                    $questionarray = [];
                    $responsearray = [];
                    $questionsql = "SELECT * FROM questions"; 
                    $responsesql = "SELECT * FROM QuestionnaireAnswers where id='".$student['zNumber']."';";
                    $questionquery = mysqli_query($db, $questionsql); //get all questions
                    $responsequery = mysqli_query($db, $responsesql); //get all answers
                    while($Qrow=mysqli_fetch_assoc($questionquery)){
                        $questionarray[]=$Qrow['questionText']; //put questions into an array
                    }
                    $QCount = count($questionarray);
                    $Rrow=mysqli_fetch_assoc($responsequery);
                    $responsearray[] = $Rrow; //put answers into an array (kinda)

                    foreach($responsearray as $row){
                        for($j=0;$j<$QCount;$j++){ //iterate and print through both
                            echo "<p>Question: ".$questionarray[$j]."</p> </br>";
                            echo "<p>Response: ".$row['Ques'.(string)($j+1)]."</p> </br>";
                        }
                    }
                    ?>

                    <a href="questionnare_EDIT.php" class="edit">Edit</a>
                    <br>
                    <br>
                    <br>

                    <!--JB: DISPLAY CHOSEN ORIENTATION DATE -->

                    <span id="studentType">Orientation Date:</span>
                    <?php
                    if ($student){ //get date for student, print date from datetable
                        $datesql = "SELECT * FROM orientationDates WHERE id='".$student['orientationDate']."';";
                        $datequery = mysqli_query($db, $datesql);
                        $daterow = mysqli_fetch_assoc($datequery);
                        echo "<span id='timeDate'>".$daterow['date']."</span>";
                    }
                    ?>
                    <a href="orientation_Date_EDIT.php" class="edit">Edit</a>
                    <br>
                    <br>
                    <button name="finalizeButton" id="finalizeButton" class="submit-button" onclick="showNext()">Save</button>
                    <a href="orientation_Date.php" class="previous">Previous</a>


                    <div id="FinalizeNext" style="display:none;">

                        <a href="pay_TouchNet.php" class="submit-button">Next</a>
                    </div>


                </fieldset>

            </form>



        </div>   





    </body>    