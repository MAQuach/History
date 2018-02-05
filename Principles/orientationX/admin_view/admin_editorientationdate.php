<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}

require_once("../includes/db.php");
$popsql = "";
?>


<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Administration</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/admin_css.css" rel="stylesheet">
    </head>

    <body>

        <div id="wrapper">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <div id="sidebar-wrapper">
                        <ul class="sidebar-nav">
                            <li>
                                <img src="logo-image.svg" class="img-responsive" alt="FAU logo">
                            </li>
                            <li>
                                <a href="admin_homepage.php">Home Page</a>
                            </li>
                            <li>
                                <a href="admin_archives.php">Archived Databases</a>
                            </li>
                            <li>
                                <a href="admin_setorientationdate.php">Create Orientation Date</a>
                            </li>
                            <li>
                                <a href="admin_editorientationdate.php">Edit Orientation Date</a>
                            </li>
                            <li>
                                <a href="admin_viewquestionnaire.php">View Questionnaire</a>
                            </li>
                            <li>
                                <a href="admin_edit_questionnaire.php">Edit Questionnaire</a>
                            </li>
                            <li>
                                <a href="admin_viewQuesAnswers.php">View Questionnaire Answers</a>
                            </li>
                            <li>
                                <a href="../student_view/logout_student.php" class="logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->


            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <h1>Edit Orientation Date</h1>
                    <br>
                    <br>


                    <form name="dateEdit" method="post">
                        <select name="editdate" class="form-control" id="orientationdate">
                            <option style="display:none;" selected value="">Pick a date</option>
                            <?php
                            $datesql = "SELECT * FROM orientationDates;";
                            $pop = mysqli_query($db,$datesql);
                            if (mysqli_num_rows($pop) > 0){
                                while($row = mysqli_fetch_assoc($pop)){ //populate the dropdown list with dates, if a date is at capacity, make it disabled
                                    echo '<option value="'.$row['id'].'"'. ($row['registered'] >= $row['capacity'] ?'disabled':'') .'>'.$row['date'].'</option>';
                                    echo'</br>';
                                }
                            }
                            ?>
                        </select>
                        <input type="submit" name='dateEdit'>
                    </form>
                    <br>


                    <form name="dateform" method="post">

                        <span>edit date selected:</span>
                        <br>

                        <?php
                        if(isset($_POST['dateEdit'])){

                            $editdate = intval($_POST["editdate"]); 
                            $popquery = "SELECT * FROM orientationDates WHERE id='$editdate'"; 
                            $result = mysqli_query($db, $popquery);
                            if($result){
                                $rowcount = mysqli_num_rows($result);
                                if ($rowcount>0){
                                    while($poprow = mysqli_fetch_assoc($result)){
                                        echo'<span><b>Campus:</b>'.$poprow['campus'].'</span>';
                                        echo '<br>';
                                        echo'<span><b>Date:</b> '.$poprow['date'].'</span>';
                                        echo '<br>';
                                        echo'<span><b>Start:</b> '.$poprow['start'].'</span>';
                                        echo '<br>';
                                        echo'<span><b>End:</b> '.$poprow['end'].'</span>';
                                        echo '<br>';
                                        echo'<span><b>Capacity:</b> '.$poprow['capacity'].'</span>';
                                        echo '<br>';
                                        echo'<span><b>Registered:</b> '.$poprow['registered'].'</span>';
                                        echo '<br>';
                                        echo'<span><b>Student Types Allowed:</b> '.$poprow['orientationType'].'</span>';
                                        echo '<br>';
                                        $idedit = $poprow['id'];
                                        echo'<span><input hidden type="text" name=id_edit value="'.$idedit.'"></span>';                       

                                    }
                                }else{
                                    echo "No Date Found!";
                                }
                            } 
                            else {       
                                echo "NOOOOOO".mysqli_error($db);
                            }  



                        }
                        ?>  



                        <?php
                        if(isset($_POST['dateSub'])){


                            $idmodify = intval($_POST["id_edit"]);    



                            if($_POST['fauCampus']){ 
                                $updatecampus = $_POST["fauCampus"];    
                                $updatesqlcampus = "UPDATE orientationDates SET campus ='$updatecampus' WHERE id = '$idmodify'";
                                $updatequerycampus = mysqli_query($db,$updatesqlcampus);
                                if($updatequerycampus){//insert into db
                                    echo"Campus modified<br>";


                                }else{
                                    echo 'ERROR'.mysqli_error($db);
                                }    


                            }    


                            if($_POST['orientationDate']){

                                $datearr = explode('-',$_POST['orientationDate']);//explode the date and assign each piece to a variable
                                $year =  $datearr[0];
                                $monthNum = $datearr[1];
                                $day =   $datearr[2];

                                if($monthNum<5){ //determine the term
                                    $term = "Spring";
                                }elseif ($monthNum>=5 && $monthNum<8){
                                    $term = "Summer";
                                }else{
                                    $term = "Fall";
                                }    


                                $updatesqlterm = "UPDATE orientationDates SET term ='$term' WHERE id = '$idmodify'";
                                $updatequeryterm = mysqli_query($db,$updatesqlterm);
                                if($updatequeryterm){//insert into db
                                    echo"Term modified<br>";


                                }else{
                                    echo 'ERROR'.mysqli_error($db);
                                }      


                                $dateObj   = DateTime::createFromFormat('!m', $monthNum); //convert month number to full name
                                $monthName = $dateObj->format('F'); 
                                $datestr = $monthName." ".$day.", ".$year;  
                                $updatesqldate = "UPDATE orientationDates SET date ='$datestr' WHERE id = '$idmodify'";
                                $updatequerydate = mysqli_query($db,$updatesqldate);
                                if($updatequerydate){//insert into db
                                    echo"Date modified<br>";


                                }else{
                                    echo 'ERROR'.mysqli_error($db);
                                }    



                            }

                            if($_POST['capacity']){ 
                                $updatecapacity = $_POST["capacity"];    
                                $updatesqlcapacity = "UPDATE orientationDates SET capacity ='$updatecapacity' WHERE id = '$idmodify'";
                                $updatequerycapacity = mysqli_query($db,$updatesqlcapacity);
                                if($updatequerycapacity){//insert into db
                                    echo"Capacity modified<br>";


                                }else{
                                    echo 'ERROR'.mysqli_error($db);
                                }    


                            }


                            if(isset($_POST['orientationType'])){ 
                                $studentTypes = implode(",", $_POST['orientationType']);
                                $updatesqlstudents = "UPDATE orientationDates SET orientationType ='$studentTypes' WHERE id = '$idmodify'";
                                $updatequerystudents = mysqli_query($db,$updatesqlstudents);
                                if($updatequerystudents){//insert into db
                                    echo"Student Types Allowed modified<br>";   
                                }


                            }

                            if($_POST['start']){ 
                                $timearrS = explode(':',$_POST['start']);
                                $timehrS = $timearrS[0];
                                $timeminS = $timearrS[1];
                                if($timehrS > 12){
                                    $timehrS = $timehrS - 12;

                                    $timeminS = $timeminS." PM";
                                }
                                else{
                                    if($timehrS == 0){
                                        $timehrS = 12;
                                        $timeminS = $timeminS." AM ";
                                    }
                                    elseif($timehrS == 12){
                                        $timeminS = $timeminS." PM ";
                                    }
                                    else{

                                        $timeminS = $timeminS." AM ";
                                    }

                                }
                                $timestringstart = $timehrS.":".$timeminS;


                                $updatesqlstart = "UPDATE orientationDates SET start ='$timestringstart' WHERE id = '$idmodify'";
                                $updatequerystart = mysqli_query($db,$updatesqlstart);
                                if($updatequerystart){//insert into db
                                    echo"Start time modified<br>";


                                }else{
                                    echo 'ERROR'.mysqli_error($db);
                                }  





                            } 

                            if($_POST['end']){ 
                                $timearrE = explode(':',$_POST['end']);
                                $timehrE = $timearrE[0];
                                $timeminE = $timearrE[1];
                                if($timehrE > 12){
                                    $timehrE = $timehrE - 12;
                                    $timeminE = $timeminE." PM";
                                }
                                else{
                                    if($timehrE == 0){
                                        $timehrE = 12;
                                        $timeminE = $timeminE." AM ";
                                    }
                                    elseif($timehrE == 12){
                                        $timeminE = $timeminE." PM ";
                                    }
                                    else{

                                        $timeminE = $timeminE." AM ";
                                    }

                                }
                                $timestringend = $timehrE.":".$timeminE;

                                $updatesqlend = "UPDATE orientationDates SET end ='$timestringend' WHERE id = '$idmodify'";
                                $updatequeryend = mysqli_query($db,$updatesqlend);
                                if($updatequeryend){//insert into db
                                    echo"End time modified<br>";


                                }else{
                                    echo 'ERROR'.mysqli_error($db);
                                }    


                            }



                        }
                        ?>                    


                        <br>
                        <h3>Campus:</h3>
                        <select size="1" class="form-control" name="fauCampus">
                            <option value="Boca Raton">Boca Raton</option>
                            <option value="Jupiter">Jupiter</option>
                            <option value="Davie">Davie</option>
                            <option value="Fort Lauderdale">Fort Lauderdale</option>
                            <option value="" selected></option>
                        </select>
                        <br>
                        <h3>Date:</h3>
                        <input class="form-control" type="date" name="orientationDate">
                        <br>
                        <h3>Time:</h3>
                        <span>start:</span>
                        <input class="form-control" type="time" name="start">
                        <span>end:</span>
                        <input class="form-control" type="time" name="end">
                        <br>
                        <h3> Select Student Type:</h3>
                        <br>
                        <div class="row">
                                                        <div class="col-sm-3"><input class="checkbox_style" type="checkbox" name="orientationType[]" value="B"><span class="label_text">Freshman</span><br></div>
                            <div class="col-sm-3"><input class="checkbox_style" type="checkbox" name="orientationType[]" value="J"><span class="label_text">Transfers</span><br></div>

                        </div>
                        <br>
                        <h3>Capacity:</h3>
                        <input size="1" class="form-control" type="text" name="capacity" placeholder="specify capacity...">
                        <br>
                        <input type="submit" name='dateSub'>
                    </form>




                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/popper/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    </body>

</html>
