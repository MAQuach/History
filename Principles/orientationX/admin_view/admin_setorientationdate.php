<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
require_once("../includes/db.php");
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
                                <a href="../student_view/logout_student.php" class="logout">Logout</a>                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->


            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <h1>Create Orientation Date</h1>
                    <br>
                    <br>

                    <?php
                    if(isset($_POST['dateSub'])){
                        if($_POST['orientationDate']&&$_POST['fauCampus']&&$_POST['orientationType']&&$_POST['start']&&$_POST['end']){
                            $datearr = explode('-',$_POST['orientationDate']);//explode the date and assign each piece to a variable
                            $year =  $datearr[0];
                            $monthNum = $datearr[1];
                            $day =   $datearr[2];

                            if($_POST['capacity']){ //if capacity declared, use it. otherwise default to 50
                                $capacity = $_POST['capacity'];
                            }else{
                                $capacity = 200;
                            }

                            if($monthNum<5){ //determine the term
                                $term = "Spring";
                            }elseif ($monthNum>=5 && $monthNum<8){
                                $term = "Summer";
                            }else{
                                $term = "Fall";
                            }

                            if($_POST['orientationType']){ 
                                $studentTypes = implode(",", $_POST['orientationType']);
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
                            }



                            $dateObj   = DateTime::createFromFormat('!m', $monthNum); //convert month number to full name
                            $monthName = $dateObj->format('F'); 
                            $datestr = $monthName." ".$day.", ".$year;

                            //echo $_POST['orientationType'][0];
                            $insertsql = "INSERT INTO orientationDates (date, term, year, campus, orientationType,capacity,start,end) VALUES(";
                            $insertsql .= "'".$datestr."','".$term."','".$year."','".$_POST['fauCampus']."','".$studentTypes."','".$capacity."','".$timestringstart."','".$timestringend."');";//construct sql query
                            //echo '<h1>'.$insertsql.'</h1>';
                            $insertquery = mysqli_query($db,$insertsql);
                            if($insertquery){//insert into db
                                echo"Date successfully submitted";
                            }else{
                                echo 'ERROR'.mysqli_error($db);
                            }
                        }
                    }else{ //if not all fields set
                        echo "All Fields Mandatory";
                    }
                    ?>

                    <form name="dateform" method="post">
                        <h3>Campus:</h3>
                        <select size="1" class="form-control" name="fauCampus">
                            <option value="Boca Raton">Boca Raton</option>
                            <option value="Jupiter">Jupiter</option>
                            <option value="Davie">Davie</option>
                            <option value="Fort Lauderdale">Fort Lauderdale</option>
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
                        <input size="1" class = "form-control"type="text" name="capacity" placeholder="specify capacity...">       
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
