<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}

//connection noted as $db
require_once("../includes/db.php");
$testid = 2;
$popsql = "";
?>


<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="icon" href="fauowl.gif" type="image/gif" sizes="16x16">
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
                    <h1>View Answers</h1>
                    <div class="container">  
                            <div class="dropdown">

                            <form name="filterForm" method="post" class="form-inline">
                                <select name="zNumber" class="form-control">
                                    <option class="dropdown-item" value="">zNumber</option>
                                    <?php
                                    $yearsql = "SELECT DISTINCT zNumber FROM OrientationStudents ORDER BY zNumber;";
                                    $yearquery = mysqli_query($db, $yearsql);
                                    if ($yearquery){
                                        while ($yearrow = mysqli_fetch_assoc($yearquery)){
                                            echo '<option class="dropdown-item" value="'.$yearrow['zNumber'].'">'.$yearrow['zNumber'].'</option>';  //displays year...maybe...
                                        }
                                    } else {
                                        echo "NOOOOOO".mysqli_error($db);
                                    }
                                    ?>
                                </select>


                                <button name="filterButton" class="next btn btn-primary" type="submit">Filter</button>
                            </form>                                

                                
                        </div>
                        
                        <p></p>        
                        <p></p>
                        
                        
                         <?php
                        if(isset($_POST['filterButton'])){
                            
                            $studentNumber = $_POST['zNumber'];
                            $popsql = "SELECT * FROM QuestionnaireAnswers WHERE id = '$studentNumber';";
                            
                        
                        }
                        ?>
                        
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ZNumber</th>
                                    <th>Ques1</th>
                                    <th>Ques2</th>
                                    <th>Ques3</th>
                                    <th>Ques4</th>
                                    <th>Ques5</th>
                                    <th>Ques6</th>
                                    <th>Ques7</th>
                                    <th>Ques8</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!$popsql){

                                $popsql = "SELECT * FROM QuestionnaireAnswers;";
                                }
                                $popquery = mysqli_query($db, $popsql);
                                if($popquery){
                                    $rowcount = mysqli_num_rows($popquery);
                                    if ($rowcount>0){
                                        echo $rowcount . " student(s) found";
                                        while($poprow = mysqli_fetch_assoc($popquery)){
                                            echo'<tr>';
                                            echo'<td>'.$poprow['ID'].'</td>';
                                            echo'<td>'.$poprow['Ques1'].'</td>';
                                            echo'<td>'.$poprow['Ques2'].'</td>';
                                            echo'<td>'.$poprow['Ques3'].'</td>';
                                            echo'<td>'.$poprow['Ques4'].'</td>';
                                            echo'<td>'.$poprow['Ques5'].'</td>';
                                            echo'<td>'.$poprow['Ques6'].'</td>';
                                            echo'<td>'.$poprow['Ques7'].'</td>';
                                            echo'<td>'.$poprow['Ques8'].'</td>';
                                        }
                                    }else{
                                        echo "No Students Found!";
                                    }
                                } 
                                else {
                                    echo "NOOOOOO".mysqli_error($db);
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
