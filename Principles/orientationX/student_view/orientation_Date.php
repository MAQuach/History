<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
//connection noted as $db
require_once("../includes/db.php");
$testid = $_SESSION['id'];
$sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
$studentquery = mysqli_query($db,$sql);
$student = mysqli_fetch_assoc($studentquery);

?>







<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=800" /> 
        <title>Orientation Date</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
        <script src="js/studentView.js"></script>
    </head>





    <body id="student_view_body">
        <?php
        function registerUser($db, $orientationdate, $zNumber){   
            $studentsubsql = "";
            $datesql = 'SELECT * FROM orientationDates WHERE id='. $orientationdate .';';//retreive date by id
            $datequery = mysqli_query($db,$datesql);
            $row = mysqli_fetch_assoc($datequery);


            $registeredUpdate = $row['registered']+1;

            if ($row['students'] == NULL || $row['students'] == "" ){ //if no students registered for this date, just add the student's znumber
                $studentsubsql = 'UPDATE orientationDates SET students="'.$zNumber.'", registered = "'.$registeredUpdate.'" WHERE id='.$orientationdate.';';
            }
            else    //otherwise, append student's znumber to the end and update (separated by a comma so it can be exploded into an array)
            {
                $studentList = $row['students'];
                $studentArray = explode(",", $row['students']);
                if(!in_array( $zNumber, $studentArray)){
                    $studentList .= ','.$zNumber;
                    $studentsubsql = 'UPDATE orientationDates SET students="'.$studentList.'", registered = "'.$registeredUpdate.'" WHERE id='.$orientationdate.';';    
                }
            }

            if($studentsubsql != "")
            {
                $subquery = mysqli_query($db,$studentsubsql);
                if($subquery){
                    $studentregistersql = 'UPDATE OrientationStudents SET orientationDate="'.$orientationdate.'" WHERE zNumber='.$zNumber.';';
                    if(mysqli_query($db,$studentregistersql)){ //update students's entry with the date's index
                        echo "Registered Successfully!";
                    }else{
                        echo "ERROR HERE";
                        echo "Error Registering: ".mysqli_error($db);        
                    }
                }
                else
                {
                    echo "ERROR THERE";
                    echo "Error Registering: ".mysqli_error($db);
                }  
            }
            else
            {
                echo "Registered Successfully! [entry exists]";
            }
        }
        ?>



        <header class="student_header">

            <h2 class="term">Fall Orientation 2017 <br><span>Orientation Registration</span></h2>  
            <img class="logo_student_view" src="images/student_view_logo.svg">   
            
              <div class="button_panel">
            <a id="helpBtn" href="https://helpdesk.fau.edu/TDClient/Home/" target="_blank">Help Desk</a>
                
                        <!--JB: IF STUDENT CHOOSES TO LOGOUT THEIR INFOMATION WILL BE SAVED AND BE REDIRECTED TO LOGOUT PAGE TO GIVE CHECKLIST OF THINGS NEED TO DO AND DEADLINE -->
            <a href="logout_student.php" class="logout">Logout</a>
                
         </div>    
        </header>   

        <div class="student_container">

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
                        ?> !</h2>

                </div>

                <br>


                <!-- progressbar -->
                <div class="progressFormatting">
                    <ul id="progressbar">
                        <li class="active">Personal Info</li>
                        <li class="active">Questionnaire</li>
                        <li class="active">Orientation Date</li>
                        <li>Finalize</li>
                        <li>Pay</li>
                        <li>Confirmation</li>
                    </ul>
                </div>
                <!-- fieldsets -->


                <fieldset>
                    <br>
                    <br>
                    <h2 class="fs-title">PICK YOUR ORIENTATION DATE: </h2>
                    <h3 id="errormessage" class="fs-subtitle ">If date is full you cannot select it!</h3>
                    <br>
                    <div class="row">

                        <div class="col-sm-6">

                            <?php     //NEED TO WORK ON CHANGE DATE FUNCTIONALITY //NEVER MIND, FIXED IT
                            if(isset($_POST['submitdate']))
                            {
                                if($_POST['orientationdate'] == ""){ // if submitted with no value, refresh the page
                                    echo("<meta http-equiv='refresh' content='1'>"); //stack overflow says this refreshes the page.
                                }
                                else
                                {

                                    if ($student['orientationDate'] != NULL) // if student is already registered for a date
                                    {       
                                        $datesql = 'SELECT * FROM orientationDates WHERE id='.$student['orientationDate'].';'; //retrieve date student signed up for
                                        $datequery = mysqli_query($db,$datesql);
                                        $row = mysqli_fetch_assoc($datequery);
                                        $students = explode(",",$row['students']); //turn registered students string for the date into an array
                                        if(in_array($student['zNumber'],$students)){
                                            unset($students[array_search($student['zNumber'],$students)]); //remove student from the array
                                        }
                                        $studentString = implode(",",$students);//turn array back into a string
                                        $remdatesql = 'UPDATE orientationDates SET students="'.$studentString.'", registered="'. ($row['registered']-1) .'" WHERE id='.$student['orientationDate'].';';
                                        $remquery = mysqli_query($db,$remdatesql); //update date entry, decrement the number of registered students
                                    }

                                    registeruser($db,$_POST['orientationdate'],$student['zNumber']);
                                }
                            }
                            ?>


                            <form name="choosedate" id="chooseDate" method="post">          
                                <p class="date_header">Dates:</p> 
                                <select name="orientationdate" class="form-control" id="orientationdate">
                                    <option style="display:none;" selected value="">Pick a date: </option>
                                    <?php
                                     $campus =  $student['Campus'];
                                      $termyear = 2017;
                                      $datesql = "SELECT * FROM orientationDates WHERE campus='$campus' AND year >= $termyear;";
                                    $pop = mysqli_query($db,$datesql);
                                    if (mysqli_num_rows($pop) > 0){
                                        while($row = mysqli_fetch_assoc($pop)){ //populate the dropdown list with dates, if a date is at capacity, make it disabled
                                            $products = explode(',' , $row['orientationType']);
                                                          if ( ! isset($products[1])) {
                                                           $products[1] = null;
                                                        }
                                             $type = $student['studentcode'];
                                            if(in_array($type, $products))
                                            echo '<option value="'.$row['id'].'"'. ($row['registered'] >= $row['capacity'] ?'disabled':'') .'>'.$row['date'].'</option>';
                                            echo'</br>';
                                        }
                                    }
                                    ?>

                                </select>    
                                <button class="submit-button" type="submit" name="submitdate">Submit</button>
                                <a href="personal_info_EDIT.php" class="pickadate">NO DATES?</a>
                            </form>

                        </div>
                        <div class="col-sm-6">
                            <p class="date_header">Info:</p>     
                            <div id="result">



                            </div>    

                        </div>


                    </div>
                    <br><br>

                    <a href="questionnare.php" class="previous">Previous</a>
                    <!--                    <a href="finalize.php" class="next">Next</a>-->



                    <!--JB: THIS MAKES SURE THE USER IS NOT ALLOWED TO MOVE ON TO THE NEXT PAGE (finalize.PHP) UNTIL THEY PICK A DATE-->
                    <?php    
                    if(isset($_POST["submitdate"])){
                        $sql = "SELECT orientationDate FROM OrientationStudents WHERE id='".$testid."';";
                        $studentquery = mysqli_query($db,$sql);
                        $student = mysqli_fetch_assoc($studentquery);
                        if($student['orientationDate'] == true){
                            echo '<a href="finalize.php" class="next">Next</a>';
                        }
                        else{
                            echo "NULL";
                            echo '<input type="button" id="nextButton3" class="submit-button" value="Next" disabled="true">';

                        }
                    }
                    ?>





                </fieldset>
            </form>
        </div>   
    </body>    
</html>

<script>
    $("#orientationdate").change(function(){ 
        console.log($('#orientationdate').val());

        $("#result").load("dates.php #" + $('#orientationdate').val());
    });

</script>
